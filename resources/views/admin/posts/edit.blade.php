@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Post Panel') }} <a href="{{route('admin.home')}}">Go back</a></div>
                
                @include('inc.messages')
                
                <div class="card-body">
                    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' =>'POST']) !!}
                        <div class="form-group">
                            {{Form::label('title', 'Title')}}
                            {{Form::text('title', $post->post_title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('category', 'Title')}}
                            {{Form::select('category', App\Category::pluck('category_name', 'id'), $post->category_id,['id' => 'category', 'class' => 'form-control', 'placeholder' => ''])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('content', 'Body')}}
                            {{Form::textarea('content', $post->post_content, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Content'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('status', 'Post Status')}}
                            {{Form::select('status', ['draft' => 'Draft', 'active' => 'Active'], $post->post_status,['id' => 'status', 'class' => 'form-control', 'placeholder' => 'Select Post Status'])}}
                          </div>
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
