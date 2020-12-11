@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.show', $trayectoria[0]->grupo->IdGrupo) }}">{{$trayectoria[0]->grupo->NombreGrupo}} - {{$trayectoria[0]->cohorte->NombreCohorte}}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('estudiantesGrupo', $trayectoria[0]->grupo->IdGrupo) }}">Estudiantes</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$trayectoria[0]->estudiante->MatriculaEstudiante}}</li>
  </ol>
</nav>
<div class="card">
  <div class="card-header">
    <div class="row align-center">
      <h5 class="card-title col-8">Estudiante: <strong>{{$trayectoria[0]->estudiante->MatriculaEstudiante}}</strong></h5>
      <a class="btn btn-outline-info col-4" href="{{ route('estudiantesGrupo', $trayectoria[0]->grupo->IdGrupo) }}" role="button">Ver Estudiantes</a>
    </div>
  </div>

  <div class="card-body">
    @csrf @method('PATCH')
    @include('layouts.validaciones')
    <div class="contenedor-botones justify-content-center align-items-center">
      <a class="btn btn-outline-dark" href="{{ route('cohortes.show', $trayectoria[0]->cohorte->NombreCohorte) }}">Agregar Prácticas</a>
      <a href="#" data-toggle="modal" data-target="#" class="btn btn-outline-dark">Agregar Servicio</a>
      <a class="btn btn-outline-dark" href="#">Agregar Movilidad</a>
      <a class="btn btn-outline-dark" href="#">Agregar Titulación</a>
    </div>

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
            <div class="form-group">
              <label name="Nombre">Nombre:</label>
              <input name="Nombre" type="text" class="form-control @error('Nombre') is-invalid @enderror" value="{{$trayectoria[0]->datosPersonales->NombreDatosPersonales}} {{$trayectoria[0]->datosPersonales->ApellidoPaternoDatosPersonales}} {{$trayectoria[0]->datosPersonales->ApellidoMaternoDatosPersonales}}" placeholder="Ej. Javier Pino Herrera" disabled>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Genero">Género:</label>
                  <input name="Genero" type="text" class="form-control @error('Genero') is-invalid @enderror" value="{{$trayectoria[0]->datosPersonales->Genero}}" placeholder="Ej. Hombre" disabled>
                </div>
                <div class="col">
                  <label name="Entrada">Modalidad de Ingreso:</label>
                  <input name="Entrada" type="text" class="form-control @error('Entrada') is-invalid @enderror" value="{{$trayectoria[0]->modalidad->NombreModalidad}}" placeholder="Ej. Hombre" disabled>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Matricula">Matricula:</label>
                  <input name="Matricula" type="text" class="form-control @error('Matricula') is-invalid @enderror" value="{{$trayectoria[0]->estudiante->MatriculaEstudiante}}" placeholder="Ej. S17016281" disabled>
                </div>
                <div class="col">
                  <label name="Cohorte">Cohorte de pertenencia:</label>
                  <input name="Cohorte" type="text" class="form-control @error('Cohorte') is-invalid @enderror" value="{{$trayectoria[0]->cohorte->NombreCohorte}}" placeholder="Ej. S170" disabled></input>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Programa">Programa Educativo de pertenencia:</label>
                  <input name="Programa" type="text" class="form-control @error('Programa') is-invalid @enderror" value="{{$trayectoria[0]->programaEducativo->NombreProgramaEducativo}}" placeholder="Ej. LIS" disabled></input>
                </div>
                <div class="col">
                  <label name="Grupo">Grupo de pertenencia:</label>
                  <input name="Grupo" type="text" class="form-control @error('Grupo') is-invalid @enderror" value="{{$trayectoria[0]->grupo->NombreGrupo}}" placeholder="Ej. LIS 701" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h5>Académico</h5>
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="TotalPeriodos">Periodos Cursados:</label>
                  <input name="TotalPeriodos" type="text" class="form-control @error('TotalPeriodos') is-invalid @enderror" value="{{$trayectoria[0]->TotalPeriodos}}" placeholder="Ej. 1" disabled></input>
                </div>
                <div class="col">
                  <label name="Activo">Estudiante Activo:</label>
                  <input name="Activo" type="text" class="form-control @error('Activo') is-invalid @enderror" @if ($trayectoria[0]->EstudianteActivo == 0) value="No" @else value="Si" @endif placeholder="Ej. Si" disabled>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Regular">Estudiante Regular:</label>
                  <input name="Regular" type="text" class="form-control @error('Regular') is-invalid @enderror" @if ($trayectoria[0]->EstudianteRegular == 0) value="No" @else value="Si" @endif placeholder="Ej. Si" disabled>
                </div>
                <div class="col">
                  <label name="Activo">¿Reprobó alguna vez?</label>
                  <input name="Activo" type="text" class="form-control @error('Activo') is-invalid @enderror" @if (empty($reprobados[0])) value="No" @else value="Si" @endif placeholder="Ej. Si" disabled>
                </div>
              </div>
              @if (!empty($reprobados[0]))
              <div class="col py-2">
                <label name="PeriodoReprobado">Último periodo reprobado:</label>
                <input name="PeriodoReprobado" type="text" class="form-control @error('PeriodoReprobado') is-invalid @enderror" @if (!empty($reprobados[0])) value="{{$reprobados->last()->periodo->NombrePeriodo}}" @endif placeholder="Ej. AGO - DIC 2020" disabled>
              </div>
              @endif
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Movilidad">¿Realizó movilidad?</label>
                  <input name="Movilidad" type="text" class="form-control @error('Movilidad') is-invalid @enderror" @if (empty($movilidad[0])) value="No" @else value="Si" @endif placeholder="Ej. Si" disabled>
                </div>
                @if (!empty($movilidad[0]))
                <div class="col">
                  <label name="FacultadDestino">Última facultad de destino:</label>
                  <input name="FacultadDestino" type="text" class="form-control @error('FacultadDestino') is-invalid @enderror" @if (!empty($movilidad[0])) value="{{$movilidad->last()->FacultadDestino}}" @endif placeholder="Ej. LIS 701" disabled>
                </div>
              </div>
              <div class="form-row my-3 px-3">
                <div class="col">
                  <label name="CampusDestino">Último campus de destino:</label>
                  <input name="CampusDestino" type="text" class="form-control @error('CampusDestino') is-invalid @enderror" @if (!empty($movilidad[0])) value="{{$movilidad->last()->CampusDestino}}" @endif placeholder="Ej. Coatzacoalcos" disabled>
                </div>
                <div class="col">
                  <label name="Periodo">Último periodo de Movilidad:</label>
                  <input name="Periodo" type="text" class="form-control @error('Periodo') is-invalid @enderror" @if (!empty($movilidad[0])) value="{{$movilidad->last()->periodo->NombrePeriodo}}" @endif placeholder="Ej.  AGO - DIC 2020" disabled>
                </div>
              </div>
              @endif
            </div>
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

            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Servicio">¿Ya realizó el Servicio Social?</label>
                  <input name="Servicio" type="text" class="form-control @error('Servicio') is-invalid @enderror" @if (empty($servicio[0])) value="No" @else value="Si" @endif placeholder="Ej. Si" disabled>
                </div>
                @if (!empty($servicio[0]))
                <div class="col">
                  <label name="ServicioActivo">¿Está activo?</label>
                  <input name="ServicioActivo" type="text" class="form-control @error('ServicioActivo') is-invalid @enderror" @if ($servicio[0]->activo == 0) value="No" @else value="Si" @endif placeholder="Ej. Si" disabled>
                </div>
              </div>
              <div class="col py-2 px-2">
                <label name="EmpresaServicio">Empresa dónde realizó el Servicio Social:</label>
                <input name="EmpresaServicio" type="text" class="form-control @error('EmpresaServicio') is-invalid @enderror" @if (!empty($servicio[0])) value="{{$servicio[0]->empresa->NombreEmpresa}}" @endif placeholder="Ej. LIS 701" disabled>
              </div>
              @endif
            </div>
            <div class="form-group">
              <div class="form-row py-2">
                <div class="col">
                  <label name="Practicas">¿Ya realizó las Prácticas Profesionales?</label>
                  <input name="Practicas" type="text" class="form-control @error('Practicas') is-invalid @enderror" @if (empty($practicas[0])) value="No" @else value="Si" @endif placeholder="Ej. Si" disabled>
                </div>
                @if (!empty($practicas[0]))
                <div class="col">
                  <label name="PracticasActivo">¿Está activo?</label>
                  <input name="PracticasActivo" type="text" class="form-control @error('PracticasActivo') is-invalid @enderror" @if ($practicas[0]->activo == 0) value="No" @else value="Si" @endif placeholder="Ej. Si" disabled>
                </div>
              </div>
              <div class="col py-2 px-2">
                <label name="EmpresaPracticas">Empresa dónde realizó las Prácticas Profesionales:</label>
                <input name="EmpresaPracticas" type="text" class="form-control @error('EmpresaPracticas') is-invalid @enderror" @if (!empty($reprobados[0])) value="{{$practicas[0]->empresa->NombreEmpresa}}" @endif placeholder="Ej. LIS 701" disabled>
              </div>
              @endif
            </div>

            <div class="form-group">
              <div class="form-row py-2">
                <div class="col ">
                  <label name="Titulacion">¿Ya se tituló?</label>
                  <input name="Titulacion" type="text" class="form-control @error('Titulacion') is-invalid @enderror" @if (empty($titulacion[0])) value="No" @else value="Si" @endif placeholder="Ej. Si" disabled>
                </div>
                @if (!empty($titulacion[0]))
                <div class="col">
                  <label name="ModalidadEgreso">Modalidad de Egreso:</label>
                  <input name="ModalidadEgreso" type="text" class="form-control @error('ModalidadEgreso') is-invalid @enderror" @if (!empty($titulacion[0])) value="{{$titulacion[0]->modalidad->NombreModalidad}}" @endif placeholder="Ej. Tesis" disabled>
                </div>
              </div>
              <div class="form-row py-2 px-2">
                <div class="col ">
                  <label name="Promedio">Promedio Ponderado:</label>
                  <input name="Promedio" type="text" class="form-control @error('Promedio') is-invalid @enderror" @if (!empty($titulacion[0])) value="{{$titulacion[0]->PromedioEgreso}}" @endif placeholder="Ej. 10.0" disabled>
                </div>
                <div class="col ">
                  <label name="Resultado">Resultado de la Modalidad:</label>
                  <input name="Resultado" type="text" class="form-control @error('Resultado') is-invalid @enderror" @if (!empty($titulacion[0])) @if(is_null($titulacion[0]->ResultadoTitulacion)) value="Aprobado" @else value="{{$titulacion[0]->ResultadoTitulacion}}" @endif @endif placeholder="Ej. LIS 701" disabled>
                </div>
              </div>
              <div class="form-row py-2 px-2">
                <div class="col ">
                  <label name="FechaInicio">Fecha de Inicio del trámite:</label>
                  <input name="FechaInicio" type="text" class="form-control @error('FechaInicio') is-invalid @enderror" @if (!empty($titulacion[0])) value="{{$titulacion[0]->FechaInicioTramite}}" @endif placeholder="Ej. ENE-2020" disabled>
                </div>
                <div class="col ">
                  <label name="FechaFin">Fecha de Finalización del trámite:</label>
                  <input name="FechaFin" type="text" class="form-control @error('FechaFin') is-invalid @enderror" @if (!empty($titulacion[0])) value="{{$titulacion[0]->FechaFinTramite}}" @endif placeholder="Ej. LIS 701" disabled>
                </div>
              </div>
              <div class="col ">
                <label name="Periodo">Periodo de Egreso:</label>
                <input name="Periodo" type="text" class="form-control @error('Periodo') is-invalid @enderror" @if (!empty($titulacion[0])) value="{{$titulacion[0]->periodo->NombrePeriodo}}" @endif placeholder="Ej. LIS 701" disabled>
              </div>
              @endif
            </div>

          </div>
        </div>
      </div>


    </div>
  </div>
</div>

<a href="{{ route('estudiantesGrupo', $trayectoria[0]->IdGrupo) }}" class="btn btn-primary btn-block mt-4">Editar Estudiante</a>
<a href="{{ route('estudiantesGrupo', $trayectoria[0]->IdGrupo) }}" class="btn btn-secondary btn-block">Regresar</a>
<hr>
<a href="{{ route('grupos.index') }}" class="btn btn-danger btn-block">Dar de baja</a>


</div>


@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script>
  /*Eliminar Grupo*/
  $('#delete').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('documento');
    var modal = $(this);
    var action = $("#form-eliminar-grupo").attr('action') + '/' + id;
    modal.find('.modal-body form').attr('action', action);
  })
</script>
<script>
  $('#create').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
  })
</script>
@endsection