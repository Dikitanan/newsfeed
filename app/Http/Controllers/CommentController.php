<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string|max:1000'
        ]);

        $post = Post::findOrFail($postId);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'body' => $request->body
        ]);

        return response()->json([
        'comment' => [
            'id' => $comment->id,
            'body' => $comment->body,
            'user' => auth()->user()->name, 
            'created_at' => $comment->created_at->diffForHumans()
        ]
    ]);
    }
}