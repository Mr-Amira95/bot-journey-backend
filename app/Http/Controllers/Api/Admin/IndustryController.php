<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\IndustryFeature;
use App\Models\IndustryMedia;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    /**
     * Get all industries with all related details.
     */
    public function index()
    {
        $industries = Industry::with(['features', 'projects.features', 'media'])->get();
        return response()->json(['status' => 'success', 'data' => $industries]);
    }

    /**
     * Get specific industry details.
     */
    public function show($id)
    {
        $industry = Industry::with(['features', 'projects.features', 'media'])->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $industry]);
    }

    /**
     * Add industry with features.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'description' => 'nullable|array',
            'tagline' => 'nullable|array',
            'color' => 'nullable|string',
            'icon_path' => 'nullable|string',
            'features' => 'nullable|array',
            'media' => 'nullable|array',
        ]);

        $industry = Industry::create($data);

        if ($request->has('features')) {
            foreach ($request->features as $feature) {
                $industry->features()->create(['key' => $feature]);
            }
        }

        if ($request->has('media')) {
            foreach ($request->media as $path) {
                $industry->media()->create(['media_path' => $path]);
            }
        }

        return response()->json(['status' => 'success', 'data' => $industry->load(['features', 'media'])], 201);
    }

    /**
     * Edit Industry.
     */
    public function update(Request $request, $id)
    {
        $industry = Industry::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'tagline' => 'nullable|array',
            'color' => 'nullable|string',
            'icon_path' => 'nullable|string',
        ]);

        $industry->update($data);

        return response()->json(['status' => 'success', 'data' => $industry]);
    }

    /**
     * Delete Industry by id.
     */
    public function destroy($id)
    {
        $industry = Industry::findOrFail($id);
        $industry->delete();

        return response()->json(['status' => 'success', 'message' => 'Industry deleted successfully']);
    }

    /**
     * Delete Feature by industry_id and feature_id.
     */
    public function deleteFeature($industry_id, $feature_id)
    {
        $feature = IndustryFeature::where('industry_id', $industry_id)->findOrFail($feature_id);
        $feature->delete();

        return response()->json(['status' => 'success', 'message' => 'Industry feature deleted successfully']);
    }

    /**
     * Delete media by industry_id and media_id.
     */
    public function deleteMedia($industry_id, $media_id)
    {
        $media = IndustryMedia::where('industry_id', $industry_id)->findOrFail($media_id);
        $media->delete();

        return response()->json(['status' => 'success', 'message' => 'Industry media deleted successfully']);
    }
}
