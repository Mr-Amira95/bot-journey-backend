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
        Route::apiResource('sections', AdminSectionController::class)->parameters(['sections' => 'type']);
        
        Route::apiResource('features', AdminFeatureController::class);
        Route::post('features/{feature}/points', [AdminFeatureController::class, 'addPoint']);
        Route::delete('features/{feature}/points/{point}', [AdminFeatureController::class, 'deletePoint']);

        Route::apiResource('workflows', AdminWorkflowController::class);
        
        Route::apiResource('use-cases', AdminUseCaseController::class);
        Route::post('use-cases/{use_case}/tags', [AdminUseCaseController::class, 'addTag']);
        Route::delete('use-cases/{use_case}/tags/{tag}', [AdminUseCaseController::class, 'deleteTag']);

        Route::apiResource('processes', AdminProcessController::class);

        Route::apiResource('ai-subpoints', \App\Http\Controllers\Api\Admin\AiSubpointController::class);
        Route::apiResource('ai-statistics', \App\Http\Controllers\Api\Admin\AiStatisticController::class);

        // Site Settings
        Route::get('settings', [\App\Http\Controllers\Api\Admin\SettingController::class, 'index']);
        Route::post('settings', [\App\Http\Controllers\Api\Admin\SettingController::class, 'update']);

        // Contact Forms
        Route::get('contact-forms', [\App\Http\Controllers\Api\Admin\ContactFormController::class, 'index']);
        Route::delete('contact-forms/{id}', [\App\Http\Controllers\Api\Admin\ContactFormController::class, 'destroy']);

        // Databricks Page Content
        Route::get('databricks/sections', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'getSections']);
        Route::post('databricks/sections', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'updateSections']);
        
        Route::get('databricks/services', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'getServices']);
        Route::post('databricks/services', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'storeService']);
        Route::post('databricks/services/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'updateService']);
        Route::delete('databricks/services/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'destroyService']);

        Route::get('databricks/use-cases', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'getUseCases']);
        Route::post('databricks/use-cases', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'storeUseCase']);
        Route::post('databricks/use-cases/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'updateUseCase']);
        Route::delete('databricks/use-cases/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'destroyUseCase']);

        Route::get('databricks/stats', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'getStats']);
        Route::post('databricks/stats', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'storeStat']);
        Route::post('databricks/stats/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'updateStat']);
        Route::delete('databricks/stats/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'destroyStat']);

        Route::get('databricks/partner-points', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'getPartnerPoints']);
        Route::post('databricks/partner-points', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'storePartnerPoint']);
        Route::post('databricks/partner-points/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'updatePartnerPoint']);
        Route::delete('databricks/partner-points/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'destroyPartnerPoint']);

        Route::get('databricks/trust-signals', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'getTrustSignals']);
        Route::post('databricks/trust-signals', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'storeTrustSignal']);
        Route::post('databricks/trust-signals/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'updateTrustSignal']);
        Route::delete('databricks/trust-signals/{id}', [\App\Http\Controllers\Api\Admin\DatabricksPageController::class, 'destroyTrustSignal']);
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
    Route::get('/ai-subpoints', [ContentController::class, 'getAiSubpoints']);
    Route::get('/ai-statistics', [ContentController::class, 'getAiStatistics']);
    Route::get('/settings', [\App\Http\Controllers\Api\General\ContentController::class, 'getSettings']);

    // Contact Form
    Route::post('/contact', [\App\Http\Controllers\Api\General\ContactFormController::class, 'store']);

    // Databricks Page Dynamic Content
    Route::get('/databricks-page', [\App\Http\Controllers\Api\General\DatabricksController::class, 'getPageContent']);
});
