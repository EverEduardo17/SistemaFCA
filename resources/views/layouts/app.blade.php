<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SistemaFCA') }}</title>

    <!-- Scripts -->
    <script type="text/javascript" src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/popper/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/bootstrap/bootstrap.min.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{asset('css/site.css')}}" />
    <link rel="stylesheet" href="{{asset('lib/bootstrap/bootstrap.css')}}" />

    <!--FontAwesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    {{-- Extras --}}
    @yield('head')
</head>
<body class="d-flex flex-column">
    @include('layouts.header')

    <main role="main" class="flex-shrink-0 py-1" style="margin: 60px 10vw 40px 10vw;">
        <div>
            @include('layouts.messages')
            @yield('content')
        </div>
    </main>

    <br>

    @include('layouts.footer')
    
    @yield('script')
</body>
</html>
