@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('grupos.show', $trayectoria->grupo->IdGrupo) }}">{{$trayectoria->grupo->NombreGrupo}} - {{$trayectoria->cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('estudiantesGrupo', $trayectoria->grupo->IdGrupo) }}">Estudiantes</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$trayectoria->estudiante->MatriculaEstudiante}}</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-center">
            <h5 class="card-title col-8"><strong>Editar información del Estudiante: "{{$trayectoria->estudiante->MatriculaEstudiante}}"</strong></h5>
            <a class="btn btn-outline-info col-4" href="{{ route('estudiantesGrupo', $trayectoria->grupo->IdGrupo) }}" role="button">Ver Estudiantes</a>
        </div>
    </div>

    <div class="card-body">
        @csrf @method('PATCH')
        @include('layouts.validaciones')
        <div class="accordion my-4" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <h5>Datos Generales</h5>
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <form method="POST" action="{{ route('estudiantes.update',$trayectoria) }}" autocomplete="off">
                            <div class="form-group">
                                <label name="NombreDatosPersonales">Nombre(s):</label>
                                <input name="NombreDatosPersonales" type="text" class="form-control @error('NombreDatosPersonales') is-invalid @enderror" value="{{old('NombreDatosPersonales').$trayectoria->datosPersonales->NombreDatosPersonales}}" placeholder="Ej. Javier">
                            </div>
                            <div class="form-group">
                                <label name="ApellidoPaternoDatosPersonales">Apellido Paterno:</label>
                                <input name="ApellidoPaternoDatosPersonales" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" value="{{old('ApellidoPaternoDatosPersonales', $trayectoria->datosPersonales->ApellidoPaternoDatosPersonales)}}" placeholder="Ej. Pino">
                            </div>
                            <div class="form-group">
                                <label name="ApellidoMaternoDatosPersonales">Apellido Materno:</label>
                                <input name="ApellidoMaternoDatosPersonales" type="text" class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror" value="{{old('ApellidoMaternoDatosPersonales', $trayectoria->datosPersonales->ApellidoMaternoDatosPersonales)}}" placeholder="Ej. Herrera">
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label name="MatriculaEstudiante">Matrícula:</label>
                                        <input name="MatriculaEstudiante" type="text" class="form-control @error('MatriculaEstudiante') is-invalid @enderror" value="{{old('MatriculaEstudiante', $trayectoria->estudiante->MatriculaEstudiante)}}" placeholder="Ej. S17016281">
                                    </div>
                                    <div class="col">
                                        <label name="IdCohorte">Cohorte de pertenencia:</label>
                                        <select name="IdCohorte" class="form-control @error('IdCohorte') is-invalid @enderror">
                                            @foreach ($cohortes as $cohorte)
                                            <option value="{{ $cohorte->IdCohorte }}" @if($trayectoria->IdCohorte == $cohorte->IdCohorte) selected @endif > {{ $cohorte->NombreCohorte }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label name="Genero">Género:</label>
                                        <select name="Genero" class="form-control @error('Genero') is-invalid @enderror">
                                            <option value="Mujer" @if($trayectoria->datosPersonales->Genero == "Mujer") selected @endif >Mujer</option>
                                            <option value="Hombre" @if($trayectoria->datosPersonales->Genero == "Hombre") selected @endif >Hombre</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label name="IdModalidad">Modalidad de entrada:</label>
                                        <select name="IdModalidad" class="form-control @error('IdModalidad') is-invalid @enderror">
                                            @foreach ($modalidades as $modalidad)
                                            @if($modalidad->TipoModalidad == "Entrada")
                                            <option value="{{ $modalidad->IdModalidad }}" @if($trayectoria->IdModalidad == $modalidad->IdModalidad) selected @endif > {{ $modalidad->NombreModalidad }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col">
                                        <label name="IdProgramaEducativo">Programa Educativo de pertenencia:</label>
                                        <select name="IdProgramaEducativo" class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
                                            @foreach ($programas as $programa)
                                            <option value="{{ $programa->IdProgramaEducativo }}" @if($trayectoria->IdProgramaEducativo == $programa->IdProgramaEducativo) selected @endif > {{ $programa->NombreProgramaEducativo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label name="IdGrupo">Grupo de pertenencia:</label>
                                        <select name="IdGrupo" class="form-control @error('IdGrupo') is-invalid @enderror">
                                            @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->IdGrupo }}" @if($trayectoria->IdGrupo == $grupo->IdGrupo) selected @endif > {{ $grupo->NombreGrupo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Actualizar Información</button>
                                <a href="{{ route('mostrarEstudiante', [$trayectoria->IdGrupo,$trayectoria->IdTrayectoria]) }}" class="btn btn-secondary btn-block ">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h5>Formación Académica</h5>
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">

                        <div class="contenedor-botones justify-content-center align-items-center my-3">
                            <a href="#" data-toggle="modal" data-target="#traslado" class="btn btn-outline-dark mr-2"><em class="fas fa-paper-plane"></em> Traslado</a>
                            <a href="#" data-toggle="modal" data-target="#reprobado" class="btn btn-outline-dark mr-2"><em class="fas fa-times-circle"></em> Reprobado</a>
                            <a href="#" data-toggle="modal" data-target="#baja" class="btn btn-outline-dark"><em class="fas fa-minus-circle"></em> Dar de Baja</a>
                        </div>
                        <h5>Traslados</h5>
                        @if (empty($movilidad))
                        <div class="col-5">
                            <p class="contenedor-botones">No hay traslados registrados para el estudiante.</p>
                        </div>
                        @else
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label name="Movilidad">¿Realizó movilidad?</label>
                                    <input name="Movilidad" type="text" class="form-control @error('Movilidad') is-invalid @enderror" @if (empty($movilidad)) value="No" @else value="Sí" @endif placeholder="Ej. Sí" disabled>
                                </div>
                                @if (!empty($movilidad))
                                <div class="col">
                                    <label name="FacultadDestino">Facultad de destino en movilidad:</label>
                                    <input name="FacultadDestino" type="text" class="form-control @error('FacultadDestino') is-invalid @enderror" @if (!empty($movilidad)) value="{{$movilidad->FacultadDestino}}" @endif placeholder="Ej. LIS 701" disabled>
                                </div>
                            </div>
                            <div class="form-row my-3 px-3">
                                <div class="col">
                                    <label name="CampusDestino">Campus de destino en movilidad:</label>
                                    <input name="CampusDestino" type="text" class="form-control @error('CampusDestino') is-invalid @enderror" @if (!empty($movilidad)) value="{{$movilidad->CampusDestino}}" @endif placeholder="Ej. Coatzacoalcos" disabled>
                                </div>
                                <div class="col">
                                    <label name="Periodo">Periodo de movilidad:</label>
                                    <input name="Periodo" type="text" class="form-control @error('Periodo') is-invalid @enderror" @if (!empty($movilidad)) value="{{$movilidad->periodo->NombrePeriodo}}" @endif placeholder="Ej.  AGO - DIC 2020" disabled>
                                </div>
                            </div>
                            @endif
                            @endif
                            <h5>Materias Reprobadas</h5>
                            @if (empty($reprobado))
                            <div class="col-5">
                                <p class="contenedor-botones">No hay materias reprobadas por el estudiante :D</p>
                            </div>
                            @else
                            <div class="form-row">
                                <div class="col">
                                    <label name="Activo">¿Reprobó alguna vez?</label>
                                    <input name="Activo" type="text" class="form-control @error('Activo') is-invalid @enderror" @if (empty($reprobado)) value="No" @else value="Sí" @endif placeholder="Ej. Sí" disabled>
                                </div>
                                <div class="col">
                                    <label name="PeriodoReprobado">Último periodo reprobado:</label>
                                    <input name="PeriodoReprobado" type="text" class="form-control @error('PeriodoReprobado') is-invalid @enderror" value="{{$reprobado->periodo->NombrePeriodo}}" placeholder="Ej. AGO - DIC 2020" disabled>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>



            <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <h5>Formación Terminal</h5>
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="contenedor-botones justify-content-center align-items-center my-3">

                            <a href="#" data-toggle="modal" data-target="#servicio" class="btn btn-outline-dark mr-2"><em class="fas fa-user"></em> Servicio Social</a>
                            <a href="#" data-toggle="modal" data-target="#practica" class="btn btn-outline-dark mr-2"><em class="fas fa-hard-hat"></em> Prácticas Profesionales</a>
                            <a href="#" data-toggle="modal" data-target="#titulo" class="btn btn-outline-dark mr-2"><em class="fas fa-graduation-cap"></em> Egresado</a>
                            <a href="{{ route('empresas.create') }}" class="btn btn-outline-dark mr-2"><em class="fas fa-building"></em> Agregar Empresa</a>
                        </div>
                        <h5>Servicio Social</h5>
                        @if (empty($servicio))
                        <div class="col-5">
                            <p>El estudiante no realiza Servicio Social todavía.</p>
                        </div>
                        @else
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label name="Servicio">¿Ya realizó el Servicio Social?</label>
                                    <input name="Servicio" type="text" class="form-control @error('Servicio') is-invalid @enderror" @if (empty($servicio)) value="No" @else value="Sí" @endif placeholder="Ej. Sí" disabled>
                                </div>
                                @if (!empty($servicio))

                            </div>
                            <div class="col py-2 px-2">
                                <label name="EmpresaServicio">Empresa dónde realizó el Servicio Social:</label>
                                <input name="EmpresaServicio" type="text" class="form-control @error('EmpresaServicio') is-invalid @enderror" value="{{$servicio->empresa->NombreEmpresa}}" placeholder="Ej. LIS 701" disabled>
                            </div>
                            @endif
                        </div>
                        @endif

                        <h5>Prácticas Profesionales</h5>
                        @if (empty($practicas))
                        <div class="col-5">
                            <p>El estudiante no realiza Prácticas Profesionales todavía.</p>
                        </div>
                        @else
                        <div class="form-group">
                            <div class="form-row py-2">
                                <div class="col">
                                    <label name="Practicas">¿Ya realizó las Prácticas Profesionales?</label>
                                    <input name="Practicas" type="text" class="form-control @error('Practicas') is-invalid @enderror" @if (empty($practicas)) value="No" @else value="Sí" @endif placeholder="Ej. Sí" disabled>
                                </div>
                                @if (!empty($practicas))

                            </div>
                            <div class="col py-2 px-2">
                                <label name="EmpresaPracticas">Empresa dónde realizó las Prácticas Profesionales:</label>
                                <input name="EmpresaPracticas" type="text" class="form-control @error('EmpresaPracticas') is-invalid @enderror" value="{{$practicas->empresa->NombreEmpresa}}" placeholder="Ej. LIS 701" disabled>
                            </div>
                            @endif
                        </div>
                        @endif

                        <h5>Titulación</h5>
                        @if (empty($titulacion))
                        <div class="col-5">
                            <p>El estudiante no se titula todavía.</p>
                        </div>
                        @else
                        <div class="form-group">
                            <div class="form-row py-2">
                                <div class="col ">
                                    <label name="Titulacion">¿Ya se tituló?</label>
                                    <input name="Titulacion" type="text" class="form-control @error('Titulacion') is-invalid @enderror" @if (empty($titulacion)) value="No" @else value="Sí" @endif placeholder="Ej. Sí" disabled>
                                </div>
                                @if (!empty($titulacion))
                                <div class="col">
                                    <label name="ModalidadEgreso">Opción de acreditación de Experiencia Recepcional:</label>
                                    <input name="ModalidadEgreso" type="text" class="form-control @error('ModalidadEgreso') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->modalidad->NombreModalidad}}" @endif placeholder="Ej. Tesís" disabled>
                                </div>
                            </div>
                            <div class="form-row py-2 px-2">
                                <div class="col ">
                                    <label name="Promedio">Promedio Ponderado:</label>
                                    <input name="Promedio" type="text" class="form-control @error('Promedio') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->PromedioEgreso}}" @endif placeholder="Ej. 10.0" disabled>
                                </div>
                                <div class="col ">
                                    <label name="Resultado">Resultado de la Modalidad:</label>
                                    <input name="Resultado" type="text" class="form-control @error('Resultado') is-invalid @enderror" @if (!empty($titulacion)) @if(is_null($titulacion->ResultadoTitulacion)) value="Aprobado" @else value="{{$titulacion->ResultadoTitulacion}}" @endif @endif placeholder="Ej. LIS 701" disabled>
                                </div>
                            </div>
                            <div class="form-row py-2 px-2">
                                <div class="col ">
                                    <label name="FechaInicio">Fecha de Inicio del trámite del título:</label>
                                    <input name="FechaInicio" type="text" class="form-control @error('FechaInicio') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->FechaInicioTramite}}" @endif placeholder="Ej. ENE-2020" disabled>
                                </div>
                                <div class="col ">
                                    <label name="FechaFin">Fecha de Finalización del trámite del título:</label>
                                    <input name="FechaFin" type="text" class="form-control @error('FechaFin') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->FechaFinTramite}}" @endif placeholder="Ej. LIS 701" disabled>
                                </div>
                            </div>
                            <div class="col ">
                                <label name="Periodo">Periodo de Egreso:</label>
                                <input name="Periodo" type="text" class="form-control @error('Periodo') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->periodo->NombrePeriodo}}" @endif placeholder="Ej. LIS 701" disabled>
                            </div>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

@include('estudiantes.modals.traslado')
@include('estudiantes.modals.reprobado')
@include('estudiantes.modals.baja')
@include('estudiantes.modals.practica')
@include('estudiantes.modals.servicio')
@include('estudiantes.modals.titulo')

@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')

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