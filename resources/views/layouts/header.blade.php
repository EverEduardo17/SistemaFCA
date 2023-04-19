<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-color">
        <a href="{{ url('/home') }}">
            <img class="logo" src="{{ asset('img/logo-blanco.png') }}">
        </a>
        <a class="navbar-brand text-white" href="{{ url('/home') }}" >
            Universidad Veracruzana
        </a>

        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <span class="navbar-text text-white">
                {{Auth::user()->name ?? "Invitado"}}
            </span>
        </div>
    </nav>
</header>
