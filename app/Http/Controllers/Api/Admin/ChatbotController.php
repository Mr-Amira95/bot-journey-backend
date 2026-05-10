<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotMessage;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Delete all chatbot messages for a specific session_id.
     */
    public function deleteMessages(Request $request)
    {
        $request->validate([
            'session_id' => 'required',
        ]);

        ChatbotMessage::where('session_id', $request->session_id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => "All messages for session '{$request->session_id}' have been deleted."
        ]);
    }

    /**
     * Get all chatbot messages grouped by session_id.
     */
    public function getAllMessages()
    {
        $sessions = ChatbotMessage::orderBy('created_at', 'desc')
            ->get()
            ->groupBy('session_id');

        return response()->json([
            'status' => 'success',
            'data' => $sessions
        ]);
    }
}
