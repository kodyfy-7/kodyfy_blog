@extends('layouts.dashboard_app')

@section('title')
    Article | BlogApp 
@endsection

@section('page_title')
    Article <span class="btn btn-sm"><a href="/admin/posts/">Go back</a></span>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2> {{$post->post_title}} </h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' =>'POST', 'enctype' => 'multipart/form-data']) !!}
                    @include('admin.post.form')
                    {{Form::hidden('_method', 'PUT')}}
                {!! Form::close() !!}
            </div>
          </div>
        </div>
    </div> 
@endsection

@section('script')
@endsection