<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-color">
        <a href="{{ route('home') }}"><img class="logo" src="{{ asset('img/logo-blanco.png') }}"></a>
        <a class="navbar-brand text-white" href="{{ route('home') }}" >Universidad Veracruzana</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">

            @guest
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                    </li>
                </ul>

            @else

                <div class="position-relative text-right">
                    <a class="text-white dropdown-toggle" href="#" role="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-bottom" aria-labelledby="userDropdown">

                        <a class="dropdown-item"
                            @if (Auth::user()->estudiante)
                                href="{{ route('estudiantes.show', Auth::user()->estudiante->IdEstudiante) }}"
                            @else
                                href="{{ route('academicos.show', Auth::user()->academico->IdAcademico) }}"
                            @endif
                        >
                            Ver Perfil
                        </a>

                        {{-- <a class="dropdown-item" href="#">Opción 2</a> --}}

                        <div class="dropdown-divider"></div>

                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit">Cerrar Sesión</button>
                        </form>

                    </div>
                </div>
            
            @endguest

        </div>
    </nav>
</header>
