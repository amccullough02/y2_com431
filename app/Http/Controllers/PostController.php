<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest('updated_at')->withTotalVisitCount()->paginate(3);

        return view('posts.index')->with('posts', $posts);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // The admin or the 'Alex' account (which is ID #2) can create posts.
        if (Gate::allows('is_admin') || (Auth::user()->id == 2)) {
            return view('posts.create');
        }
        else {
            return to_route('posts.index')->withErrors('You are not unauthorised to create posts - not admin or Alex.');
        }
    }

    // Private function to handle the storing of images.
    private function storeImage(Request $request) {

        if ($request->hasFile('image_path')) {

            $originalFileName = $request->file('image_path')
            ->getClientOriginalName();

            $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);

            $extension = $request->file('image_path')
            ->getClientOriginalExtension();

            $requester = auth()->user()->email;

            $fileName = $requester . '_' . $fileName . '-' . time() . '-' . $extension;

            // Upload.

            $request->file('image_path')->storeAs('public/uploads', $fileName);

            $url = asset('storage/uploads/'.$fileName);

            return $url;

        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Before doing anything, we first validate if the data is valid.
        $this->validate($request, [
            'title' => 'required|string|min:3|max:30', // Title must be a string of length between 3 and 30.
            'image_path' => 'required|image|mimes:jpeg,png,jpg', // Image needs to be there of an appropriate format.
            'cost' => 'required|integer|min:1|max:100' // Cost must be an integer between 1 and 200.
        ]);

        // Creating the post and storing it.
        Post::create([
            'title' => $request->title,
            'image_path' => $this->storeImage($request),
            'cost' => $request->cost,
        ]);

        return to_route('posts.index')->with('success', 'Post created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->visit()->customInterval( now()->addSeconds(30))->withIp()->withUser();

        // foreach ($post->comments as $comment) {
        //     dd($comment);
        // }

        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (Gate::allows('is_admin')) {
            return view('posts.edit')->with('post', $post);
        }
        else {
            return to_route('posts.show', $post)->withErrors('You are not authorised to edit posts - not admin.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $this->validate($request, [
            'title' => 'required|string|min:3|max:30', // Title must be a string of length between 3 and 30.
            'image_path' => 'image|mimes:jpeg,png,jpg', // Image needs to be there of an appropriate format.
            'cost' => 'required|integer|min:1|max:100' // Cost must be an integer between 1 and 200.
        ]);

        $post->title = $request->input('title');
        $post->cost = $request->input('cost');

        if ($request->has('image_path')) {
            $post->image_path = $this->storeImage($request);
        }

        $post->update();

        return to_route('posts.show', $post)->with('success', 'Post edited.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Gate::allows('is_admin')) {
            $post->delete();
            return to_route('posts.index')->with('success', 'Post trashed.');
        }

        else {
            return to_route('posts.show', $post)->withErrors('You are not authorised to trash posts - not admin.');
        }

    }
}
