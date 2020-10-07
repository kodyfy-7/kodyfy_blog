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
    Dashboard | BlogApp 
@endsection

@section('page_title')
    Dashboard
@endsection

@section('content')

    @if (Auth::user()->admin_role === 1)
        <!-- top tiles -->
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-external-link"></i>
            </div>
            <div class="count">&NonBreakingSpace;</div>
  
            <h3>Referral Link</h3>
            <p></p>
          </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-user"></i>
            </div>
            <div class="count">&NonBreakingSpace;</div>
  
            <h3>Referrer</h3>
            <p></p>
          </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-sort-amount-desc"></i>
            </div>
            <div class="count"></div>
  
            <h3>New Sign ups</h3>
            <p>&NonBreakingSpace;</p>
          </div>
        </div>
      </div>
  
      <div class="row top_tiles">
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-sitemap"></i>
            </div>
            <div class="count"></div>
  
            <h3>Referral Points</h3>
            <p>&NonBreakingSpace;</p>
          </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-tasks"></i>
            </div>
            <div class="count"></div>
  
            <h3>Task Points</h3>
            <p>&NonBreakingSpace;</p>
          </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-trophy"></i>
            </div>
            <div class="count"></div>
  
            <h3>Total Points</h3>
            <p>&NonBreakingSpace;</p>
          </div>
        </div>
      </div>
      <!-- /top tiles -->
  
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2>All Posts</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable_posts" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Post Title</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (count($tposts) > 0)
                            @foreach ($tposts as $tpost)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$tpost->post_title}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            
                                            <a href="/admin/posts/{{$tpost->post_slug}}/edit" class="btn btn-default btn-xs">Edit</a>
                                            {!!Form::open(['action' => ['PostsController@destroy', $tpost->id], 'method' => 'POST'])!!}
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
  
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2>User Verification</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (count($invoices) > 0)
                    <table id="datatable_users" class="table table-striped table-bordered">
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

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel tile">
              <div class="x_title">
                <h2>Approve Withdrawals</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                @if (count($withdrawals) > 0)
                    <table id="datatable_withdrawals" class="table table-striped projects">
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
    @else
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2>My Posts</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable_posts1" class="table table-striped table-bordered">
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
  
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2>My track</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              
            </div>
          </div>
        </div>
      </div>    
    @endif

@endsection

@section('script')
    <!-- Datatables-->
    <script src="{{asset('backend/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/js/datatables/dataTables.bootstrap.js')}}"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#datatable_posts').dataTable();
        $('#datatable_users').dataTable();
        $('#datatable_withdrawals').dataTable();
        $('#datatable_posts1').dataTable();
      });
    </script>
@endsection