<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsController extends Controller
{

    public function __construct() {
        $this -> middleware(['auth']) -> except(['index', 'show']);
    }

    public function show(Request $request, $id) {
//        $post = Post::find($id);


        $page = $request -> page;
        $post = Post::find($id);



        return view('posts.show', compact('post', 'page'));

    }

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
            'imageFile' => 'image | max:2000',
        ]);


        $post = new Post();
        $post -> title = $title;
        $post -> content = $content;

        $post -> user_id = Auth::user() ->id;


//      file 처리
//      내가 원하는 파일 시스템 상의 위치에 원하는 이름으로
//      파일을 저장하고
//      그 파일 이름을 컬럼에 설정
        if($request-> file('imageFile'))
        {
            $post -> image = $this -> uploadPostImage($request);
        }


        $post -> save();


        return redirect('/posts/index');
    }

    public function index()
    {
//        $posts = Post::orderBy('created_at','desc') -> get();
//        $posts = Post::latest() -> get();
        $posts = Post::latest() -> paginate(5);
//        dd($posts[0] -> created_at);
//        dd($posts);
        return view('posts.index', compact('posts'));
//        return view('posts.index', ['posts' => $posts]);
    }

    public function edit(Request $request, Post $post)
    {
        // 수정 폼 생성
//        dd($post);

        $page = $request -> page;
        return view('posts.edit', compact('post','page'));
    }

    public function update(Request $request, $id)
    {

        $page = $request -> page;

        $request -> validate([
            'title' => 'required | min:3',
            'content' => 'required',
            'imageFile' => 'image | max:2000'
        ]);

        $post = Post::findOrFail($id);

////        Authorization 즉 수정 권한이 있는지 검사
////        즉, 로그인한 사용자와 게시글의 작성자가 같은지 체크
//
//        if(auth() -> user() -> id != $post -> user_id) {
//            abort(403);
//        }

        if($request -> user() -> cannot('update', $post)) {
            abort(403);
        }

        $post -> title = $request -> title;
        $post -> content = $request -> content;

        if($request -> file('imageFile')) {
            $imagePath = 'public/images/'.$post->image;
            Storage::delete($imagePath);
            $post -> image = $this -> uploadPostImage($request);
        }

        $post -> save();

        return redirect() -> route('post.show', compact('id','page'));


        // 게시글을 데이터베이스에서 수정
    }

    public function destroy(Request $request, $id)
    {
        // 파일 시스템에서 이미지 파일 삭제
        // 게시글을 데이터베이스에서 삭제
        $page = $request -> page;

        $post = Post::findOrFail($id);

        if($request -> user() -> cannot('delete', $post)) {
            abort(403);
        }


        if($post -> image){
            $imagePath = 'public/images/'.$post -> image;
            Storage::delete($imagePath);
        }

        $post -> delete();

        return redirect() -> route('posts.index', compact('page'));
    }

    public function myPosts() {




        $id = Auth::user() ->id;

        $posts = Post::where('user_id', $id) -> latest() -> paginate(5);

//        $posts = auth() -> user() -> posts() -> latest-> paginate(5);

        return view('posts.myPosts', compact('posts'));
    }




//   이미지 올리기
    private function uploadPostImage($request) {

        $extension = $request -> file('imageFile') -> extension();
        $name = $request -> file('imageFile') -> getClientOriginalName();
        $nameWithoutExtension = Str::of($name) -> basename('.'.$extension);
        $fileName = $nameWithoutExtension . '_' . time() . '.' . $extension;

        $request -> file('imageFile') -> storeAs('public/images', $fileName);

        return $fileName;
    }
}
