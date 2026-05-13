<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiStatistic;
use Illuminate\Http\Request;

class AiStatisticController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => AiStatistic::all()]);
    }

    public function show($id)
    {
        return response()->json(['status' => 'success', 'data' => AiStatistic::findOrFail($id)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'value' => 'required|string',
            'label' => 'required|array',
        ]);

        $item = AiStatistic::create($data);
        return response()->json(['status' => 'success', 'data' => $item], 201);
    }

    public function update(Request $request, $id)
    {
        $item = AiStatistic::findOrFail($id);
        $data = $request->validate([
            'value' => 'nullable|string',
            'label' => 'nullable|array',
        ]);

        $item->update($data);
        return response()->json(['status' => 'success', 'data' => $item]);
    }

    public function destroy($id)
    {
        $item = AiStatistic::findOrFail($id);
        $item->delete();
        return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
    }
}
