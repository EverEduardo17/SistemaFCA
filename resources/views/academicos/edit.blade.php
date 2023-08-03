@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('academicos.index') }}">Académicos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('academicos.index') }}">{{$academico->usuario->datospersonales->ApellidoPaternoDatosPersonales}} {{$academico->usuario->datospersonales->ApellidoMaternoDatosPersonales}} {{$academico->usuario->datospersonales->NombreDatosPersonales}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar académico</li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Editar Académico</h5>
            @can('havepermiso', 'academicos-listar')
                <a class="btn btn-primary col-4" href="{{ route('academicos.index') }}" role="button">Ver Académicos</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('academicos.update', $academico) }}" autocomplete="off">
            @csrf
            @method('PATCH')
            @include('layouts.validaciones')

            <div class="form-group">
                <label name="NombreDatosPersonales">Nombre del Académico:</label>
                <input name="NombreDatosPersonales" type="text" class="form-control @error('NombreDatosPersonales') is-invalid @enderror" value="{{ old('NombreDatosPersonales', $academico->usuario->datospersonales->NombreDatosPersonales) }}" placeholder="Ej. Javier">
            </div>

            <div class="form-group">
                <label name="ApellidoPaternoDatosPersonales">Apellido Paterno del Académico:</label>
                <input name="ApellidoPaternoDatosPersonales" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" value="{{ old('ApellidoPaternoDatosPersonales', $academico->usuario->datospersonales->ApellidoPaternoDatosPersonales) }}" placeholder="Ej. Pino">
            </div>

            <div class="form-group">
                <label name="ApellidoMaternoDatosPersonales">Apellido Materno del Académico:</label>
                <input name="ApellidoMaternoDatosPersonales" type="text" class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror" value="{{ old('ApellidoMaternoDatosPersonales', $academico->usuario->datospersonales->ApellidoMaternoDatosPersonales) }}" placeholder="Ej. Herrera">
            </div>

            <hr>

            <div class="form-group">
                <label name="NoPersonalAcademico">Número de Personal:</label>
                <input name="NoPersonalAcademico" type="text" class="form-control @error('NoPersonalAcademico') is-invalid @enderror" maxlength="10" value="{{ old('NoPersonalAcademico', $academico->NoPersonalAcademico) }}" placeholder="Ej. 0000000000">
            </div>

            <div class="form-group">
                <label name="RfcAcademico">RFC:</label>
                <input name="RfcAcademico" class="form-control @error('RfcAcademico') is-invalid @enderror" maxlength="13" value="{{ old('RfcAcademico', $academico->RfcAcademico) }}" placeholder="Ej. 000000000000">
            </div>

            <hr>

            <div class="form-group">
                <label name="name">Nombre de Usuario:</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $academico->usuario->name) }}" placeholder="Ej. Javier Pino">
            </div>

            <div class="form-group">
                <label for="IdRole">Rol:</label>
                <select name="IdRole" id="IdRole" class="form-control @error('IdRole') is-invalid @enderror">
                    @foreach ($roles as $role)
                        <option value="{{ $role->IdRole  }}" @if($academico->usuario->roles[0]->IdRole === $role->IdRole) selected @endif>
                            {{ $role->ClaveRole }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label name="email">Correo electrónico:</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $academico->usuario->email) }}" placeholder="Ej. correo@correo.com">
            </div>

            <div class="form-group">
                <label name="password">Contraseña:</label> 
                <a href="#" id="toggleLink" class="btn btn-light ml-2 shadow-sm" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; color:blue;">¿Cambiar Contraseña?</a>
                <input id="password-input" name="password" type="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" minlength="8" placeholder="Ej. Contraseña123" disabled>
            </div>

            @can('havepermiso', 'academicos-editar')
                <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
            @endcan
            @can('havepermiso', 'academicos-listar')
                <a href="{{ route('academicos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
            @endcan
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/password-popup.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#toggleLink').click(function(e) {
                e.preventDefault();
                var passwordInput = $('#password-input');
                if (passwordInput.val() === '') {
                passwordInput.prop('disabled', !passwordInput.prop('disabled'));
                passwordInput.focus();
                }
            });
        });
    </script>
@endsection
