@extends('layouts.app')
@section('content')
    <main class="posts-listing col-lg-8"> 
        <div class="container">
            <div class="row">
                @if(count($posts) > 0)
                    @foreach($posts as $post)
                        <!-- post -->
                        <div class="post col-xl-6">
                            <div class="post-details">
                                <div class="post-meta d-flex justify-content-between">
                                    <div class="category"><a href="/category/{{$post->category->category_slug}}">{{$post->category->category_name}}</a></div>
                                </div>
                                <a href="/post/{{$post->post_slug}}"><h3 class="h4">{{$post->post_title}}</h3></a>
                                <p class="text-muted">{{ substr($post->post_content, 0, 100)}}</p>
                                <footer class="post-footer d-flex align-items-center">
                                    <a href="#" class="author d-flex align-items-center flex-wrap">
                                        <div class="title"><span>{{$post->user->name}}</span></div>
                                    </a>
                                    <div class="date"><i class="icon-clock"></i> {{$post->created_at->diffForHumans()}}</div>
                                    <div class="comments meta-last"><i class="icon-comment"></i>{{count($post->comments)}}</div>
                                </footer>
                            </div>
                        </div>

                    @endforeach
                        <div class="col-md-12">
                            {{$posts->links('vendor.pagination.custom')}}
                        </div>
                    @else
                        <p>No posts found</p>
                @endif
                
            </div>
        </div>
    </main>
@endsection
    