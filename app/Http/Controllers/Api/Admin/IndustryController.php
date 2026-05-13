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
            'icon_path' => 'nullable|file|max:10240',
            'features' => 'nullable|array',
            'media' => 'nullable|array',
            'media.*' => 'file|max:10240',
        ]);

        if ($request->hasFile('icon_path')) {
            $data['icon_path'] = $request->file('icon_path')->store('industries/icons', 'public');
        }

        $industry = Industry::create($data);

        if ($request->has('features')) {
            foreach ($request->features as $feature) {
                $industry->features()->create(['key' => $feature]);
            }
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('industries/media', 'public');
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
            'icon_path' => 'nullable|file|max:10240',
            'features' => 'nullable|array',
            'media' => 'nullable|array',
            'media.*' => 'file|max:10240',
        ]);

        if ($request->hasFile('icon_path')) {
            if ($industry->icon_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($industry->icon_path);
            }
            $data['icon_path'] = $request->file('icon_path')->store('industries/icons', 'public');
        } else {
            unset($data['icon_path']);
        }

        $industry->update($data);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('industries/media', 'public');
                $industry->media()->create(['media_path' => $path]);
            }
        }

        if ($request->has('features')) {
            $industry->features()->delete();
            foreach ($request->features as $feature) {
                $industry->features()->create(['key' => $feature]);
            }
        }

        return response()->json(['status' => 'success', 'data' => $industry->load(['features', 'media'])]);
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
        \Illuminate\Support\Facades\Storage::disk('public')->delete($media->media_path);
        $media->delete();

        return response()->json(['status' => 'success', 'message' => 'Industry media deleted successfully']);
    }
}
