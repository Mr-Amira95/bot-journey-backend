<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Services\ChatbotService;
use App\Models\ChatbotMessage;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $chatbotService;

    /**
     * ChatbotController constructor.
     *
     * @param ChatbotService $chatbotService
     */
    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * Specific chatbot interaction logic.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'required',
        ]);

        // 1. Save user message
        ChatbotMessage::create([
            'session_id' => $request->session_id,
            'message' => $request->message,
            'role' => 'user',
        ]);

        // 2. Fetch conversation history
        $messages = ChatbotMessage::where('session_id', $request->session_id)
            ->orderBy('created_at', 'asc')
            ->get(['message', 'role']);

        // 3. Get response from service
        $reply = $this->chatbotService->respond($messages);

        // 4. Save bot message
        $botMessage = ChatbotMessage::create([
            'session_id' => $request->session_id,
            'message' => $reply,
            'role' => 'bot',
        ]);

        return response()->json([
            'id' => $botMessage->id,
            'message' => $botMessage->message,
            'role' => $botMessage->role,
            'created_at' => $botMessage->created_at,
        ]);
    }

    public function getMessages(Request $request)
    {
        $request->validate([
            'session_id' => 'required',
        ]);

        $messages = ChatbotMessage::where('session_id', $request->session_id)
            ->orderBy('created_at', 'asc')
            ->get(['id', 'message', 'role', 'created_at']);

        return response()->json($messages);
    }
}
