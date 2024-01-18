@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('academicos.index') }}">Académicos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agregar académico</li>
    </ol>
</nav>
<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Agregar Académico</h5>

            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ url()->previous() }}" role="button">Regresar</a>

            @can('havepermiso', 'academicos-detalles')
                <a class="btn btn-primary col-4" href="{{ route('academicos.index') }}" role="button">Ver Académicos</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('academicos.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')

            <div class="form-group">
                <label name="NombreDatosPersonales">Nombre del Académico:</label>
                <input name="NombreDatosPersonales" value="{{ old('NombreDatosPersonales') }}" type="text" class="form-control @error('NombreDatosPersonales') is-invalid @enderror" placeholder="Ej. Javier">
            </div>
                
            <div class=" form-group">
                <label name="ApellidoPaternoDatosPersonales">Apellido Paterno del Académico:</label>
                <input name="ApellidoPaternoDatosPersonales" value="{{ old('ApellidoPaternoDatosPersonales') }}" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" placeholder="Ej. Pino">
            </div>

            <div class="form-group">
                <label name="ApellidoMaternoDatosPersonales">Apellido Materno del Académico:</label>
                <input name="ApellidoMaternoDatosPersonales" type="text" class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror" value="{{ old('ApellidoMaternoDatosPersonales') }}" placeholder="Ej. Herrera">
            </div>

            <hr>
            <div class=" form-group">
                <label name="NoPersonalAcademico">Número de Personal:</label>
                <input name="NoPersonalAcademico" value="{{ old('NoPersonalAcademico') }}" type="text" class="form-control @error('NoPersonalAcademico') is-invalid @enderror" maxlength="10" placeholder="Ej. 0000000000">
            </div>

            <div class="form-group">
                <label name="RfcAcademico">RFC:</label>
                <input name="RfcAcademico" value="{{ old('RfcAcademico') }}" class="form-control @error('RfcAcademico') is-invalid @enderror" maxlength="13" placeholder="Ej. 0000000000000">
            </div>
            <hr>

            <div class="form-group">
                <label for="IdRole">Rol:</label>
                <select name="IdRole" id="IdRole" class="form-control" disabled>
                    @foreach ($roles as $role)
                        <option value="{{ $role->IdRole }}" @if($role->IdRole === 2) selected @endif>
                            {{ $role->ClaveRole }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label name="name">Nombre de Usuario:</label>
                <input name="name" type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Ej. Javier Pino">
                </div>
                <div class=" form-group">
                <label name="email">Correo electrónico:</label>
                <input name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Ej. correo@correo.com">
            </div>
      
            @can('havepermiso', 'academicos-crear')
                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            @endcan
            @can('havepermiso', 'academicos-listar')
                <a href="{{ route('academicos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
            @endcan
        </form>
    </div>
</div>
@endsection
