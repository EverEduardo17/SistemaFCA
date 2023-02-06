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

    <!--FontAwesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    {{-- Extras --}}
    @yield('head')
</head>

<body class="d-flex flex-column">
    @include('layouts.header')

    <main role="main" class="flex-shrink-0 py-1">
        <div class="container">
            @include('layouts.messages')
            @yield('breadcrumb')
            <ul class="nav justify-content-center  mb-2">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}"><em class="fas fa-home"></em> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('empresas.index')}}"><em class="fas fa-building"></em> Gestión de Empresas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('programaEducativo.index')}}"><em class="fas fa-chalkboard"></em> Gestión de Programas Educativos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('grupos.index')}}"><em class="fas fa-users"></em> Gestión de Grupos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cohortes.mostrarCohorte')}}"><em class="fas fa-user"></em> Gestión de Estudiantes</a>
                </li>
            </ul>
            @yield('content')
        </div>
    </main>

    {{-- @include('layouts.footer') --}}

    {{-- Extras --}}
    <script type="text/javascript" src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/popper/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/bootstrap/bootstrap.min.js')}}"></script>

    @yield('script')
</body>

</html>