<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Faq;

class ChatbotService
{
    /**
     * Generate a response based on conversation history.
     *
     * @param iterable $messages
     * @return string
     */
    public function respond(iterable $messages): string
    {
        $startTime = microtime(true);

        $faqs = Faq::all();
        $faqPrompt = "Available FAQs:\n";
        foreach ($faqs as $faq) {
            $faqPrompt .= "- Question: " . json_encode($faq->question) . "\n";
            $faqPrompt .= "  Answer: " . json_encode($faq->answer) . "\n\n";
        }

        $prompt = "
            You are a friendly and professional assistant for 'Bot Journey'. 
            
            Your Knowledge Base (FAQ):
            $faqPrompt

            Strict Instructions:
            1. ONLY answer questions using the information provided in the FAQ above. 
            2. If a user asks something NOT covered in the FAQ, politely inform them that you don't have that specific information and suggest they contact support or ask about topics available in the FAQ.
            3. Be warm, friendly, and helpful.
            4. Keep your responses short, clear, and direct.
            5. For general greetings or short questions, answer briefly and then proactively suggest related topics or inquiries from the FAQ to guide the user.
            6. Always respond in the same language the user uses (Arabic or English).
            7. Do not hallucinate or provide information outside of the provided FAQ.
        ";

        $key = config('openai.api_key');

        // Format messages for OpenAI
        $formattedMessages = [
            ['role' => 'system', 'content' => $prompt]
        ];

        foreach ($messages as $msg) {
            $formattedMessages[] = [
                'role' => $msg['role'] === 'bot' ? 'assistant' : 'user',
                'content' => $msg['message']
            ];
        }

        $response = Http::withToken($key)
            ->post(config('openai.base_url') . '/chat/completions', [
                'model' => config('openai.model'),
                'messages' => $formattedMessages,
                'temperature' => 0.5,
            ]);

        $usage = $response->json('usage', []);
        $model = config('openai.model');

        $pricing = [
            'gpt-4o' => ['input' => 2.50, 'output' => 10.00],
            'gpt-4.1' => ['input' => 2.50, 'output' => 10.00], // Fallback pricing
        ];

        $inputPrice = $pricing[$model]['input'] ?? 2.50;
        $outputPrice = $pricing[$model]['output'] ?? 10.00;
        $cost = ($usage['prompt_tokens'] * $inputPrice + $usage['completion_tokens'] * $outputPrice) / 1000000;

        $endTime = microtime(true);

        \Log::channel('daily')->info('OpenAI API Usage', [
            'model' => $model,
            'prompt_tokens' => $usage['prompt_tokens'] ?? 0,
            'completion_tokens' => $usage['completion_tokens'] ?? 0,
            'estimated_cost_usd' => round($cost, 6),
            'response_time_seconds' => round($endTime - $startTime, 3),
        ]);

        $rawReply = $response->json('choices.0.message.content', 'Sorry, I had trouble generating a response.');
        $cleanReply = preg_replace("/\r|\n/", '', $rawReply);

        return $cleanReply;
    }
}
