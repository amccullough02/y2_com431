<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Post $post)
    {
        return view('comments.create')->with('post', $post);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $this->validate($request, [
            'body' => 'required|string|min:3|max:255',
        ]);

        $comment = Comment::create([
            'username' => Auth::user()->name,
            'body' => $request->body,
        ]);

        DB::table('comment_post')->insert([
            ['comment_id'=>$comment->id, 'post_id'=>$post->id]
        ]);

        // Add the id of the post and the id of the newly created comment to the CommentPost table.
        // Attach this comments ID to the post we will pass in.

        return to_route('posts.show', $post)->with('success', 'Comment created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
