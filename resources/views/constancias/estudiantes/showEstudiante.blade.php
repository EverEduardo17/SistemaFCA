@extends('layouts.app')

@section('content')

@can('havepermiso', 'constancias-detalles')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
            <li class="breadcrumb-item"><a href="{{ route('constancias.show', $constancia->IdConstancia) }}">{{ $constancia->NombreConstancia }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"> {{ $usuario->name }} </li>
        </ol>
    </nav>
@endcan

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                {{ optional($usuario->DatosPersonales)->ApellidoPaternoDatosPersonales }}
                {{ optional($usuario->DatosPersonales)->ApellidoMaternoDatosPersonales }}
                {{ optional($usuario->DatosPersonales)->NombreDatosPersonales }}
            </h5>
            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">Regresar</a>

            @if ($constancia->EstadoConstancia == 'APROBADO')
                <a class="btn btn-primary col-4" href="{{ route('constancias.download', ['constancia' => $constancia, 'usuario' => $usuario]) }}" role="button">
                    Descargar Constancia
                </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <p>
            <strong>Nombre Completo: </strong>
            {{ optional($usuario->DatosPersonales)->ApellidoPaternoDatosPersonales }}
            {{ optional($usuario->DatosPersonales)->ApellidoMaternoDatosPersonales }}
            {{ optional($usuario->DatosPersonales)->NombreDatosPersonales }}
        </p>
        <p>
            <strong>Matrícula:</strong> {{ $usuario->Estudiante->MatriculaEstudiante ?? $usuario->academico->NoPersonalAcademico }}
        </p>
            <strong>Programa Educativo:</strong> 
                {{ $usuario->estudiante->trayectoria->ProgramaEducativo->NombreProgramaEducativo ?? $usuario->password }}
        </p>
        <p>
            <strong>Constancia:</strong> 
                {{ $constancia->NombreConstancia }}
        </p>

        <p>
            <strong>Estado:</strong>
                {{ $constancia->EstadoConstancia }}
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