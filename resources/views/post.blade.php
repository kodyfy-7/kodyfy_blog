@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{$post->post_title}} <small>by {{$post->user->name}} at {{$post->created_at->diffForHumans()}}</small>
                </div>

                <div class="card-body">
                    {{$post->post_content}}

                    <hr><hr>
                    <h4>Comments ({{count($comments)}})</h4>

                    @if (count($comments) > 0) 
                        @foreach ($comments as $comment)
                            <div class="comment">
                                <div class="comment-header d-flex justify-content-between">
                                    <div class="user d-flex align-items-center">
                                        <div class="title">
                                            <strong>{{$comment->user->name}} </strong> <span class="date">{{$comment->created_at}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-body">
                                    <p>{{$comment->comment}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
</div>
@endsection
