@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Posts') }}</div>

                <div class="card-body">
                    @if(count($posts) > 0)
                        @foreach($posts as $post)
                            <div class="well">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <h3><a href="/post/{{$post->post_slug}}">{{$post->post_title}}</a></h3>
                                        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                                    </div>
                                </div>                                
                            </div>
                            <hr>
                        @endforeach
                        {{$posts->links()}}
                    @else
                        <p>No posts found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
