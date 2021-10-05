<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    //Create new Post
    public function create(Request $request)
    {
        $validated_data = $request->validate([
            'post' => 'required',
            'user_id' => ''
        ]);

        $validatedData["user_id"] =  auth()->user()->id;

        $post = Post::create($validated_data);

        return response(["post" => $post, 'message' => 'Success']);
    }

    //Get existing Post
    public function read($id)
    {
        $post = Post::find($id);

        if(!$post)
        {
            return response(["message" => 'error', 'error' => 'User does not exist.']);
        }

        return response(['post' => $post, 'message' => 'Success']);
    }

    //Update Existing Post
    public function update($id, Request $request)
    {
        $post = Post::find($id);

        if(!$post)
        {
            return response(["message" => 'error', 'error' => 'User does not exist.']);
        }

        if(!$request->post)
        {
            return response(["message" => 'error', 'error' => 'Post field cannot be empty']);
        }

        $post->post = $request->post;
        $post->save();
        return response(["post" => $post, 'message' => 'Success']);
    }

    //Delete Existing Post
    public function detete($id)
    {
        $post = Post::find($id);

        if(!$post)
        {
            return response(["message" => 'error', 'error' => 'User does not exist.']);
        }

        $post->delete();
        return response(['message' => 'Success']);
    }

    //Get all posts
    public function posts()
    {
        $posts = auth()->user()->posts;

        return response(['message' => 'Success', 'posts' => $posts]);
    }


}
