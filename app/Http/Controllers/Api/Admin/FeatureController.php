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

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'stat_value' => 'nullable|string',
            'stat_suffix' => 'nullable|array',
            'stat_description' => 'nullable|array',
            'points' => 'nullable|array',
        ]);

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
        ]);

        $feature->update($data);
        return response()->json(['status' => 'success', 'data' => $feature]);
    }

    public function destroy($id)
    {
        Feature::findOrFail($id)->delete();
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
