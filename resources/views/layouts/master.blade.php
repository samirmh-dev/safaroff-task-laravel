<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @yield('elave-head')

        <!--Bootstrap 4 beta1 CSS-->
        <link rel="stylesheet" href="{{asset('src/css/bootstrap.min.css')}}">
        <!--Font Awesome CSS-->
        <link rel="stylesheet" href="{{asset('src/font-awesome/css/font-awesome.css')}}">

        <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="{{asset('src/css/clean-blog.min.css')}}">

        @yield('elave-css-file')
        @yield('elave-css-style')

    </head>
    <body>
        @include('includes.naviqasiya')
        @yield('header')
        @yield('content')
        @include('includes.footer')

        <!--JQuery kitabxanasi-->
        <script type="text/javascript" src="{{asset('src/js/jquery.min.js')}}"></script>
        <!--Popper JS (bootstrap ucun)-->
        <script type="text/javascript" src="{{asset('src/js/popper.min.js')}}"></script>
        <!--Bootstarp 4 beta1 JS-->
        <script type="text/javascript" src="{{asset('src/js/bootstrap.min.js')}}"></script>

        <script type="text/javascript" src="{{asset('src/js/clean-blog.min.js')}}"></script>

        @yield('elave-js-file')
        @yield('elave-js-script')
    </body>
</html>