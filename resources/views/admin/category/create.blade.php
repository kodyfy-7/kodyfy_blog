@extends('layouts.dashboard_app')

@section('title')
    Category | BlogApp 
@endsection

@section('page_title')
    Category <span class="btn btn-sm"><a href="/admin/category/">Go back</a></span>
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
                {!! Form::open(['action' => 'CategoriesController@store', 'method' =>'POST', 'enctype' => 'multipart/form-data']) !!}
                    @include('admin.category.form')
                {!! Form::close() !!}
            </div>
          </div>
        </div>
    </div> 
@endsection

@section('script')
@endsection