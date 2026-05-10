<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    /**
     * Get all industries with their features and related projects.
     */
    public function index()
    {
        $industries = Industry::with(['features', 'projects.features', 'media'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $industries
        ]);
    }

    /**
     * Get Industry with its features and related projects by industry_id.
     */
    public function show($id)
    {
        $industry = Industry::with(['features', 'projects.features', 'media'])->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $industry
        ]);
    }
}
