<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function create() {
        // dd('OK'); //디버깅 할 때 사용
        return view('posts.create');
    }

    public function store(Request $request) {
//         $title = $request->input['title'];
//         $content = $request->input['content'];

        $title = $request-> title;
        $content = $request-> content;

        $request -> validate([
            'title' => 'required | min:3',
            'content' => 'required',
        ]);

//        dd($request);
        $post = new Post();
        $post -> title = $title;
        $post -> content = $content;

        $post -> user_id = Auth::user() ->id;
        $post -> save();

        return redirect('/posts/index');
    }

    public function index()
    {
//        $posts = Post::orderBy('created_at','desc') -> get();
//        $posts = Post::latest() -> get();
        $posts = Post::latest() -> paginate(5);
//        dd($posts[0] -> created_at);
        return view('posts.index', compact('posts'));
//        return view('posts.index', ['posts' => $posts]);
    }
}
