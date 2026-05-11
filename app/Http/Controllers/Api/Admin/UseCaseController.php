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
            'tags' => 'nullable|array',
        ]);

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
        ]);

        $useCase->update($data);
        return response()->json(['status' => 'success', 'data' => $useCase]);
    }

    public function destroy($id)
    {
        UseCase::findOrFail($id)->delete();
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
