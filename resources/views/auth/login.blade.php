<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SistemaFCA') }}</title>

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
                <div class="row float-right">
                    <div class="pleca">
                        Universidad Veracruzana
                    </div>
                </div>
                
                <div style="width: 100%; height: 70%; display: table;">
                    <div style="display: table-cell; vertical-align: middle;">
                        <div class="row" style="margin-top: 3em;">
                            <div id="miuv">
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
                        <div class="row" style="margin-top: 3em;">
                            <div id="divUsrInt">
                                <input name="txtUser" type="text" id="txtUser" class="txt-login" placeholder="Usuario"
                                    autocomplete="off" onKeyPress="return isOk(event);" />
                                <span id="rfv1" style="visibility:hidden;"></span>
                            </div>
                        </div>
                        <div class="row" id="divPsw">
                            <div id="divPswInt">
                                <input name="txtPassword" type="password" id="txtPassword" class="txt-login"
                                    placeholder="Contraseña" />
                                <span id="rfv2" style="visibility:hidden;"></span>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 2em;">
                            <input type="submit" name="btnValidacion" value="Iniciar sesión"
                                onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnValidacion&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))"
                                id="btnValidacion" />
                        </div>
                        <br />
                        <div class="row" id="divCambPsw">
                            <div class="div-linkLogin" id="divLinkCambPsw">
                                <a href="#" id="a-cambioPass" class="a-linkLogin a-linkLogin2"
                                    title="¿Quieres cambiar o recuperar tu contrase&ntilde;a?">¿Quieres cambiar o recuperar
                                    tu contrase&ntilde;a?</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div id="footer">
                    <div class="divDerechosReser">
                        © 2020 Universidad Veracruzana. Todos los derechos reservados
                    </div>
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
