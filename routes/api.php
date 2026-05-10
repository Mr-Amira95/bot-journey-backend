<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\PasswordResetController as AdminPasswordResetController;
use App\Http\Controllers\Api\Admin\ChatbotController as AdminChatbotController;
use App\Http\Controllers\Api\Admin\IndustryController as AdminIndustryController;
use App\Http\Controllers\Api\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\Admin\FaqCategoryController as AdminFaqCategoryController;
use App\Http\Controllers\Api\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Api\General\ChatbotController;
use App\Http\Controllers\Api\General\IndustryController;
use App\Http\Controllers\Api\General\ProjectController;
use App\Http\Controllers\Api\General\FaqController;

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

        // Industry Admin Routes
        Route::apiResource('industries', AdminIndustryController::class);
        Route::delete('industries/{industry}/features/{feature}', [AdminIndustryController::class, 'deleteFeature']);
        Route::delete('industries/{industry}/media/{media}', [AdminIndustryController::class, 'deleteMedia']);

        // Project Admin Routes
        Route::apiResource('projects', AdminProjectController::class);
        Route::delete('projects/{project}/features/{feature}', [AdminProjectController::class, 'deleteFeature']);
        Route::delete('projects/{project}/media/{media}', [AdminProjectController::class, 'deleteMedia']);

        // FAQ Admin Routes
        Route::apiResource('faq-categories', AdminFaqCategoryController::class);
        Route::apiResource('faqs', AdminFaqController::class);
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

    // Public Industries & Projects Routes
    Route::get('/industries', [IndustryController::class, 'index']);
    Route::get('/industries/{id}', [IndustryController::class, 'show']);
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);

    // FAQ Routes
    Route::get('/faqs', [FaqController::class, 'index']);
});
