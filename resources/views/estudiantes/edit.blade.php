@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('grupos.show', $estudiante->trayectoria->grupo->IdGrupo) }}">
                {{$estudiante->trayectoria->grupo->NombreGrupo}} - {{$estudiante->trayectoria->cohorte->NombreCohorte}}
            </a>
        </li>

        <li class="breadcrumb-item"><a
                href="{{ route('grupos.estudiantes', $estudiante->trayectoria->grupo->IdGrupo) }}">Estudiantes</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$estudiante->trayectoria->estudiante->MatriculaEstudiante}}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-center">
            <h5 class="card-title col-8"><strong>Editar información del Estudiante:
                    "{{$estudiante->trayectoria->estudiante->MatriculaEstudiante}}"</strong></h5>
            <a class="btn btn-secondary col-4" href="javascript:history.back()" role="button">
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
                                value="{{old('NombreDatosPersonales').$estudiante->trayectoria->datosPersonales->NombreDatosPersonales}}"
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
                                    <label for="IdProgramaEducativo">Programa Educativo de pertenencia:</label>
                                    <select name="IdProgramaEducativo" id="IdProgramaEducativo"
                                        class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
                                        
                                    </select>
                                </div>

                                <div class="col">
                                    <label for="MatriculaEstudiante">Matrícula:</label>
                                    <input name="MatriculaEstudiante" type="text"
                                        class="form-control @error('MatriculaEstudiante') is-invalid @enderror"
                                        value="{{old('MatriculaEstudiante', $estudiante->trayectoria->estudiante->MatriculaEstudiante)}}"
                                        placeholder="Ej. S17016281" id="MatriculaEstudiante">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label for="IdProgramaEducativo">Programa Educativo de pertenencia:</label>
                                    <select name="IdProgramaEducativo" id="IdProgramaEducativo"
                                        class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
                                        
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="IdGrupo">Grupo de pertenencia:</label>
                                    <select name="IdGrupo" id="IdGrupo"
                                        class="form-control @error('IdGrupo') is-invalid @enderror">
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label for="modalidad">Modalidad de entrada:</label>
                                    <select name="IdModalidad" class="form-control @error('IdModalidad') is-invalid @enderror"
                                        id="modalidad">
                                        
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="Genero">Género:</label>
                                    <select name="Genero" id="Genero"
                                        class="form-control @error('Genero') is-invalid @enderror">
                                        <option value="Mujer" @if($estudiante->trayectoria->datosPersonales->Genero == "Mujer")
                                            selected @endif >Mujer</option>
                                        <option value="Hombre" @if($estudiante->trayectoria->datosPersonales->Genero ==
                                            "Hombre") selected @endif >Hombre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="trasladoEntrante" @if((old('IdModalidad') != 4) || $estudiante->trayectoria->IdModalidad != 4) style="display:none"@endif>
                            <div class="form-row">
                                <div class="col">
                                    <label for="Facultad">Facultad de procedencia:</label>
                                    <input name="NombreFacultad" type="text" 
                                        class="form-control @error('NombreFacultad') is-invalid @enderror"
                                        value="{{old('NombreFacultad')}}" placeholder="Ej. FCA" id="Facultad">
                                </div>
                                <div class="col">
                                    <label for="Campus">Campus de procedencia:</label>
                                    <input name="NombreCampus" type="text"
                                        class="form-control @error('NombreCampus') is-invalid @enderror"
                                        value="{{old('NombreCampus')}}" placeholder="Ej. Coatzacoalcos" id="Campus">
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Actualizar Información
                            </button>
                            
                            <a href="javascript:history.back()" class="btn btn-secondary btn-block ">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

            
{{-- @include('estudiantes.modals.traslado')
@include('estudiantes.modals.reprobado')
@include('estudiantes.modals.baja')
@include('estudiantes.modals.practica')
@include('estudiantes.modals.servicio')
@include('estudiantes.modals.titulo') --}}

@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script>
    $(document).ready( function(){
        $(document).on('change','#modalidad', function(){
            alert.show("Hola :D");
            var seleccion = $('#modalidad option:selected').text();
            if( seleccion == "Traslado" ){
                alert.show("Traslado");
                $('#trasladoEntrante').show();
            }else{
                alert.show("Otro");
                $('#trasladoEntrante').hide();
            }
        });
    });
</script>
<script>
    $('#traslado').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
</script>
<script>
    $('#reprobado').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
</script>
<script>
    $('#baja').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
</script>
<script>
    $('#practica').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
</script>
<script>
    $('#servicio').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
</script>
<script>
    $('#titulo').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
</script>
@endsection