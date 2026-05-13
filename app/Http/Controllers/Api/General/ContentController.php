<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Feature;
use App\Models\Workflow;
use App\Models\UseCase;
use App\Models\Process;
use App\Models\AiSubpoint;
use App\Models\AiStatistic;
use App\Models\Industry;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Get all landing page content grouped by type.
     */
    public function getLandingPageContent()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'sections' => Section::all()->groupBy('type'),
                'features' => Feature::with('points')->get(),
                'workflows' => Workflow::orderBy('order')->get(),
                'use_cases' => UseCase::with('tags')->get(),
                'processes' => Process::all(),
                'ai_subpoints' => AiSubpoint::all(),
                'ai_statistics' => AiStatistic::all(),
                'industries' => Industry::with(['features', 'media'])->get(),
            ]
        ]);
    }

    /**
     * Get specific sections by type.
     */
    public function getSectionsByType($type)
    {
        $sections = Section::where('type', $type)->get();
        return response()->json(['status' => 'success', 'data' => $sections]);
    }

    /**
     * Get all features.
     */
    public function getFeatures()
    {
        return response()->json(['status' => 'success', 'data' => Feature::with('points')->get()]);
    }

    /**
     * Get all workflows.
     */
    public function getWorkflows()
    {
        return response()->json(['status' => 'success', 'data' => Workflow::orderBy('order')->get()]);
    }

    /**
     * Get all use cases.
     */
    public function getUseCases()
    {
        return response()->json(['status' => 'success', 'data' => UseCase::with('tags')->get()]);
    }

    /**
     * Get all processes.
     */
    public function getProcesses()
    {
        return response()->json(['status' => 'success', 'data' => Process::all()]);
    }

    /**
     * Get all AI Subpoints.
     */
    public function getAiSubpoints()
    {
        return response()->json(['status' => 'success', 'data' => AiSubpoint::all()]);
    }

    /**
     * Get all AI Statistics.
     */
    public function getAiStatistics()
    {
        return response()->json(['status' => 'success', 'data' => AiStatistic::all()]);
    }

    /**
     * Get Site Settings.
     */
    public function getSettings()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        return response()->json(['status' => 'success', 'data' => $settings]);
    }
}
