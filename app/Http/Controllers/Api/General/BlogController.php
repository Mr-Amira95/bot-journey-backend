<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Get all blogs.
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        return response()->json(['status' => 'success', 'data' => $blogs]);
    }

    /**
     * Get specific blog details.
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $blog]);
    }
}
