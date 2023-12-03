@extends('layouts.app')

@section('content')

@can('havepermiso', 'constancias-detalles')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
            <li class="breadcrumb-item"><a href="{{ route('constancias.show', $constancia->IdConstancia) }}">{{ $constancia->NombreConstancia }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"> {{ $estudiante->MatriculaEstudiante }} </li>
        </ol>
    </nav>
@endcan

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                {{ optional($estudiante->Usuario->DatosPersonales)->ApellidoPaternoDatosPersonales }}
                {{ optional($estudiante->Usuario->DatosPersonales)->ApellidoMaternoDatosPersonales }}
                {{ optional($estudiante->Usuario->DatosPersonales)->NombreDatosPersonales }}
            </h5>
            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">Regresar</a>

            <a class="btn btn-primary col-4" href="{{ route('constancias.download', ['constancia' => $constancia, 'estudiante' => $estudiante]) }}" role="button">
                Descargar Constancia
            </a>
        </div>
    </div>
    <div class="card-body">
        <p>
            <strong>Nombre Completo: </strong>
            {{ optional($estudiante->Usuario->DatosPersonales)->ApellidoPaternoDatosPersonales }}
            {{ optional($estudiante->Usuario->DatosPersonales)->ApellidoMaternoDatosPersonales }}
            {{ optional($estudiante->Usuario->DatosPersonales)->NombreDatosPersonales }}
        </p>
        <p>
            <strong>Matrícula:</strong> {{ $estudiante->MatriculaEstudiante }}
        </p>
            <strong>Programa Educativo:</strong> 
                {{ $estudiante->trayectoria->ProgramaEducativo->NombreProgramaEducativo ?? $estudiante->Usuario->password }}
        </p>
        <p>
            <strong>Constancia:</strong> 
                {{ $constancia->NombreConstancia }}
        </p>
        
        <br>
        <p>
            @php
                use Carbon\Carbon;

                $fechaActual = Carbon::now();
                $resultado = validarFecha($fechaActual, $constancia->VigenteHasta);
            @endphp
        
            {{ $resultado }}        
        </p>

        <p>
            
        </p>
    </div>
</div>
@endsection