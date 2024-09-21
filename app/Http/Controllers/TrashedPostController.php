<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
// use Barryvdh\Debugbar\Facades\Debugbar;
// use Illuminate\Support\Facades\Auth;

class TrashedPostController extends Controller {

    public function index() {

        $posts = Post::latest('updated_at')->onlyTrashed()->withTotalVisitCount()->paginate(3);

        return view('trashed.index')->with('posts', $posts);

    }

    public function show(Post $post) {

        return view('trashed.show')->with('post', $post);

    }

    public function update(Post $post) {

        $post->restore();
        return to_route('trashed.index', $post)->with('success', 'Restore successful');

    }

    public function destroy(Post $post) {

        $destinationPath = 'public/uploads/';
        $image = $destinationPath.$post->image_path;

        if(Storage::exists($image)) {
            Storage::delete($image);
        }
        $post->forceDelete();
        return to_route('trashed.index')->with('success', 'Deleted successfully');

    }

}
