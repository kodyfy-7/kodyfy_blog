@extends('layouts.dashboard_app')

@section('title')
    Category | BlogApp 
@endsection

@section('page_title')
    Category <span class="btn btn-sm"><a href="/admin/category/create">Create new category</a></span>
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
                @if (count($categories) > 0)
                    <table id="datatable_users" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$category->category_name}}</td>
                                    <td><a href="/admin/category/{{$category->category_slug}}/edit" class="btn btn-warning">Edit</a></td>
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
@endsection