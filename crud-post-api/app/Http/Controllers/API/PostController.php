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

    public function store(Request $request)
    {
        //TODO: Validation returned welcome page, maak middelware
        // $this->validate($request, [
        //     'title' => 'required|unique:posts|max:255',
        //     'content' => 'required',
        // ]);


        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->author = $request->author;
        $post->published_at = now();
        $post->save();

        return response()->json(['message' => 'Post created successfully', 'data' => $post], 201);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $post->title = $request->title;
        $post->content = $request->content;
        $post->update();

        return response()->json(['message' => 'Post updated successfully', 'data' => $post]);
    }

    public function destroy(Request $request, Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
