@extends('layouts.dashboard_app')

@section('style')
    <link href="{{ asset('backend/css/icheck/flat/green.css') }}" rel="stylesheet">

    <link href="{{ asset('backend/js/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/js/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title')
    Verification | {{ config('app.name', 'BlogApp') }} 
@endsection

@section('page_title')
    Verification 
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2>Pending Activation</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (count($invoices) > 0)
                    <table id="datatable" class="table table-striped">
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
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$invoice->user->name}}</td>
                                    <td><a href="/admin/users/verification/view_invoice/{{$invoice->invoice_ticket}}" class="btn btn-info">View</a></td>
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