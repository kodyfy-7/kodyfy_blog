<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BlogApp') }}</title>

        <!-- Bootstrap core CSS -->

        <link href="{{ asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">

        <link href="{{ asset('backend/fonts/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{ asset('backend/css/animate.min.css')}}" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="{{ asset('backend/css/custom.css')}}" rel="stylesheet">
        <link href="{{ asset('backend/css/icheck/flat/green.css')}}" rel="stylesheet">


        <script src="{{ asset('backend/js/jquery.min.js')}}"></script>
        <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    </head>

    <body style="background:#F7F7F7;">

        <div class="">
            <div id="wrapper">
                @yield('content')
            </div>
        </div>
    </body>
  
</html>
  