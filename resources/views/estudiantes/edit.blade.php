@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('estudiantes.index') }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$estudiante->trayectoria->estudiante->MatriculaEstudiante}}</li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                <strong>
                    Editar información del Estudiante: 
                    "{{$estudiante->trayectoria->estudiante->MatriculaEstudiante}}"
                </strong>
            </h5>

            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">Regresar</a>
            <a class="btn btn-secondary col-4" href="{{ route('estudiantes.index') }}" role="button">
                Ver Estudiantes
            </a>
        </div>
    </div>

    <div class="card-body">

        <div class="card">
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    
                    <form method="POST" action="{{ route('estudiantes.update',$estudiante) }}" autocomplete="off">
                        @csrf 
                        @method('PATCH')
                        @include('layouts.validaciones')

                        <div class="form-group">
                            <label for="NombreDatosPersonales">Nombre(s):</label>
                            <input name="NombreDatosPersonales" type="text"
                                class="form-control @error('NombreDatosPersonales') is-invalid @enderror"
                                value="{{old('NombreDatosPersonales', $estudiante->trayectoria->datosPersonales->NombreDatosPersonales ) }}"
                                placeholder="Ej. Javier" id="NombreDatosPersonales">
                        </div>
                        <div class="form-group">
                            <label for="ApellidoPaternoDatosPersonales">Apellido Paterno:</label>
                            <input name="ApellidoPaternoDatosPersonales" type="text"
                                class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror"
                                value="{{old('ApellidoPaternoDatosPersonales', $estudiante->trayectoria->datosPersonales->ApellidoPaternoDatosPersonales)}}"
                                placeholder="Ej. Pino" id="ApellidoPaternoDatosPersonales">
                        </div>
                        <div class="form-group">
                            <label for="ApellidoMaternoDatosPersonales">Apellido Materno:</label>
                            <input name="ApellidoMaternoDatosPersonales" type="text"
                                class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror"
                                value="{{old('ApellidoMaternoDatosPersonales', $estudiante->trayectoria->datosPersonales->ApellidoMaternoDatosPersonales)}}"
                                placeholder="Ej. Herrera" id="ApellidoMaternoDatosPersonales">
                        </div>
                        <div class="form-group">
                            <div class="form-row">

                                <div class="col">
                                    <label for="IdCohorte">Cohorte de pertenencia:</label>

                                    <select name="IdCohorte" id="IdCohorte" class="form-control @error('IdCohorte') is-invalid @enderror">
                                        @foreach ($cohortes as $cohorte)
                                            <option value="{{ $cohorte->IdCohorte }}" @if($estudiante->trayectoria->IdCohorte === $cohorte->IdCohorte) selected @endif > 
                                                {{ $cohorte->NombreCohorte }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col">
                                    <label for="MatriculaEstudiante">Matrícula:</label>
                                    <input name="MatriculaEstudiante" type="text"
                                        class="form-control @error('MatriculaEstudiante') is-invalid @enderror"
                                        value="{{old('MatriculaEstudiante', $estudiante->trayectoria->estudiante->MatriculaEstudiante)}}"
                                        placeholder="Ej. S17000000" id="MatriculaEstudiante">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="form-row">
                                <div class="col">
                                    <label for="IdProgramaEducativo">Programa Educativo de pertenencia:</label>
                                    
                                    <select name="IdProgramaEducativo" id="IdProgramaEducativo" class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
                                        @foreach ($programasEducativos as $programaEducativo)
                                            <option value="{{ $programaEducativo->IdProgramaEducativo }}" @if($estudiante->trayectoria->IdProgramaEducativo === $programaEducativo->IdProgramaEducativo) selected @endif > 
                                                {{ $programaEducativo->NombreProgramaEducativo }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                
                                <div class="col">
                                    <label for="IdGrupo">Grupo de pertenencia:</label>

                                    <select name="IdGrupo" id="IdGrupo" class="form-control @error('IdGrupo') is-invalid @enderror">
                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->IdGrupo }}" @if($estudiante->trayectoria->IdGrupo === $grupo->IdGrupo) selected @endif > 
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
                                    <label for="modalidad">Modalidad de entrada:</label>

                                    <select name="IdModalidad" class="form-control @error('IdModalidad') is-invalid @enderror" id="IdModalidad">
                                        @foreach ($modalidades as $modalidad)

                                            @if ($modalidad->TipoModalidad == "Entrada") 
                                                <option value="{{ $modalidad->IdModalidad }}" @if($estudiante->trayectoria->IdModalidad === $modalidad->IdModalidad) selected @endif > 
                                                    {{ $modalidad->NombreModalidad }}
                                                </option>
                                            @endif     
                                                                                   
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col">
                                    <label for="Genero">Género:</label>

                                    <select name="Genero" id="Genero" class="form-control @error('Genero') is-invalid @enderror">
                                        <option value="Mujer" @if($estudiante->trayectoria->datosPersonales->Genero === "Mujer") selected @endif >
                                            Mujer
                                        </option>
                                        <option value="Hombre" @if($estudiante->trayectoria->datosPersonales->Genero === "Hombre") selected @endif >
                                            Hombre
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
  
                        <div class="form-group">
                            @can('havepermiso', 'estudiante-editar-propio')
                                <button type="submit" class="btn btn-primary btn-block">
                                    Actualizar Información
                                </button>
                            @endcan
                            <a href="javascript:history.back()" class="btn btn-secondary btn-block ">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection
