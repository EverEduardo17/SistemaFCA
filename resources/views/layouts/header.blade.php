<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-color">
        <a href="{{ url('/home') }}"><img class="logo" src="{{ asset('img/logo-blanco.png') }}"></a>
        <a class="navbar-brand text-white" href="{{ url('/home') }}" >Universidad Veracruzana</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">

            @guest
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white item-center" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                    </li>
                </ul>

            @else

            <div class="position-relative text-right" >
                <a href="{{ route('ayuda') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512" style="margin-right:16px;"><!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ffffff" d="M256 8C119 8 8 119.1 8 256c0 137 111 248 248 248s248-111 248-248C504 119.1 393 8 256 8zm0 448c-110.5 0-200-89.4-200-200 0-110.5 89.5-200 200-200 110.5 0 200 89.5 200 200 0 110.5-89.4 200-200 200zm107.2-255.2c0 67.1-72.4 68.1-72.4 92.9V300c0 6.6-5.4 12-12 12h-45.6c-6.6 0-12-5.4-12-12v-8.7c0-35.7 27.1-50 47.6-61.5 17.6-9.8 28.3-16.5 28.3-29.6 0-17.2-22-28.7-39.8-28.7-23.2 0-33.9 11-48.9 30-4.1 5.1-11.5 6.1-16.7 2.1l-27.8-21.1c-5.1-3.9-6.3-11.1-2.6-16.4C184.8 131.5 214.9 112 261.8 112c49.1 0 101.5 38.3 101.5 88.8zM298 368c0 23.2-18.8 42-42 42s-42-18.8-42-42 18.8-42 42-42 42 18.8 42 42z"/></svg>
                </a>
                <a class="text-white dropdown-toggle" href="#" role="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-bottom" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('academicos.show', Auth::user()->IdUsuario) }}">Ver Perfil</a>
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
