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
    Articles | BlogApp 
@endsection

@section('page_title')
    Articles <span class="btn btn-sm"><a href="/admin/posts/create">Create new article</a></span>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel tile">
            <div class="x_title">
              <h2></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (count($posts) > 0)
                    <table id="datatable_posts" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
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
                                                <a href="/admin/posts/{{$post->post_slug}}/edit" class="btn btn-default btn-xs">Edit</a>
                                                {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
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
@endsection

@section('script')
    <!-- Datatables-->
    <script src="{{asset('backend/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/js/datatables/dataTables.bootstrap.js')}}"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#datatable_posts').dataTable();
      });
    </script>
@endsection