@extends('layouts.app')

@section('content')
    <!-- Latest Posts -->
    <main class="post blog-post col-lg-8"> 
        <div class="container">
            <div class="post-single">
                <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                    <div class="category"><a href="/category/{{$post->category->category_slug}}">{{$post->category->category_name}}</a></div>
                </div>
                <h1>{{$post->post_title}}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="#" class="author d-flex align-items-center flex-wrap">
                    <div class="title"><span>{{$post->user->name}}</span></div></a>
                    <div class="d-flex align-items-center flex-wrap">       
                    <div class="date"><i class="icon-clock"></i>  {{$post->created_at->diffForHumans()}}</div>
                    <div class="comments meta-last"><i class="icon-comment"></i> {{count($comments)}}</div>
                    </div>
                </div>
                <div class="post-body">
                    <p>{{$post->post_content}}</p>
                </div>
                <div class="post-comments">
                    <header>
                    <h3 class="h6">Post Comments<span class="no-of-comments">({{count($comments)}})</span></h3>
                    </header>
                    @if (count($comments) > 0) 
                        @foreach ($comments as $comment)
                            <div class="comment">
                                <div class="comment-header d-flex justify-content-between">
                                    <div class="user d-flex align-items-center">
                                        <div class="title">
                                            <strong>{{$comment->user->name}} </strong> <span class="date">{{$comment->created_at->diffForHumans()}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-body">
                                    <p>{{$comment->comment}}</p>
                                </div>
                            </div>
                        @endforeach
                    @else 
                            No comments
                    @endif
                </div>
                <div class="add-comment">
                    <header>
                    <h3 class="h6">Leave a reply</h3>
                    </header>                    
                    @guest
                        <p>You must login before commenting.</p>
                    @else
                    <form action="{{route('comment.save')}}" class="commenting-form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                              <input type="text" name="name" id="name" value="{{auth()->user()->name}}" placeholder="Name" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                              <input type="text" name="email" id="email" value="{{auth()->user()->email}}" placeholder="Email" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-12">
                                <textarea name="comment" id="comment" placeholder="Type your comment" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="hidden" name="hidden_id" id="hidden_id" value="{{$post->id}}">
                                <button type="submit" class="btn btn-secondary">Submit Comment</button>
                            </div>
                        </div>
                      </form>
                    @endguest
                </div>
                </div>
            </div>
        </div>
    </main>
@endsection
    