@extends('layouts.akapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Post Panel') }} <a href="{{route('admin.home')}}">Go back</a></div>
                
                @include('inc.messages')
                
                <div class="card-body">
                    {!! Form::open(['action' => 'PostsController@store', 'method' =>'POST', 'enctype' => 'multipart/form-data']) !!}
  
                        <div class="form-group">
                          {{Form::label('title', 'Post Title')}}
                          {{Form::text('title', '', ['id' => 'title', 'class' => 'form-control', 'placeholder' => ''])}}
                        </div>

                        <div class="form-group">
                          {{Form::label('category', 'Select Category')}}
                          {{Form::select('category', App\Category::pluck('category_name', 'id'), '',['id' => 'category', 'class' => 'form-control', 'placeholder' => 'Select Post Category'])}}
                        </div>
                        
                        <div class="form-group">
                          {{Form::label('content', 'Post Content')}}
                          {{Form::textarea('content', '', ['id' => 'content', 'class' => 'form-control content', 'placeholder' => ''])}}                          
                        </div>

                        <div class="form-group">
                          {{Form::label('status', 'Post Status')}}
                          {{Form::select('status', ['draft' => 'Draft', 'active' => 'Active'], null,['id' => 'status', 'class' => 'form-control', 'placeholder' => 'Select Post Status'])}}
                        </div>

                        <div class="col-md-12">
                          {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success btn-block'])}}
                        </div>  
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
