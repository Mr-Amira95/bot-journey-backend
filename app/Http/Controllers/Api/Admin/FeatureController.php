<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\FeaturePoint;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::with('points')->get();
        return response()->json(['status' => 'success', 'data' => $features]);
    }

    public function show($id)
    {
        return response()->json(['status' => 'success', 'data' => Feature::with('points')->findOrFail($id)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'stat_value' => 'nullable|string',
            'stat_suffix' => 'nullable|array',
            'stat_description' => 'nullable|array',
            'icon' => 'nullable|file|max:10240',
            'points' => 'nullable|array',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        }

        $feature = Feature::create($data);

        if ($request->has('points')) {
            foreach ($request->points as $point) {
                $feature->points()->create(['key' => $point]);
            }
        }

        return response()->json(['status' => 'success', 'data' => $feature->load('points')], 201);
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|array',
            'stat_value' => 'nullable|string',
            'stat_suffix' => 'nullable|array',
            'stat_description' => 'nullable|array',
            'icon' => 'nullable|file|max:10240',
            'points' => 'nullable|array',
        ]);

        if ($request->hasFile('icon')) {
            if ($feature->icon) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($feature->icon);
            }
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        } else {
            unset($data['icon']);
        }

        $feature->update($data);

        if ($request->has('points')) {
            $feature->points()->delete();
            foreach ($request->points as $point) {
                $feature->points()->create(['key' => $point]);
            }
        }

        return response()->json(['status' => 'success', 'data' => $feature->load('points')]);
    }

    public function destroy($id)
    {
        $feature = Feature::findOrFail($id);
        if ($feature->icon) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($feature->icon);
        }
        $feature->delete();
        return response()->json(['status' => 'success', 'message' => 'Feature deleted']);
    }

    public function addPoint(Request $request, $feature_id)
    {
        $feature = Feature::findOrFail($feature_id);
        $data = $request->validate(['key' => 'required|array']);
        $point = $feature->points()->create($data);
        return response()->json(['status' => 'success', 'data' => $point]);
    }

    public function deletePoint($feature_id, $point_id)
    {
        $point = FeaturePoint::where('feature_id', $feature_id)->findOrFail($point_id);
        $point->delete();
        return response()->json(['status' => 'success', 'message' => 'Point deleted']);
    }
}
