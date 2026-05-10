<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Get List of FAQ grouped by category with nullable search param.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $categories = FaqCategory::with(['faqs' => function ($query) use ($search) {
            if ($search) {
                $query->where('question', 'LIKE', "%{$search}%")
                      ->orWhere('answer', 'LIKE', "%{$search}%");
            }
        }])
        ->whereHas('faqs', function($query) use ($search) {
            if ($search) {
                $query->where('question', 'LIKE', "%{$search}%")
                      ->orWhere('answer', 'LIKE', "%{$search}%");
            }
        })
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
}
