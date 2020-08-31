@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Post Panel') }} <a href="{{route('posts.create')}}">Create a post</a></div>

                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>S/N</th>
                            <th>Post Title</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (count($posts) > 0)
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$post->post_title}}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                
                                                <a href="/admin/posts/{{$post->post_slug}}/edit" class="btn btn-default btn-xs">Edit</a>
                                                {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::submit('Delete', ['class' => 'btn btn-danger btn-xs'])}}
                                                {!!Form::close()!!}
                                                
                                            </div>
                                        </td> 
                                    </tr>
                                @endforeach
                            
                            @endif
                        </tbody>
          
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (count($invoices) > 0)
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($invoices as $invoice)
                                    <tr>
                                    <td>**</td>
                                    <td>{{$invoice->user->name}}</td>
                                    <td><a href="/admin/view_invoice/{{$invoice->invoice_ticket}}" class="btn btn-info">View</a></td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    @else 
                        <p>No data available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <p>You are an admin.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
