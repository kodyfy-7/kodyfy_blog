@extends('layouts.dashboard_app')

@section('style')
    <link href="{{ asset('backend/css/icheck/flat/green.css') }}" rel="stylesheet">

    <link href="{{ asset('backend/js/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/js/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title')
    Withdrawals | {{ config('app.name', 'BlogApp') }} 
@endsection

@section('page_title')
    Withdrawals 
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2>Pending Withdrawals</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (count($withdrawals) > 0)
                    <table id="datatable" class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 1%">S/N</th>
                                <th style="width: 20%">User Name</th>
                                <th>Wallet Address</th>
                                <th style="width: 20%">#Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawals as $withdrawal)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
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
                                            {{Form::button('<i class="fa fa-check"></i>', ['type' => 'submit', 'class' => 'btn btn-success btn-xs'])}}
                                                    
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

@endsection

@section('script')
    <!-- Datatables-->
    <script src="{{asset('backend/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/js/datatables/dataTables.bootstrap.js')}}"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#datatable').dataTable();
      });
    </script>
@endsection