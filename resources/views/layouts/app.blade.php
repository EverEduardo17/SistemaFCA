<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SistemaFCA') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{asset('css/site.css')}}" />
    <link rel="stylesheet" href="{{asset('lib/bootstrap/bootstrap.css')}}" />
    
    {{-- Extras --}}
    @yield('head')
</head>
<body class="d-flex flex-column h-100">
    @include('layouts.header')


    <main role="main" class="flex-shrink-0 py-8 ">
        <div class="container">
            @include('layouts.messages')
            @yield('content')
        </div>
    </main>

    {{-- @include('layouts.footer') --}}
        
    {{-- Extras --}}
    <script type="text/javascript" src="{{asset('js/jquery-3.5.1.slim.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/popper/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/bootstrap/bootstrap.min.js')}}"></script>
    @yield('script')
</body>
</html>
