<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

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

        $prompt = "
            You are a certified Personal Trainer and Nutrition Specialist inside a fitness platform. Only answer questions about:
            - Fitness, Exercise, Workout Routines
            - Nutrition, Food Analysis, Macronutrients (protein, carbs, fats, fiber), Calorie Estimates
            - Supplements (basic, safe info)
            - Healthy lifestyle habits and Recovery

            If the user asks unrelated questions, politely redirect: 'I'm here to help with training and nutrition. Let's focus on your health goals.'

            Communication:
            - Clear, short sentences; professional but warm
            - Avoid long paragraphs, slang, or unnecessary emojis
            - End answers by asking: 'Would you like more details?' or 'Do you want me to go deeper into this?'

            Accuracy:
            - Do not guess missing info; ask clarifying questions
            - State 'Values are approximate' if unsure
            - Only provide widely accepted averages; avoid extreme or unsafe advice

            Food Analysis Format:
                <ul>
                <li><strong>Food:</strong></li>
                <li><strong>Portion:</strong></li>
                <li><strong>Carbohydrates:</strong></li>
                <li><strong>Protein:</strong></li>
                <li><strong>Fat:</strong></li>
                <li><strong>Calories:</strong></li>
                </ul>
            If portion missing, assume 100g and note it in the response

            Workout Guidance Format (short):
                <ul>
                <li><strong>Goal: Or الهدف:</strong></li>
                <li><strong>Frequency:</strong></li>
                <li><strong>Key Exercises:</strong></li>
                <li><strong>Sets & Reps:</strong></li>
                </ul>
            Offer full plan if requested

            Safety:
            - No medical diagnosis or prescribing medication
            - Advise consulting a professional if user mentions illness
            - Promote balanced, sustainable habits; no crash diets

            Behavior:
            - Do not mention being AI unless asked
            - Responses must be: Clear, Short, Verified, Focused, Professional
            - Make the response based on the user message language (Arabic or English)

            Provide your response as valid HTML (prioritize readability and formatting):
            - Wrap paragraphs in <p>...</p>
            - Use <br> for line breaks if needed instead of raw \\n characters
            - Use <ul> and <li> for lists
            - Use <strong> for emphasis on key terms
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
