@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.show', $constancia->IdConstancia) }}">{{ $constancia->NombreConstancia }}</a></li>
        <li class="breadcrumb-item active" aria-current="page"> {{ $estudiante->MatriculaEstudiante }} </li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                {{ $estudiante->Usuario->DatosPersonales->ApellidoPaternoDatosPersonales }}
                {{ $estudiante->Usuario->DatosPersonales->ApellidoMaternoDatosPersonales }}
                {{ $estudiante->Usuario->DatosPersonales->NombreDatosPersonales }}
            </h5>
            {{-- @can('havepermiso', 'academicos-listar') --}}
                <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">Regresar</a>
                <a class="btn btn-primary col-4" href="{{ route('constancias.show', $constancia->IdConstancia) }}" role="button">Ver Constancia</a>
            {{-- @endcan --}}
        </div>
    </div>
    <div class="card-body">
        <p>
            Esta página hace constancia de que el estudiante 
                {{ $estudiante->Usuario->DatosPersonales->ApellidoPaternoDatosPersonales }}
                {{ $estudiante->Usuario->DatosPersonales->ApellidoMaternoDatosPersonales }}
                {{ $estudiante->Usuario->DatosPersonales->NombreDatosPersonales }}
            con matrícula 
                {{ $estudiante->MatriculaEstudiante }}
            participó en el evento 
                {{ $constancia->NombreConstancia }}
        </p>
    </div>
</div>
@endsection