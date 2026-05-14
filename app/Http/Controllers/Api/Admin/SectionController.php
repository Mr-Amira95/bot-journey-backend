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

    public function show($type)
    {
        return response()->json(['status' => 'success', 'data' => Section::where('type', $type)->firstOrFail()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:hero,how_it_works,industries,why_botjourney,cta,blog,faq,projects,agentic_ai,mobile',
            'title' => 'nullable|array',
            'subtitle' => 'nullable|array',
            'badge' => 'nullable|array',
            'button_text' => 'nullable|array',
            'button_direction' => 'nullable|string',
        ]);

        $section = Section::create($data);
        return response()->json(['status' => 'success', 'data' => $section], 201);
    }

    public function update(Request $request, $type)
    {
        $section = Section::where('type', $type)->firstOrFail();
        $data = $request->validate([
            'type' => 'nullable|in:hero,how_it_works,industries,why_botjourney,cta,blog,faq,projects,agentic_ai,mobile',
            'title' => 'nullable|array',
            'subtitle' => 'nullable|array',
            'badge' => 'nullable|array',
            'button_text' => 'nullable|array',
            'button_direction' => 'nullable|string',
        ]);

        $section->update($data);
        return response()->json(['status' => 'success', 'data' => $section]);
    }

    public function destroy($type)
    {
        Section::where('type', $type)->firstOrFail()->delete();
        return response()->json(['status' => 'success', 'message' => 'Section deleted']);
    }
}
