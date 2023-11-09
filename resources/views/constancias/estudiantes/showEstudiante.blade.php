@extends('layouts.app')

@section('content')

@can('havepermiso', 'documentos-leer')
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
                {{ $estudiante->Usuario->DatosPersonales->ApellidoPaternoDatosPersonales }}
                {{ $estudiante->Usuario->DatosPersonales->ApellidoMaternoDatosPersonales }}
                {{ $estudiante->Usuario->DatosPersonales->NombreDatosPersonales }}
            </h5>
            @can('havepermiso', 'documentos-leer')
                <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">Regresar</a>
            @endcan
            <a class="btn btn-primary col-4" href="{{ route('constancias.download', ['constancia' => $constancia, 'estudiante' => $estudiante]) }}" role="button">
                Descargar Constancia
            </a>
        </div>
    </div>
    <div class="card-body">
        <p>
            Nombre Completo: 
                {{ $estudiante->Usuario->DatosPersonales->ApellidoPaternoDatosPersonales }}
                {{ $estudiante->Usuario->DatosPersonales->ApellidoMaternoDatosPersonales }}
                {{ $estudiante->Usuario->DatosPersonales->NombreDatosPersonales }}
        </p>
        <p>
            Matrícula: {{ $estudiante->MatriculaEstudiante }}
        </p>
            Programa Educativo: 
                {{ $estudiante->Usuario->ProgramaEducativo->NombreProgramaEducativo }}
        </p>
        <p>
            Constancia: 
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