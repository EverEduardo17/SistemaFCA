@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $cohorte[0]->NombreCohorte) }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agregar Estudiante</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8"><strong>Agregar Estudiante</strong></h5>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('estudiantes.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombreDatosPersonales">Nombre(s):</label>
                <input name="NombreDatosPersonales" type="text" class="form-control @error('NombreDatosPersonales') is-invalid @enderror" value="{{old('NombreDatosPersonales')}}" placeholder="Ej. Javier">
            </div>
            <div class="form-group">
                <label name="ApellidoPaternoDatosPersonales">Apellido Paterno:</label>
                <input name="ApellidoPaternoDatosPersonales" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" value="{{old('ApellidoPaternoDatosPersonales')}}" placeholder="Ej. Pino">
            </div>
            <div class="form-group">
                <label name="ApellidoMaternoDatosPersonales">Apellido Materno:</label>
                <input name="ApellidoMaternoDatosPersonales" type="text" class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror" value="{{old('ApellidoMaternoDatosPersonales')}}" placeholder="Ej. Herrera">
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col">
                        <label name="IdCohorte">Cohorte de pertenencia:</label>
                        <input name="NombreCohorte" type="text" class="form-control @error('NombreCohorte') is-invalid @enderror" value="{{$cohorte[0]->NombreCohorte}}" placeholder="Ej. S170" disabled></input>
                        <input name="IdCohorte" type="hidden" class="form-control @error('IdCohorte') is-invalid @enderror" value="{{$cohorte[0]->IdCohorte}}"></input>
                    </div>
                    <div class="col">
                        <label name="MatriculaEstudiante">Matrícula:</label>
                        <input name="MatriculaEstudiante" type="text" class="form-control @error('MatriculaEstudiante') is-invalid @enderror" value="{{old('MatriculaEstudiante')}}" placeholder="Ej. S17016281" maxlength="9">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col">
                        <label name="IdProgramaEducativo">Programa Educativo:</label>
                        <select name="IdProgramaEducativo" class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
                            @foreach ($programas as $programa)
                            <option value="{{ $programa->IdProgramaEducativo }}"> {{ $programa->NombreProgramaEducativo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label name="IdGrupo">Grupo de pertenencia:</label>
                        <select name="IdGrupo" class="form-control @error('IdGrupo') is-invalid @enderror">
                            @foreach ($grupos as $grupo)
                            <option value="{{ $grupo->IdGrupo }}"> {{ $grupo->NombreGrupo }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-row">
                    <div class="col">
                        <label name="IdModalidad">Modalidad de entrada:</label>
                        <select name="IdModalidad" class="form-control @error('IdModalidad') is-invalid @enderror">
                            @foreach ($modalidades as $modalidad)
                            <option value="{{ $modalidad->IdModalidad }}"> {{ $modalidad->NombreModalidad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label name="Genero">Género:</label>
                        <select name="Genero" class="form-control @error('Genero') is-invalid @enderror">
                            <option value="Mujer">Mujer</option>
                            <option value="Hombre">Hombre</option>
                        </select>
                    </div>
                </div>
            </div>

            <br>
            <button type="submit" class="btn btn-primary btn-block">Agregar Estudiante</button>
            <a href="{{ route('cohortes.show', $cohorte[0]->IdCohorte) }}" class="btn btn-secondary btn-block">Cancelar</a>

        </form>
    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection