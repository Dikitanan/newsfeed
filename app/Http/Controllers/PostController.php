<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SharedPost;

class PostController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'body' => 'required|string|max:1000',

            'media' => 'nullable|mimes:jpeg,png,jpg,gif,mp4,mov,avi,webm|max:20480',

            'habitat' => 'nullable|string|max:100',
        ]);

        $post = new Post();

        $post->user_id = Auth::id();
        $post->body = $request->body;
        $post->habitat = $request->habitat;

        // Handle Media Upload
        if ($request->hasFile('media')) {

            $path = $request->file('media')->store('posts', 'public');

            $post->media = $path;
        }

        $post->save();

        return back()->with('success', 'Your tail has been shared with the pack!');
    }

    public function share(Request $request, Post $post)
{
    $request->validate([
        'caption' => 'nullable|string|max:1000'
    ]);

    $share = SharedPost::create([
        'user_id' => auth()->id(),
        'post_id' => $post->id,
        'caption' => $request->caption
    ]);

    return response()->json([
        'success' => true,
        'share' => $share
    ]);
}
}