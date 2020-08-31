@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Invoice') }} <a href="{{route('posts.create')}}">Create a post</a></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-3">
                                <div class="profile_img">
            
                                    <!-- end of image cropping -->
                                    <div id="crop-avatar">
                                    <!-- Current avatar -->
                                    <div class="avatar-view" title="Change the avatar">
                                        <img src="/storage/invoices/{{$invoice->invoice_file}}" alt="Avatar">
                                    </div>
                    
                                    </div>
                                    <!-- end of image cropping -->
                    
                                </div>
                            </div>
                            <div class="col md-9" style="float: right">
                                <h3>{{$invoice->user->name}}</h3>
            
                                <ul class="list-unstyled user_data">
                                    <li><i class="fa fa-map-marker user-profile-icon"></i> San Francisco, California, USA
                                    </li>
            
                                    <li>
                                    <i class="fa fa-briefcase user-profile-icon"></i> {{$invoice->user->email}}
                                    </li>
            
                                    <li class="m-top-xs">
                                    <i class="fa fa-external-link user-profile-icon"></i>
                                    <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                                    </li>
                                </ul>
                            </div>
            
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['action' => ['HomeController@activate_account', $invoice->id], 'id' => 'payment_data_form', 'method' =>'POST']) !!}
                                        <div class="col-md-12">
                                            {{Form::hidden('hidden_invoice_id',  $invoice->id , ['class' => 'form-control'])}}
                                            {{Form::hidden('hidden_email',  $invoice->user->email , ['class' => 'form-control'])}}
                                            {{Form::hidden('hidden_user_id',  $invoice->user->id , ['class' => 'form-control'])}}
                                            {{Form::hidden('hidden_username',  $invoice->user->username , ['class' => 'form-control'])}}
                                            
                                            @if ($invoice->user->payment_status > 0)
                                                {{Form::submit('Activate this account', ['id' => 'payment_action_button', 'class' => 'btn btn-success btn-block', 'disabled'])}}
                                            @else
                                                {{Form::hidden('hidden_subscription',  $invoice->user->current_sub_id , ['id' => 'hidden_subscription', 'class' => 'form-control'])}}
                                                {{Form::submit('Activate this account', ['id' => 'payment_action_button', 'class' => 'btn btn-success btn-block'])}}
                                            @endif
                                        </div>
                                            
                                    {!! Form::close() !!}
                                </div>    
                            </div>
                        </div>
                    </div>
                            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
