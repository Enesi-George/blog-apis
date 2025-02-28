<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InteractController extends Controller
{
    /**
     * Like a post.
     */
    public function likePost(Request $request, Post $post):JsonResponse
    {       
        $userId = 1;
        
        // Check if the user has already liked the post
        $existingLike = Like::where('post_id', $post->id)
            ->where('user_id', $userId)
            ->first();
            
        if ($existingLike) {
            // If like exists, unlike the post
            $existingLike->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Post unliked successfully'
            ]);
        }
        
        Like::create([
            'post_id' => $post->id,
            'user_id' => $userId
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Post liked successfully'
        ]);
    }
    
    /**
     * Comment on a post.
     */
    public function commentPost(Request $request, Post $post): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $userId = 1;
        
        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $userId,
            'content' => $request->content
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Comment added successfully',
            'data' => $comment
        ], 201);
    }
}