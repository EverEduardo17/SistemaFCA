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

            <a class="btn btn-primary col-4" href="{{ route('estudiantes.index') }}" role="button">
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
                                value="{{old('NombreDatosPersonales', $estudiante->usuario->datosPersonales->NombreDatosPersonales ) }}"
                                placeholder="Ej. Javier" id="NombreDatosPersonales"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="ApellidoPaternoDatosPersonales">{{ $estudiante->usuario->datosPersonales->ApellidoMaternoDatosPersonales !== ""? "Apellido Paterno" : "Apellidos" }}</label>
                            <input name="ApellidoPaternoDatosPersonales" type="text"
                                class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror"
                                value="{{ old('ApellidoPaternoDatosPersonales', $estudiante->usuario->datosPersonales->ApellidoPaternoDatosPersonales) }}"
                                placeholder="Ej. Pino" id="ApellidoPaternoDatosPersonales"
                            >
                        </div>
                        @if ($estudiante->usuario->datosPersonales->ApellidoMaternoDatosPersonales !== "")
                            <div class="form-group">
                                <label for="ApellidoMaternoDatosPersonales">Apellido Materno:</label>
                                <input name="ApellidoMaternoDatosPersonales" type="text"
                                    class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror"
                                    value="{{ old('ApellidoMaternoDatosPersonales', $estudiante->usuario->datosPersonales->ApellidoMaternoDatosPersonales) }}"
                                    placeholder="Ej. Herrera" id="ApellidoMaternoDatosPersonales"
                                >
                            </div>
                        @endif
                        
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label for="MatriculaEstudiante">Matrícula:</label>
                                    <input name="MatriculaEstudiante" type="text"
                                        class="form-control @error('MatriculaEstudiante') is-invalid @enderror"
                                        value="{{old('MatriculaEstudiante', $estudiante->MatriculaEstudiante)}}"
                                        placeholder="Ej. S17000000" id="MatriculaEstudiante"
                                    >
                                </div>

                                <div class="col">
                                    <label for="ProgramaEducativo">Programa Educativo de pertenencia:</label>
                                    {{-- De manera temporal, el programa educativo se guardara en texto plano en el campo Contraseña para los nuevos estudiantes --}}
                                    <input name="ProgramaEducativo" type="text" 
                                        class="form-control @error('ProgramaEducativo') is-invalid @enderror" 
                                        value="{{ old('ProgramaEducativo', $estudiante->usuario->password) }}"
                                        placeholder="Ej. Ingeniería De Software" id="ProgramaEducativo" 
                                    >
                                </div> 
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="IdRole">{{ sizeof($estudiante->usuario->roles)>1 ? "Roles:" : "Rol:" }}</label>
                            <input type="text" class="form-control" disabled 
                                value = "@foreach ($estudiante->usuario->roles as $rol) {{ $rol->ClaveRole }} @endforeach"
                            >
                            @can('havepermiso', 'roles-listar')
                                <a href="{{ route('usuario.index.roles', ["usuario" => $estudiante->usuario, "roles" => $estudiante->usuario->roles]) }}" 
                                    class="btn btn-info btn-sm mt-2"
                                >
                                    Modificar Roles
                                </a>
                            @endcan
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label for="Genero">Género:</label>

                                    <select name="Genero" id="Genero" class="form-control @error('Genero') is-invalid @enderror">
                                        <option></option>
                                        <option value="Mujer" @if($estudiante->usuario->datosPersonales->Genero === "Mujer") selected @endif >
                                            Mujer
                                        </option>
                                        <option value="Hombre" @if($estudiante->usuario->datosPersonales->Genero === "Hombre") selected @endif >
                                            Hombre
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
  
                        <div class="form-group">
                            @can('havepermiso', 'estudiantes-detalles')
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
