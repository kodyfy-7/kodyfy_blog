@extends('layouts.app')

@section('title')
    Welcome to BlogApp
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <!-- Latest Posts -->
      @if ($payment_status == 'active')
      <main class="posts-listing col-lg-8"> 
        <div class="container">
          <div class="row">
            
              <!-- post -->
              @if (count($posts) > 0)
                @foreach ($posts as $post)
                  <div class="post col-xl-12">
                  <div class="post-thumbnail">
                    <a href="/post/{{$post->post_slug}}">
                      <img src="/storage/cover_images/{{$post->post_image}}" alt="..." class="img-fluid">
                    </a>
                  </div>
                    <div class="post-details">
                      <div class="post-meta d-flex justify-content-between">
                        <div class="category"><a href="/category/{{$post->category->category_slug}}">{{$post->category->category_name}}</a></div>
                      </div><a href="/post/{{$post->post_slug}}">
                        <h3 class="h4">{{$post->post_title}}</h3></a>
                      <p class="text-muted">{{ substr($post->post_content, 0, 100)}}</p>
                      <footer class="post-footer d-flex align-items-center"><a href="#" class="author d-flex align-items-center flex-wrap">
                          <div class="title"><span>{{$post->editor->name}}</span></div></a>
                        <div class="date"><i class="icon-clock"></i> {{$post->created_at->diffForHumans()}}</div>
                        <div class="comments meta-last"><i class="icon-comment"></i>{{count($post->comments)}}</div>
                      </footer>
                    </div>
                  </div>  
                @endforeach
                
              
                <!-- Pagination -->
            
                {{$posts->links()}}
            
              @endif            
          </div>
        </div>
      </main>

      <aside class="col-lg-4">
        <!-- Widget [Search Bar Widget]-->
        <div class="widget search">
          <header>
            <h3 class="h6">Search the blog</h3>
          </header>
          <form action="/search" class="search-form">
            @csrf
            <div class="form-group">
              <input type="search" name="search" id="search" placeholder="What are you looking for?">
              <button type="submit" class="submit"><i class="fa fa-search"></i></button>
            </div>
          </form>
        </div>
        <!-- Widget [Categories Widget]-->
        <div class="widget categories">
          <header>
            <h3 class="h6">Categories</h3>
          </header>
          @if(count($categories) > 0)
            @foreach ($categories as $category)
              <div class="item d-flex justify-content-between"><a href="/category/{{$category->id}}">{{$category->category_name}}</a><span></span></div>
            @endforeach
          @endif
        </div>
      </aside>

      @else
        <main class="posts-listing col-lg-8"> 
          <div class="container">
            <div class="row">
            <p class="text-big"><strong>Oops</strong>!!!. It appears you do not have an active subscription. To continue using this service, please go to your <a href="{{route('dashboard')}}">dashboard</a>.</p>
            </div>
          </div>
        </main>
      @endif

    </div>
  </div> 
       
@endsection