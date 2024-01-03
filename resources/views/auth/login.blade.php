<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Iniciar Sesión') }} - SistemaFCA</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{asset('css/signin.css')}}" />
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/bootstrap-grid.min.css')}}" />
    
    
    {{-- Extras --}}
    @yield('head')
</head>
<body>
    <div style="display: flex;">
        <div class="pleca">
            <a href="{{ route('home') }}" style="color: white">
            Universidad Veracruzana
            </a>
        </div>

        <div id="colImg">
            <img src="{{asset('img/plantel.jpg')}}" style="height: 100vh; width: 100%; object-fit: cover;" />
        </div>
        <div id="divIzq">
            
            <div >
                @include('layouts.alpinejs-messages')
                    
                <div id="sistema-fca">
                    <b>SistemaFCA</b>
                </div>

                <div id="inisesion">
                    <b>Inicio de sesión</b>
                </div>
            
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="text-center form-group" style="margin-top: 3em; margin-bottom: 2em;">
                        <input name="name" id="name" type="text" style="width: 350px;"
                            class="txt-login @error('name') txt-login-error @enderror"
                            value="{{old('name')}}" placeholder="Usuario" autofocus
                        >
                        @error('name')
                            <br> <p class="text-danger small">El campo usuario es obligatorio.</p>
                        @enderror
                    </div>
                
                    <div class="row justify-content-center form-group" style="margin-bottom:24vh">
                        <button type="submit" class="btn btn-success shadow-sm" style="width: 352px;">
                            Iniciar Sesión
                        </button>
                    </div>
                </form>
            </div>

            <div class="divDerechosReser position-fixed bottom-0 end-0 text-right">
                © {{ getYear() }} Universidad Veracruzana. Todos los derechos reservados
            </div>
        </div>
    </div>

    {{-- Extras --}}
    {{-- <script type="text/javascript" src="{{asset('js/jquery-3.5.1.slim.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/popper/popper.min.js')}}"></script> --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript" src="{{asset('lib/bootstrap/bootstrap.min.js')}}"></script>
    @yield('script')
</body>
</html>
