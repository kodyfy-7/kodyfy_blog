@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <p>
                        Please confirm your wallet address: 
                        <strong>
                          {{Auth::user()->wallet_address}}              
                        </strong>
                      </p>
                      {!! Form::open(['action' => ['HomeController@withdrawal',Auth::user()->id], 'id' => 'payment_data_form', 'method' =>'POST', 'class' => 'form-horizontal form-label-left']) !!}
                        <div class="form-group">
                          {{Form::hidden('hidden_id',  Auth::user()->id , ['id' => 'payment_hidden_id', 'class' => 'form-control'])}}        
                          {{Form::hidden('hidden_email',  Auth::user()->email , ['id' => 'hidden_email', 'class' => 'form-control'])}}
                          {{Form::hidden('hidden_username',  Auth::user()->username , ['id' => 'hidden_username', 'class' => 'form-control'])}}
                          {{Form::hidden('hidden_subscription',  Auth::user()->current_sub_id , ['id' => 'hidden_username', 'class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                          @if (is_null($withdrawal))
                            {{Form::submit('Withdraw', ['id' => 'payment_action_button', 'class' => 'btn btn-success btn-block'])}}   
                          @else
                            <p>You have applied for withdrawal, please wait for approval.</p>
                            {{Form::submit('Withdraw', ['id' => 'payment_action_button', 'class' => 'btn btn-success btn-block', 'disabled'])}}  
                          @endif
                        </div> 
                      {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
