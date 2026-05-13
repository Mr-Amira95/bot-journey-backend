<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiSubpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AiSubpointController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => AiSubpoint::all()]);
    }

    public function show($id)
    {
        return response()->json(['status' => 'success', 'data' => AiSubpoint::findOrFail($id)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'description' => 'nullable|array',
            'icon' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        }

        $item = AiSubpoint::create($data);
        return response()->json(['status' => 'success', 'data' => $item], 201);
    }

    public function update(Request $request, $id)
    {
        $item = AiSubpoint::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'icon' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('icon')) {
            if ($item->icon) {
                Storage::disk('public')->delete($item->icon);
            }
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        } else {
            unset($data['icon']);
        }

        $item->update($data);
        return response()->json(['status' => 'success', 'data' => $item]);
    }

    public function destroy($id)
    {
        $item = AiSubpoint::findOrFail($id);
        if ($item->icon) {
            Storage::disk('public')->delete($item->icon);
        }
        $item->delete();
        return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
    }
}

