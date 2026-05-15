<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SharedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FeedController extends Controller
{
    public function index()
    {
        // Normal posts
        $posts = Post::with([
            'user',
            'comments.user'
        ])->get()->map(function ($post) {

            return [
                'type' => 'post',
                'created_at' => $post->created_at,
                'data' => $post
            ];
        });

        // Shared posts
        $sharedPosts = SharedPost::with([
            'user',
            'post.user',
            'post.comments.user'
        ])->get()->map(function ($shared) {

            return [
                'type' => 'shared',
                'created_at' => $shared->created_at,
                'data' => $shared
            ];
        });

        // Merge + sort latest first
        $feed = $posts
            ->concat($sharedPosts)
            ->sortByDesc('created_at')
            ->values();

        return view('newsfeed', compact('feed'));
    }
}