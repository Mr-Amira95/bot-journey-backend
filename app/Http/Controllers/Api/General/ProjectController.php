<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Get All Projects with their features and industry.
     */
    public function index()
    {
        $projects = Project::with(['features', 'industry', 'media'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }

    /**
     * Get Project with its features and industry.
     */
    public function show($id)
    {
        $project = Project::with(['features', 'industry', 'media'])->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $project
        ]);
    }
}
