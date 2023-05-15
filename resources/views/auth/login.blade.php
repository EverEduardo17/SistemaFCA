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
<body class="d-flex flex-column h-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" id="colImg">
                <div class="row">
                    <div class="col-md-12">
                        <img src="{{asset('img/plantel.jpg')}}" class="imgLogin" />
                    </div>
                </div>
            </div>
            <div id="divIzq" class="col-sm-12 col-md-6">
                <div class="row float-right pleca">
                    Universidad Veracruzana
                </div>
                
                <div style="width: 100%; height: 70%; display: table;">
                    <div style="display: table-cell; vertical-align: middle;">
                        
                        <div class="row" style="margin-top: 4em;">
                            <div id="sistema-fca">
                                <b>SistemaFCA</b>
                            </div>

                            <div id="inisesion">
                                <b>Inicio de sesión</b>
                            </div>
                            
                            <div id="inisesionMsj">
                                <div id="estado" class="errorMsj"></div>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top: 1em;">
                            <div id="divMsjError">
                                <span id="msjError"></span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="text-center form-group" style="margin-top: 3em; margin-bottom: 2em;">
                                <input name="name" id="name" type="text" style="width: 350px;"
                                    class="txt-login @error('name') is-invalid @enderror"
                                    value="{{old('name')}}" placeholder="Usuario" autofocus
                                >
                                @error('name')
                                    <br> <p class="text-danger small">El campo usuario es obligatorio.</p>
                                @enderror
                                @error('loginError')
                                    <br> <p class="text-danger small"> {{ $message }}</p>
                                @enderror
                            </div>
                        
                            <div class="text-center form-group" style="margin-bottom: 3em;">
                                <input name="password" id="password" type="password" style="width: 350px;"
                                    class="txt-login"
                                    value="{{old('password')}}" placeholder="Contraseña" autofocus
                                >
                                @error('password')
                                    <br> <p class="text-danger small"> {{ $message }}</p>
                                @enderror
                            </div>
                        
                            <div class="row justify-content-center form-group">
                                <button type="submit" class="btn btn-success" style="width: 352px;">
                                    Iniciar Sesión
                                </button>
                            </div>
                        </form>
                        
                        <div class="row justify-content-center">
                            <a href="#" id="" class="">
                                ¿Quiere cambiar o recuperar su contrase&ntilde;a?
                            </a>
                        </div>
                    </div>
                </div>
                <div class="divDerechosReser position-fixed bottom-0 end-0 text-right">
                    © {{ getYear() }} Universidad Veracruzana. Todos los derechos reservados
                </div>
            </div>
        </div>
    </div>

    {{-- Extras --}}
    <script type="text/javascript" src="{{asset('js/jquery-3.5.1.slim.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/popper/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/bootstrap/bootstrap.min.js')}}"></script>
    @yield('script')
</body>
</html>
