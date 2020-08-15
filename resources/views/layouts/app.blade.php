<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="/css/site.css" />

    <link rel="stylesheet" href="{{asset('lib/bootstrap/bootstrap.min.css')}}" />
    @yield('head')
</head>
<body>
    <div id="app">
        <header>
            <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light box-shadow mb-3 ">
                <div class="container">
                    <img class="logo" src="/img/logo.png">
                    <a class="navbar-brand text-black" href="{{ url('/') }}" >Universidad Veracruzana</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse d-sm-inline-flex flex-sm-row-reverse">
                        <ul class="navbar-nav flex-grow-1">
                            <li class="nav-item justify-content-start">
                                {{\Illuminate\Support\Facades\Auth::user()->name ?? "Invitado"}}
                            </li>
                            <li class="nav-item dropdown justify-content-start">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Elementos
                                </a>
                                <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" asp-area="" asp-controller="Academias" asp-action="Index">Academias</a>

                                    <a class="dropdown-item" asp-area="" asp-controller="Academicos" asp-action="Index">Academicos</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="AcademicoFechas" asp-action="Index">AcademicoFechas</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Personas" asp-action="Index">Datos Personales</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Documentos" asp-action="Index">Documentos</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Estudiantes" asp-action="Index">Estudiantes</a>

                                    <a class="dropdown-item" asp-area="" asp-controller="Eventos" asp-action="Index">Eventos</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="ExperienciaEducativas" asp-action="Index">Experiencias Educativas</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Facultades" asp-action="Index">Facultades</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Organizadores" asp-action="Index">Organizadores</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Permisos" asp-action="Index">Permisos</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="ProgramaEducativos" asp-action="Index">ProgramaEducativos</a>

                                    <a class="dropdown-item" asp-area="" asp-controller="Roles" asp-action="Index">Roles</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="SedeEventos" asp-action="Index">SedeEventos</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="TipoOrganizadores" asp-action="Index">TipoOrganizadores</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Usuarios" asp-action="Index">Usuarios</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown justify-content-start">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Elementos Intermedios
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" asp-area="" asp-controller="Academia_Academico" asp-action="Index">Academia_Academico</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Academia_ExperienciaEducativa" asp-action="Index">Academia_ExperienciaEducativa</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Academia_ProgramaEducativo" asp-action="Index">Academia_ProgramaEducativo</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Academico_Evento" asp-action="Index">Academico_Evento</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Documento_Evento" asp-action="Index">Documento_Evento</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="ExperienciaEducativa_ProgramaEducativo" asp-action="Index">ExperienciaEducativa_ProgramaEducativo</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Permiso_Role" asp-action="Index">Permiso_Role</a>
                                    <a class="dropdown-item" asp-area="" asp-controller="Role_Usuario" asp-action="Index">Role_Usuarios</a>


                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main class="py-4">
            @include('layouts.messages')
            @yield('content')
        </main>

        <footer class="border-top footer text-white text-center">
            <div class="container">
                &copy; 2020 Universidad Veracruzana. Todos los derechos reservados.
            </div>
        </footer>
    </div>
    <script type="text/javascript" src="{{asset('lib/jquery/jquery-3.5.0.min.js')}}"></script>
    <script type="text/javascript" src="/lib/popper/popper.min.js"></script>
    <script type="text/javascript" src="/lib/bootstrap/bootstrap.min.js"></script>
    @yield('script')
</body>
</html>
