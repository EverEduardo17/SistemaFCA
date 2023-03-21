@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarCohorte') }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $cohorte->NombreCohorte) }}">Cohorte
                {{ $cohorte->NombreCohorte }}</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('cohortes.mostrarGrupo', [$grupo->cohorte->NombreCohorte, $grupo->NombreGrupo]) }}">{{ $grupo->NombreGrupo }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Agregar Estudiante</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8"><strong>Agregar estudiante al grupo "{{$grupo->NombreGrupo}}" del cohorte
                    "{{$grupo->cohorte->NombreCohorte}}"</strong></h5>
            <a class="btn btn-outline-info col-4" href="{{ route('estudiantesGrupo', $grupo->IdGrupo) }}"
                role="button">Ver Estudiantes</a>
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
                        value="{{old('NombreDatosPersonales')}}" placeholder="Ej. Javier">
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
                            <input name="NombreCohorte" type="text"
                                class="form-control @error('NombreCohorte') is-invalid @enderror"
                                value="{{$cohorte->NombreCohorte}}" placeholder="Ej. S170" disabled></input>
                            <input name="IdCohorte" type="hidden"
                                class="form-control @error('IdCohorte') is-invalid @enderror"
                                value="{{$cohorte->IdCohorte}}"></input>
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
                            <input name="NombreProgramaEducativo" type="text"
                                class="form-control @error('NombreProgramaEducativo') is-invalid @enderror"
                                value="{{$programaEducativo->NombreProgramaEducativo}}" disabled>
                            <input name="IdProgramaEducativo" type="hidden"
                                class="form-control @error('IdProgramaEducativo') is-invalid @enderror"
                                value="{{$programaEducativo->IdProgramaEducativo}}">
                        </div>
                        <div class="col">
                            <label name="IdGrupo">Grupo de pertenencia:</label>
                            <input name="NombreGrupo" type="text"
                                class="form-control @error('NombreGrupo') is-invalid @enderror"
                                value="{{$grupo->NombreGrupo}}" placeholder="Ej. LIS 701" disabled>
                            <input name="IdGrupo" type="hidden"
                                class="form-control @error('IdGrupo') is-invalid @enderror" value="{{$grupo->IdGrupo}}"
                                placeholder="Ej. LIS 701">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label name="IdModalidad">Modalidad de entrada:</label>
                            <select name="IdModalidad" class="form-control @error('IdModalidad') is-invalid @enderror"
                                id="modalidad">
                                @foreach ($modalidades as $modalidad)
                                <option value="{{ $modalidad->IdModalidad }}" @if(old('IdModalidad')==$modalidad->
                                    IdModalidad)selected @endif>{{ $modalidad->NombreModalidad }}</option>
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

                <div class="form-group" id="traslado" @if(old('IdModalidad') !=4 )style="display:none" @endif>
                    <div class="form-row">
                        <div class="col">
                            <label name="Facultad">Facultad de procedencia:</label>
                            <input name="NombreFacultad" type="text"
                                class="form-control @error('NombreFacultad') is-invalid @enderror"
                                value="{{old('NombreFacultad')}}" placeholder="Ej. FCA">
                        </div>
                        <div class="col">
                            <label name="Campus">Campus de procedencia:</label>
                            <input name="NombreCampus" type="text"
                                class="form-control @error('NombreCampus') is-invalid @enderror"
                                value="{{old('NombreCampus')}}" placeholder="Ej. Coatzacoalcos">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Agregar Estudiante</button>
            <a href="{{ route('estudiantesGrupo', $grupo->IdGrupo) }}" class="btn btn-secondary btn-block ">Cancelar</a>

        </form>
    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')
<script>
    $(document).ready( function(){
        $(document).on('change','#modalidad', function(){
            var seleccion = $('#modalidad option:selected').text();
            if( seleccion == "Traslado" ){
                $('#traslado').show();
            }else{
                $('#traslado').hide();
            }
        });
    });
    
</script>
@endsection