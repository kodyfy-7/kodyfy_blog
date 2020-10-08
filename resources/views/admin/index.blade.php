@extends('layouts.dashboard_app')

@section('style')
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
            <div class="count">{{count($users)}}</div>
  
            <h3>Users</h3>
            <p>&NonBreakingSpace;</p>
          </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-user"></i>
            </div>
            <div class="count">{{count($admins)}}</div>
  
            <h3>Administrators</h3>
            <p>&NonBreakingSpace;</p>
          </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-newspaper-o"></i>
            </div>
            <div class="count">{{count($posts)}}</div>
  
            <h3>Articles</h3>
            <p>&NonBreakingSpace;</p>
          </div>
        </div>
      </div>
      <!-- /top tiles -->
  
    @else 

    @endif

@endsection

@section('script')

@endsection