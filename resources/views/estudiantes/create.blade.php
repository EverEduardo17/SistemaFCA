@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Inicio</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('estudiantes.index') }}">Gestión de Estudiantes</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Agregar Estudiante</li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">

            <h5 class="card-title">
                <strong>Agregar estudiante</strong>
            </h5>

            <a class="btn btn-outline-info col-4" href="{{ route('estudiantes.index') }}" role="button">
                Ver Estudiantes
            </a>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('estudiantes.store') }}" autocomplete="off">
            @csrf
            <div class="modal-body">
                @include('layouts.validaciones')
                <div class="form-group">
                    <label name="NombreDatosPersonales">Nombre(s):</label>
                    <input name="NombreDatosPersonales" type="text"
                        class="form-control @error('NombreDatosPersonales') is-invalid @enderror"
                        value="{{old('NombreDatosPersonales')}}" placeholder="Ej. Javier" autofocus>
                </div>
                <div class="form-group">
                    <label name="ApellidoPaternoDatosPersonales">Apellido Paterno:</label>
                    <input name="ApellidoPaternoDatosPersonales" type="text"
                        class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror"
                        value="{{old('ApellidoPaternoDatosPersonales')}}" placeholder="Ej. Pino">
                </div>
                <div class="form-group">
                    <label name="ApellidoMaternoDatosPersonales">Apellido Materno:</label>
                    <input name="ApellidoMaternoDatosPersonales" type="text"
                        class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror"
                        value="{{old('ApellidoMaternoDatosPersonales')}}" placeholder="Ej. Herrera">
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label name="IdCohorte">Cohorte de pertenencia:</label>

                            <select name="IdCohorte" id="IdCohorte" class="form-control @error('IdCohorte') is-invalid @enderror">
                                @foreach ($cohortes as $cohorte)
                                    <option value="{{ $cohorte->IdCohorte }}"> 
                                        {{ $cohorte->NombreCohorte }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col">
                            <label name="MatriculaEstudiante">Matricula:</label>
                            <input name="MatriculaEstudiante" type="text"
                                class="form-control @error('MatriculaEstudiante') is-invalid @enderror"
                                value="{{old('MatriculaEstudiante')}}" placeholder="Ej. S17016281" maxlength="9">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label name="IdProgramaEducativo">Programa Educativo:</label>
                            <select name="IdProgramaEducativo" id="IdProgramaEducativo" class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
                                @foreach ($programasEducativos as $programaEducativo)
                                    <option value="{{ $programaEducativo->IdProgramaEducativo }}"> 
                                        {{ $programaEducativo->NombreProgramaEducativo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label name="IdGrupo">Grupo de pertenencia:</label>
                            <select name="IdGrupo" id="IdGrupo" class="form-control @error('IdGrupo') is-invalid @enderror">
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->IdGrupo }}"> 
                                        {{ $grupo->NombreGrupo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label name="IdModalidad">Modalidad de entrada:</label>
                            <select name="IdModalidad" class="form-control @error('IdModalidad') is-invalid @enderror" id="IdModalidad">
                                @foreach ($modalidades as $modalidad)

                                    @if ($modalidad->TipoModalidad == "Entrada") 
                                        <option value="{{ $modalidad->IdModalidad }}"> 
                                            {{ $modalidad->NombreModalidad }}
                                        </option>
                                    @endif     
                                                                           
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label name="Genero">Género:</label>
                            <select name="Genero" class="form-control @error('Genero') is-invalid @enderror">
                                <option value="Mujer" @if(old('Genero')=="Mujer" )selected @endif>Mujer</option>
                                <option value="Hombre" @if(old('Genero')=="Hombre" )selected @endif>Hombre</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="traslado" @if(old('IdModalidad') != 4 )style="display:none"@endif>
                    <div class="form-row">
                        <div class="col">
                            <label name="Facultad">Facultad de procedencia:</label>
                            <input name="NombreFacultad" type="text"
                                class="form-control @error('NombreFacultad') is-invalid @enderror"
                                value="{{old('NombreFacultad')}}" placeholder="Ej. FCA">
                        </div>
                        <div class="col">
                            <label name="Campus">Campus de procedencia:</label>
                            <input name="NombreCampus" type="text" class="form-control @error('NombreCampus') is-invalid @enderror"
                                value="{{old('NombreCampus')}}" placeholder="Ej. Coatzacoalcos">
                        </div>
                    </div>
                </div>
            </div>

            @can('havepermiso', 'estudiante-crear')
                <button type="submit" class="btn btn-primary btn-block">Agregar Estudiante</button>
            @endcan
            <a href="javascript:history.back()" class="btn btn-secondary btn-block ">Cancelar</a>

        </form>
    </div>
</div>
@endsection