@extends('layouts.dashboard_app')

@section('style')
    <link href="{{ asset('backend/css/icheck/flat/green.css') }}" rel="stylesheet">

    <link href="{{ asset('backend/js/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/js/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title')
    Users | BlogApp 
@endsection

@section('page_title')
    Users <span><button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".bs-example-modal-sm">New Admin</button>
    </span>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2>Administrators</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (count($admins) > 0)
                    <table id="datatable_posts" class="table table-striped">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($admins) > 0)
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$admin->name}}
                                            <br />
                                            <small>Created {{$admin->created_at}}</small>
                                        </td>
                                        <td>{{$admin->email}}</td>
                                        <td>
                                            @if ($admin->admin_role > 0)
                                                <button type="button" class="btn btn-success btn-xs">Super Admin</button>
                                            @else
                                                <button type="button" class="btn btn-info btn-xs">Editor</button>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                            
                                            {!!Form::open(['action' => ['PostsController@destroy', $admin->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::submit('Delete', ['class' => 'btn btn-danger btn-xs'])}}
                                            {!!Form::close()!!}
                                        </td> 
                                    </tr>
                                @endforeach
                            @endif
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
                <h2>Registered Users</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  @if (count($users) > 0)
                      <table id="datatable-responsive" class="table table-striped">
                          <thead>
                              <tr>
                                  <th>S/N</th>
                                  <th>Name</th>
                                  <th>Email Address</th>
                                  <th>Role</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              @if (count($users) > 0)
                                  @foreach ($users as $user)
                                      <tr>
                                          <td>{{$loop->iteration}}</td>
                                          <td>{{$user->name}}
                                              <br />
                                              <small>Created {{$user->created_at}}</small>
                                          </td>
                                          <td>{{$user->email}}</td>
                                          <td>
                                              @if ($user->payment_status === null)
                                                  <button type="button" class="btn btn-warning btn-xs">Not Active</button>
                                              @else
                                                  <button type="button" class="btn btn-success btn-xs">Active</button>
                                              @endif
                                          </td>
                                          <td>
                                              <a href="" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                              
                                              {!!Form::open(['action' => ['PostsController@destroy', $user->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                                      {{Form::hidden('_method', 'DELETE')}}
                                                      {{Form::submit('Delete', ['class' => 'btn btn-danger btn-xs'])}}
                                              {!!Form::close()!!}
                                          </td> 
                                      </tr>
                                  @endforeach
                              @endif
                          </tbody>
                      </table>
                  @else 
                      <p>No data available</p>
                  @endif
  
              </div>
            </div>
        </div>
    </div> 

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        {!! Form::open(['action' => 'AdminsController@store', 'method' =>'POST', 'enctype' => 'multipart/form-data']) !!}
    
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">New Admin</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', old('name'), ['id' => 'name', 'class' => 'form-control', 'placeholder' => ''])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('username', 'Username')}}
                        {{Form::text('username', old('username'), ['id' => 'username', 'class' => 'form-control', 'placeholder' => ''])}}
                    </div>
                    
                    <div class="form-group">
                        {{Form::label('email', 'Email Address')}}
                        {{Form::email('email', old('email'), ['id' => 'email', 'class' => 'form-control', 'placeholder' => ''])}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success'])}}
                </div>

            </div>
        {!! Form::close() !!}
      </div>
    </div>
    <!-- /modals -->
@endsection

@section('script')
    <!-- Datatables-->
    <script src="{{asset('backend/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/js/datatables/dataTables.bootstrap.js')}}"></script>
    <script src="{{ asset('backend/js/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('backend/js/datatables/responsive.bootstrap.min.js')}}"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#datatable_posts').dataTable();
        $('#datatable-responsive').DataTable();
      });
    </script>
@endsection