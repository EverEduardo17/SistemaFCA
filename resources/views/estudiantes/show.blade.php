@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('estudiantes.index') }}">Gestión de Estudiantes</a></li>
       <li class="breadcrumb-item active" aria-current="page">{{$estudiante->MatriculaEstudiante}}</li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                <strong>
                    Editar información del Estudiante: 
                    "{{$estudiante->MatriculaEstudiante}}"
                </strong>
            </h5>

            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">Regresar</a>
            <a class="btn btn-secondary col-4" href="javascript:history.back()" role="button">
                Ver Estudiantes
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="form-group">
            <label for="NombreDatosPersonales">Nombre(s):</label>
            <input name="NombreDatosPersonales" type="text"
                class="form-control"
                value="{{old('NombreDatosPersonales').$estudiante->usuario->datosPersonales->NombreDatosPersonales}}"
                disabled>
        </div>
        <div class="form-group">
            <label for="ApellidoPaternoDatosPersonales">Apellido Paterno:</label>
            <input name="ApellidoPaternoDatosPersonales" type="text"
                class="form-control"
                value="{{old('ApellidoPaternoDatosPersonales', $estudiante->usuario->datosPersonales->ApellidoPaternoDatosPersonales)}}"
                disabled>
        </div>
        <div class="form-group">
            <label for="ApellidoMaternoDatosPersonales">Apellido Materno:</label>
            <input name="ApellidoMaternoDatosPersonales" type="text"
                class="form-control"
                value="{{old('ApellidoMaternoDatosPersonales', $estudiante->usuario->datosPersonales->ApellidoMaternoDatosPersonales)}}"
                disabled>
        </div>
        <div class="form-group">

                <div class="form-group">
                    <label for="MatriculaEstudiante">Matrícula:</label>
                    <input name="MatriculaEstudiante" type="text"
                        class="form-control"
                        value="{{old('MatriculaEstudiante', $estudiante->MatriculaEstudiante)}}"
                        placeholder="Ej. S17000000" id="MatriculaEstudiante" disabled>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-group">
                <div class="col">
                    <label for="Genero">Género:</label>

                    <select name="Genero" id="Genero" class="form-control" disabled>
                        <option>
                            {{ $estudiante->usuario->datosPersonales->Genero }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <hr class="my-4">
        
        <a href="{{ route('estudiantes.edit', $estudiante) }}" class="btn btn-primary btn-block ">
            Editar
        </a>
    </div>
</div>
<br>

@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection
