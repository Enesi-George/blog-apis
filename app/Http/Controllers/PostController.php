<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Blog;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the posts for a specific blog.
     */
    public function index(Blog $blog): JsonResponse
    {
        $posts = $blog->posts;

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(PostRequest $request, Blog $blog): JsonResponse
    {
        $post = $blog->posts()->create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully',
            'data' => $post
        ]);
    }

    /**
     * Display the specified post.
     */
    public function show(Blog $blog, Post $post): JsonResponse
    {
        // Verify post belongs to the specified blog
        if ($post->blog_id !== $blog->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found in the specified blog'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'post' => $post,
                'likes_count' => $post->likes()->count(),
                'comments' => $post->comments
            ]
        ]);
    }

    /**
     * Update the specified post in storage.
     */
    public function update(PostRequest $request, Blog $blog, Post $post): JsonResponse
    {
        if ($post->blog_id !== $blog->id) {
            return $this->errorResponse('Post not found in the specified blog', 404);
        }

        $post->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Blog $blog, Post $post): JsonResponse
    {
        // Verify post belongs to the specified blog
        if ($post->blog_id !== $blog->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found in the specified blog'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ]);
    }
}
