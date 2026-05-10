<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\PasswordResetController as AdminPasswordResetController;
use App\Http\Controllers\Api\Admin\ChatbotController as AdminChatbotController;
use App\Http\Controllers\Api\General\ChatbotController;

// Admin API Routes
Route::prefix('admin')->group(function () {
    // Public routes
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/send-code', [AdminPasswordResetController::class, 'sendCode']);
    Route::post('/verify-code', [AdminPasswordResetController::class, 'verifyCode']);
    Route::post('/reset-password', [AdminPasswordResetController::class, 'resetPassword']);

    // Protected routes
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/profile', [AdminAuthController::class, 'profile']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        
        // Add more admin protected routes here
        Route::get('/chatbot/sessions', [AdminChatbotController::class, 'getAllMessages']);
        Route::delete('/chatbot/messages', [AdminChatbotController::class, 'deleteMessages']);
    });
});

// General API Routes
Route::prefix('general')->group(function () {
    // Add general public/protected routes here
    Route::get('/ping', function () {
        return response()->json(['message' => 'pong']);
    });

    // Chatbot Routes
    Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage']);
    Route::get('/chatbot/messages', [ChatbotController::class, 'getMessages']);
});
