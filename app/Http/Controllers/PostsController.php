<?php

namespace App\Http\Controllers;

use App\Post;
use Validator;
use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        return view('admin.post.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'content' => 'required',
            'status' => 'required'
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
        $post->post_status = $request->input('status');
        $post->save();

        return redirect()->back()->with('success', 'Post has been saved as draft');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {   
        /*$post = Post::find($post->id);
        return view('posts.show')->with('post', $post);*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if(auth()->user()->id !== $post->user->id){
            return redirect()->back()->with('error', 'Unauthorized page!');
        }

        return view('admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'category' => 'required',
            'content' => 'required',
            'status' => 'required'
        ]);

        //Update Post
        $post = Post::find($id);
        $post->post_title = $request->input('title');
        $post->category_id = $request->input('category');
        $post->post_content = $request->input('content');
        $post->post_status = $request->input('status');
        $post->save();

        return redirect()->back()->with('success', 'Post has been edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
