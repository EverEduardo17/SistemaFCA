<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-color">
        {{-- <img class="logo" src="{{ asset('img/logo.png') }}"> --}}
        <a class="navbar-brand text-black" href="{{ url('/') }}" >Universidad Veracruzana</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
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
            <span class="navbar-text">
                {{Auth::user()->name ?? "Invitado"}}
            </span>
        </div>
    </nav>
</header>