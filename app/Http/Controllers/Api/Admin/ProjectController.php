<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectMedia;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Get all projects with all related details.
     */
    public function index()
    {
        $projects = Project::with(['features', 'industry', 'media'])->get();
        return response()->json(['status' => 'success', 'data' => $projects]);
    }

    /**
     * Get specific project details.
     */
    public function show($id)
    {
        $project = Project::with(['features', 'industry', 'media'])->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $project]);
    }

    /**
     * Add Project with features and media.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'title' => 'required|array',
            'description' => 'nullable|array',
            'outcome_value' => 'nullable|string',
            'outcome_label' => 'nullable|array',
            'color' => 'nullable|string',
            'icon_path' => 'nullable|file|max:10240',
            'features' => 'nullable|array',
            'media' => 'nullable|array',
            'media.*' => 'file|max:10240',
        ]);

        if ($request->hasFile('icon_path')) {
            $data['icon_path'] = $request->file('icon_path')->store('projects/icons', 'public');
        }

        $project = Project::create($data);

        if ($request->has('features')) {
            foreach ($request->features as $feature) {
                $project->features()->create(['key' => $feature]);
            }
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('projects/media', 'public');
                $project->media()->create(['media_path' => $path]);
            }
        }

        return response()->json(['status' => 'success', 'data' => $project->load(['features', 'media', 'industry'])], 201);
    }

    /**
     * Edit Project.
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $data = $request->validate([
            'industry_id' => 'nullable|exists:industries,id',
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'outcome_value' => 'nullable|string',
            'outcome_label' => 'nullable|array',
            'color' => 'nullable|string',
            'icon_path' => 'nullable|file|max:10240',
            'features' => 'nullable|array',
            'media' => 'nullable|array',
            'media.*' => 'file|max:10240',
        ]);

        if ($request->hasFile('icon_path')) {
            if ($project->icon_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($project->icon_path);
            }
            $data['icon_path'] = $request->file('icon_path')->store('projects/icons', 'public');
        } else {
            unset($data['icon_path']);
        }

        $project->update($data);

        if ($request->has('features')) {
            $project->features()->delete();
            foreach ($request->features as $feature) {
                $project->features()->create(['key' => $feature]);
            }
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('projects/media', 'public');
                $project->media()->create(['media_path' => $path]);
            }
        }

        return response()->json(['status' => 'success', 'data' => $project]);
    }

    /**
     * Delete Project By id.
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['status' => 'success', 'message' => 'Project deleted successfully']);
    }

    /**
     * Delete Feature by project_id and feature_id.
     */
    public function deleteFeature($project_id, $feature_id)
    {
        $feature = ProjectFeature::where('project_id', $project_id)->findOrFail($feature_id);
        $feature->delete();

        return response()->json(['status' => 'success', 'message' => 'Project feature deleted successfully']);
    }

    /**
     * Delete Media by project_id and media_id.
     */
    public function deleteMedia($project_id, $media_id)
    {
        $media = ProjectMedia::where('project_id', $project_id)->findOrFail($media_id);
        \Illuminate\Support\Facades\Storage::disk('public')->delete($media->media_path);
        $media->delete();

        return response()->json(['status' => 'success', 'message' => 'Project media deleted successfully']);
    }
}
