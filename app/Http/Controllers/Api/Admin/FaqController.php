<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Get All FAQ grouped by category.
     */
    public function index()
    {
        $categories = FaqCategory::with('faqs')->get();
        return response()->json(['status' => 'success', 'data' => $categories]);
    }

    /**
     * Add FAQ.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|array',
            'answer' => 'required|array',
            'featured' => 'nullable|boolean',
            'media' => 'nullable|string',
        ]);

        $faq = Faq::create($data);

        return response()->json(['status' => 'success', 'data' => $faq], 201);
    }

    /**
     * Edit FAQ.
     */
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $data = $request->validate([
            'category_id' => 'nullable|exists:faq_categories,id',
            'question' => 'nullable|array',
            'answer' => 'nullable|array',
            'featured' => 'nullable|boolean',
            'media' => 'nullable|string',
        ]);

        $faq->update($data);

        return response()->json(['status' => 'success', 'data' => $faq]);
    }

    /**
     * Delete FAQ.
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json(['status' => 'success', 'message' => 'FAQ deleted successfully']);
    }
}
