<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    /**
     * Get All FAQ Categories.
     */
    public function index()
    {
        $categories = FaqCategory::all();
        return response()->json(['status' => 'success', 'data' => $categories]);
    }

    /**
     * Get specific FAQ category details.
     */
    public function show($id)
    {
        $category = FaqCategory::with('faqs')->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $category]);
    }

    /**
     * Add FAQ Category.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'description' => 'nullable|array',
            'icon' => 'nullable|string',
        ]);

        $category = FaqCategory::create($data);

        return response()->json(['status' => 'success', 'data' => $category], 201);
    }

    /**
     * Edit FAQ Category.
     */
    public function update(Request $request, $id)
    {
        $category = FaqCategory::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'icon' => 'nullable|string',
        ]);

        $category->update($data);

        return response()->json(['status' => 'success', 'data' => $category]);
    }

    /**
     * Delete FAQ Category.
     */
    public function destroy($id)
    {
        $category = FaqCategory::findOrFail($id);
        $category->delete();

        return response()->json(['status' => 'success', 'message' => 'Category deleted successfully']);
    }
}
