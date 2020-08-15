{{--
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
--}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio de Sesión - Universidad Veracruzana</title>
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/signin.css">
    <!-- JQuery -->
    <!-- <script src="../node_modules/jquery/dist/jquery.slim.js"></script> -->
    <!-- JavaScript -->
    <!-- <script src="../node_modules/popper.js/dist/popper.js"></script> -->
    <!-- <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script> -->
    <!-- <script src="../Js/index.js"></script> -->

</head>

<body>
<div class="derecho">
    <img src="/img/plantel.jpg" alt="">
</div>
<div class="izquierdo text-center">
    <form asp-action="Login" class="form-signin">
        <img class="mb-4" src="/img/logo.png" alt="Logo Uv" width="150" height="100">
        <h1 class="h3 mb-3 font-weight-normal">Inicio de sesión</h1>

        <div class="form-group">
            <label for="email" class="sr-only">Correo:</label>
            <input type="text" name="email" class="form-control" placeholder="Correo" required autofocus>
            <span class="text-danger">{{ $message ?? "" }}</span>
        </div>

        <div class="form-group">
            <label for="password" class="sr-only">Contraseña:</label>
            <input type="password" asp-for="password" class="form-control" placeholder="Contraseña" required>
            <span class="text-danger">{{$message ?? ""}}</span>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Recuérdame
                </label>
            </div>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2020 Universidad Veracruzana. Todos los derechos reservados.</p>
    </form>
</div>
<script src="../node_modules/jquery/dist/jquery.slim.js"></script>
<script src="/js/bootstrap/bootstrap.bundle.js"></script>

</body>

</html>
