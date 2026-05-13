<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\UseCase;
use App\Models\UseCaseTag;
use Illuminate\Http\Request;

class UseCaseController extends Controller
{
    public function index()
    {
        $useCases = UseCase::with('tags')->get();
        return response()->json(['status' => 'success', 'data' => $useCases]);
    }

    public function show($id)
    {
        return response()->json(['status' => 'success', 'data' => UseCase::with('tags')->findOrFail($id)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'description' => 'nullable|array',
            'icon' => 'nullable|file|max:10240',
            'tags' => 'nullable|array',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        }

        $useCase = UseCase::create($data);

        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                $useCase->tags()->create(['tag' => $tag]);
            }
        }

        return response()->json(['status' => 'success', 'data' => $useCase->load('tags')], 201);
    }

    public function update(Request $request, $id)
    {
        $useCase = UseCase::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'icon' => 'nullable|file|max:10240',
            'tags' => 'nullable|array',
        ]);

        if ($request->hasFile('icon')) {
            if ($useCase->icon) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($useCase->icon);
            }
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        } else {
            unset($data['icon']);
        }

        $useCase->update($data);

        if ($request->has('tags')) {
            $useCase->tags()->delete();
            foreach ($request->tags as $tag) {
                $useCase->tags()->create(['tag' => $tag]);
            }
        }

        return response()->json(['status' => 'success', 'data' => $useCase->load('tags')]);
    }

    public function destroy($id)
    {
        $useCase = UseCase::findOrFail($id);
        if ($useCase->icon) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($useCase->icon);
        }
        $useCase->delete();
        return response()->json(['status' => 'success', 'message' => 'Use case deleted']);
    }

    public function addTag(Request $request, $use_case_id)
    {
        $useCase = UseCase::findOrFail($use_case_id);
        $data = $request->validate(['tag' => 'required|array']);
        $tag = $useCase->tags()->create($data);
        return response()->json(['status' => 'success', 'data' => $tag]);
    }

    public function deleteTag($use_case_id, $tag_id)
    {
        $tag = UseCaseTag::where('use_case_id', $use_case_id)->findOrFail($tag_id);
        $tag->delete();
        return response()->json(['status' => 'success', 'message' => 'Tag deleted']);
    }
}
