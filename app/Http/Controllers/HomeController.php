<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use Validator;
use DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('welcome', compact('posts'));
    }

    public function show(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)->orderBy('id', 'desc')->get();
        return view('post', compact('post', 'comments'));
    }

    public function comment_save(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);

        //Create Comment
        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $request->input('hidden_id');
        $comment->comment = $request->input('comment');
        $comment->comment_status = 'active';
        $comment->save();

        return redirect()->back()->with('success', 'Comment Created');
    }

    public function dashboard()
    {
        return view('home');
    }


    public function adminHome()
    {
        $eID = auth()->user()->id;
        $posts = Post::whereUserId($eID)->orderBy('id', 'desc')->get();
        return view('admin.index', compact('posts'));
    }

    public function create_post()
    {
        return view('admin.create_post');
    }

    public function save_post(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'content' => 'required'
        ]);

        $slug = Str::kebab($request->title);
        $slug = $slug.'-'.time();

        //Create Post
        $post = new Post;
        $post->post_title = $request->input('title');
        $post->category_id = $request->input('category');
        $post->post_content = $request->input('content');
        $post->post_slug = $slug;
        $post->user_id = auth()->user()->id;
        $post->post_status = 'draft';
        $post->save();

        return redirect()->back()->with('success', 'Post has been saved as draft');
    }

    public function edit_post(Post $post)
    {
        return view('admin.edit_post', compact('post'));
    }

    public function update_post(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'content' => 'required'
        ]);

        //Update Post
        $post = Post::find($id);
        $post->post_title = $request->input('title');
        $post->category_id = $request->input('category');
        $post->post_content = $request->input('content');
        $post->save();

        return redirect()->back()->with('success', 'Post has been edited successfully.');
    }

    public function destroy_post($id)
    {
        //Delete Post
        $post = Post::find($id);
        if(auth()->user()->id !== $post->user->id){
            return redirect()->back()->with('error', 'Unauthorized page!');
        }

        $post->delete();
        return redirect()->back()->with('success', 'Post Deleted.');
    }
}
