<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => Section::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'title' => 'nullable|array',
            'subtitle' => 'nullable|array',
            'badge' => 'nullable|array',
            'button_text' => 'nullable|array',
            'button_direction' => 'nullable|string',
        ]);

        $section = Section::create($data);
        return response()->json(['status' => 'success', 'data' => $section], 201);
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        $data = $request->validate([
            'type' => 'nullable|string',
            'title' => 'nullable|array',
            'subtitle' => 'nullable|array',
            'badge' => 'nullable|array',
            'button_text' => 'nullable|array',
            'button_direction' => 'nullable|string',
        ]);

        $section->update($data);
        return response()->json(['status' => 'success', 'data' => $section]);
    }

    public function destroy($id)
    {
        Section::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Section deleted']);
    }
}
