<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Blog::all(),
        ]);
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(BlogRequest $request): JsonResponse
    {
        $blog = Blog::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Blog created successfully',
            'data' => $blog
        ], 201);
    }

    /**
     * Display the specified blog.
     */
    public function show(Blog $blog): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'blog' => $blog,
                'posts' => $blog->posts
            ]
        ]);
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(BlogRequest $request, Blog $blog): JsonResponse
    {
        $blog->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Blog updated successfully',
            'data' => $blog
        ]);
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog): JsonResponse
    {
        $blog->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog deleted successfully'
        ]);
    }
}
