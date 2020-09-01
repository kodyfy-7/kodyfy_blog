@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <p>You are a normal user.</p>

                    
                    

                    <ul class="list-group mt-3">
                        <li class="list-group-item">
                            @if ( Auth::user()->payment_status > 0 )
                                Payment status: Active
                            @else
                                Payment status: No active subscription 
                                {!! Form::open(['action' => ['HomeController@upload_invoice',Auth::user()->id], 'id' => 'payment_data_form', 'method' =>'POST', 'enctype' => 'multipart/form-data']) !!}
                                <div class="form-group">
                                  {{Form::file('payment_invoice')}}                     
                                </div> 
                                  <div class="col-md-12">
                                      {{Form::hidden('payment_hidden_id',  Auth::user()->id , ['id' => 'payment_hidden_id', 'class' => 'form-control'])}}
                                      {{Form::submit('Upload', ['id' => 'payment_action_button', 'class' => 'btn btn-success btn-block'])}}
                                                  
                                  </div>
                                      
                                {!! Form::close() !!}
                            @endif    
                        </li>
                        <li class="list-group-item">Username: {{ Auth::user()->username }}</li>
                        <li class="list-group-item">Email: {{ Auth::user()->email }}</li>
                        <li class="list-group-item">Referral link: {{ Auth::user()->referral_link }}</li>
                        <li class="list-group-item">Referrer: {{ Auth::user()->referrer->name ?? 'Not Specified' }}</li>
                        <li class="list-group-item">Refer Points: {{ $points_per_refer }}</li>
                        <li class="list-group-item">Task Points: {{ $points_per_post }}</li>
                        <li class="list-group-item">Total Points: {{ $points_total }}</li>
                        <li class="list-group-item">Progress Points: {{ $progress_point }}</li>
                        <li class="list-group-item">
                            @if (is_null(auth()->user()->wallet_address))
                                {!! Form::open(['action' => ['HomeController@save_wallet',Auth::user()->id], 'id' => 'payment_data_form', 'method' =>'POST', 'class' => 'form-horizontal form-label-left']) !!}
                                    <div class="form-group">
                                    {{Form::label('wallet', 'Input your Etherum wallet address', ['class' => 'col-sm-3 control-label'])}}
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                        {{Form::text('wallet', '', ['id' => 'wallet', 'class' => 'form-control', 'placeholder' => ''])}}  
                                        <span class="input-group-btn">
                                            {{Form::submit('Save', ['id' => 'payment_action_button', 'class' => 'btn btn-success btn-block'])}}
                                        </span>
                                        </div>
                                    </div>
                                                    
                                    </div> 
                                {!! Form::close() !!}    
                            @else
                                Wallet Address: {{auth()->user()->wallet_address}}
                            @endif
                        </li>

                        <li class="list-group-item">
                            @if ($points_total >= $withdraw_point->target)
               
                                @if (is_null(auth()->user()->wallet_address))
                                <a href="" class="btn btn-warning">You have not saved a wallet address</a>
                                @else
                                <a href="{{route('dashboard.withdraw')}}" class="btn btn-success">Make a withdrawal</a>
                                @endif

                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
