<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-color">
        <img class="logo" src="{{ asset('img/logo-blanco.png') }}">
        <a class="navbar-brand text-white" href="{{ url('/home') }}" >Universidad Veracruzana</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <span class="navbar-text text-white">
                {{Auth::user()->name ?? "Invitado"}}
            </span>
        </div>
    </nav>
</header>
