<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\LikePost;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike($postId)
{
    $userId = Auth::id();

    $like = LikePost::where('user_id', $userId)
                    ->where('post_id', $postId)
                    ->first();

    $post = Post::findOrFail($postId);

    if ($like) {
        // Unlike
        $like->delete();
        $post->decrement('likes');
        $liked = false;
    } else {
        // Like
        LikePost::create([
            'user_id' => $userId,
            'post_id' => $postId
        ]);

        $post->increment('likes');
        $liked = true;
    }

    return response()->json([
        'likes' => $post->likes,
        'liked' => $liked
    ]);
}
}
