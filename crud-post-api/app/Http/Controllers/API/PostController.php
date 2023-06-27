<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json(['data' => $posts]);
    }

    public function create(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->author = $request->author;
        $post->published_at = now();
        $post->save();

        return response()->json(['message' => 'Post created successfully', 'data' => $post], 201);
    }

    public function read()
    {
        $posts = Post::all();

        return response()->json($posts);
    }

    public function update(Request $request)
    {
        $post = Post::findorfail($request->id);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->update();

        return response()->json(['message' => 'Post updated successfully', 'data' => $post]);
    }

    public function delete(Request $request)
    {
        $post = Post::findorfail($request->id)->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
