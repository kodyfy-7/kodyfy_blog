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
                    @if (count($withdrawals) > 0)
                        <table id="datatable" class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th style="width: 1%">#</th>
                                    <th style="width: 20%">User Name</th>
                                    <th>Wallet Address</th>
                                    <th style="width: 20%">#Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals as $withdrawal)
                                    <tr>
                                        <td>#</td>
                                        <td>
                                            <a>{{$withdrawal->user->name}}</a>
                                            <br />
                                            <small>{{$withdrawal->user->username}}</small>
                                        </td>
                                        <td><a href="">{{$withdrawal->user->wallet_address}}</a></td>
                                        <td>
                                            {!! Form::open(['action' => ['HomeController@confirm_payment', $withdrawal->id], 'id' => 'payment_data_form', 'method' =>'POST']) !!}
                                                {{Form::hidden('hidden_withdrawal',  $withdrawal->id , ['id' => 'payment_hidden_id', 'class' => 'form-control'])}}    
                                                {{Form::hidden('hidden_user',  $withdrawal->user->id , ['id' => 'payment_hidden_id', 'class' => 'form-control'])}}
                                                {{Form::hidden('hidden_email',  $withdrawal->user->email , ['id' => 'hidden_email', 'class' => 'form-control'])}}
                                                {{Form::hidden('hidden_username',  $withdrawal->user->username , ['id' => 'hidden_username', 'class' => 'form-control'])}}
                                                {{Form::button('<i class="fa fa-folder"></i>', ['type' => 'submit', 'class' => 'btn btn-success btn-xs'])}}
                                                        
                                            {!! Form::close() !!}
                                        </td>
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
</div>
@endsection
