<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Get All Blogs.
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        return response()->json(['status' => 'success', 'data' => $blogs]);
    }

    /**
     * Add blog.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'content' => 'required|array',
            'read_time' => 'nullable|string',
        ]);

        $blog = Blog::create($data);

        return response()->json(['status' => 'success', 'data' => $blog], 201);
    }

    /**
     * Edit Blog.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|array',
            'content' => 'nullable|array',
            'read_time' => 'nullable|string',
        ]);

        $blog->update($data);

        return response()->json(['status' => 'success', 'data' => $blog]);
    }

    /**
     * Delete Blog.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json(['status' => 'success', 'message' => 'Blog deleted successfully']);
    }
}
