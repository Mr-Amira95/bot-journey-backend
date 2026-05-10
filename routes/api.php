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
use App\Http\Controllers\Api\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Api\Admin\SectionController as AdminSectionController;
use App\Http\Controllers\Api\Admin\FeatureController as AdminFeatureController;
use App\Http\Controllers\Api\Admin\WorkflowController as AdminWorkflowController;
use App\Http\Controllers\Api\Admin\UseCaseController as AdminUseCaseController;
use App\Http\Controllers\Api\Admin\ProcessController as AdminProcessController;
use App\Http\Controllers\Api\General\ChatbotController;
use App\Http\Controllers\Api\General\IndustryController;
use App\Http\Controllers\Api\General\ProjectController;
use App\Http\Controllers\Api\General\FaqController;
use App\Http\Controllers\Api\General\BlogController;
use App\Http\Controllers\Api\General\ContentController;

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

        // Blog Admin Routes
        Route::apiResource('blogs', AdminBlogController::class);

        // Landing Page Content Admin Routes
        Route::apiResource('sections', AdminSectionController::class);
        
        Route::apiResource('features', AdminFeatureController::class);
        Route::post('features/{feature}/points', [AdminFeatureController::class, 'addPoint']);
        Route::delete('features/{feature}/points/{point}', [AdminFeatureController::class, 'deletePoint']);

        Route::apiResource('workflows', AdminWorkflowController::class);
        
        Route::apiResource('use-cases', AdminUseCaseController::class);
        Route::post('use-cases/{use_case}/tags', [AdminUseCaseController::class, 'addTag']);
        Route::delete('use-cases/{use_case}/tags/{tag}', [AdminUseCaseController::class, 'deleteTag']);

        Route::apiResource('processes', AdminProcessController::class);
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

    // Blog Routes
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/{id}', [BlogController::class, 'show']);

    // Content Routes
    Route::get('/landing-page', [ContentController::class, 'getLandingPageContent']);
    Route::get('/sections/{type}', [ContentController::class, 'getSectionsByType']);
    Route::get('/features', [ContentController::class, 'getFeatures']);
    Route::get('/workflows', [ContentController::class, 'getWorkflows']);
    Route::get('/use-cases', [ContentController::class, 'getUseCases']);
    Route::get('/processes', [ContentController::class, 'getProcesses']);
});
