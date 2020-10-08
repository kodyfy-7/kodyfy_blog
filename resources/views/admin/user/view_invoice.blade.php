@extends('layouts.dashboard_app')

@section('style')
    <link href="{{ asset('backend/css/icheck/flat/green.css') }}" rel="stylesheet">

    <link href="{{ asset('backend/js/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/js/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/js/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/js/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/js/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('title')
    Invoice | BlogApp 
@endsection

@section('page_title')
    Invoice
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="#"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="profile_img justify-center">
                            <div class="avatar-view" title="Change the avatar">
                                <img src="/storage/images/invoices/{{$invoice->invoice_file}}" alt="Avatar">
                            </div>
                        </div>
                        <h3>{{$invoice->user->name}}</h3>

                        <ul class="list-unstyled user_data">
                        <li><i class="fa fa-map-marker user-profile-icon"></i> S{{$invoice->user->username}}
                        </li>

                        <li>
                            <i class="fa fa-briefcase user-profile-icon"></i> {{$invoice->user->email}}
                        </li>
                        </ul>
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

@endsection