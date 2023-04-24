@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.show', $trayectoria->grupo->IdGrupo) }}">{{$trayectoria->grupo->NombreGrupo}} - {{$trayectoria->cohorte->NombreCohorte}}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.estudiantes', $trayectoria->grupo->IdGrupo) }}">Estudiantes</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$trayectoria->estudiante->MatriculaEstudiante}}</li>
  </ol>
</nav>
@endsection
@section('content')

<div class="card">

  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center">

      <h5 class="card-title">
        <strong>Detalles del estudiante: "{{$trayectoria->estudiante->MatriculaEstudiante}}"</strong>
      </h5>

      <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">
        Regresar
      </a>
      <a class="btn btn-secondary col-4" href="{{ route('grupos.estudiantes', $trayectoria->grupo->IdGrupo) }}" role="button">
        Ver Estudiantes
      </a>
    </div>
  </div>

  <div class="card-body">
    @csrf @method('PATCH')
    @include('layouts.validaciones')

    @if ($estado=="Activo" )
    <div class="contenedor-botones justify-content-center align-items-center my-3">
      <a class="btn btn-outline-dark mr-2" href="{{ route('grupos.editarEstudiante', [$trayectoria->grupo->IdGrupo, $trayectoria->IdTrayectoria]) }}"><em class="fas fa-pen"></em> Editar Estudiante</a>
      <a href="#" data-toggle="modal" data-target="#baja" class="btn btn-outline-dark"><em class="fas fa-minus-circle"></em> Dar de Baja</a>
    </div>
    @endif

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
              <input name="Nombre" type="text" class="form-control @error('Nombre') is-invalid @enderror" value="{{$trayectoria->datosPersonales->ApellidoPaternoDatosPersonales}} {{$trayectoria->datosPersonales->ApellidoMaternoDatosPersonales}} {{$trayectoria->datosPersonales->NombreDatosPersonales}}" placeholder="Ej. Javier Pino Herrera" disabled>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Genero">Género:</label>
                  <input name="Genero" type="text" class="form-control @error('Genero') is-invalid @enderror" value="{{$trayectoria->datosPersonales->Genero}}" placeholder="Ej. Hombre" disabled>
                </div>
                <div class="col">
                  <label name="Entrada">Modalidad de Ingreso:</label>
                  <input name="Entrada" type="text" class="form-control @error('Entrada') is-invalid @enderror" value="{{$trayectoria->modalidad->NombreModalidad}}" placeholder="Ej. Primera Lista" disabled>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Matricula">Matrícula:</label>
                  <input name="Matricula" type="text" class="form-control @error('Matricula') is-invalid @enderror" value="{{$trayectoria->estudiante->MatriculaEstudiante}}" placeholder="Ej. S17016281" disabled>
                </div>
                <div class="col">
                  <label name="Cohorte">Cohorte de pertenencia:</label>
                  <input name="Cohorte" type="text" class="form-control @error('Cohorte') is-invalid @enderror" value="{{$trayectoria->cohorte->NombreCohorte}}" placeholder="Ej. S170" disabled>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Programa">Programa Educativo de pertenencia:</label>
                  <input name="Programa" type="text" class="form-control @error('Programa') is-invalid @enderror" value="{{$trayectoria->programaEducativo->NombreProgramaEducativo}}" placeholder="Ej. LIS" disabled>
                </div>
                <div class="col">
                  <label name="Grupo">Grupo de pertenencia:</label>
                  <input name="Grupo" type="text" class="form-control @error('Grupo') is-invalid @enderror" value="{{$trayectoria->grupo->NombreGrupo}}" placeholder="Ej. LIS 701" disabled>
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
              <h5>Formación Académica</h5>
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="TotalPeriodos">Periodos cursados:</label>
                  <input name="TotalPeriodos" type="text" class="form-control @error('TotalPeriodos') is-invalid @enderror" value="{{$trayectoria->TotalPeriodos}}" placeholder="Ej. 1" disabled></input>
                </div>
                <div class="col">
                  <label name="Activo">Estado del estudiante:</label>
                  <input name="Activo" type="text" class="form-control @error('Activo') is-invalid @enderror" @if ($estado=="Activo" ) value="Activo" @else value="Inactivo" @endif placeholder="Ej. Activo" disabled>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Regular">¿Es estudiante regular?</label>
                  <input name="Regular" type="text" class="form-control @error('Regular') is-invalid @enderror" @if ($trayectoria->EstudianteRegular == 1) value="Sí" @else value="No" @endif
                  placeholder="Ej. Sí" disabled>
                </div>
                <div class="col">
                  <label name="Activo">¿Reprobó alguna vez?</label>
                  <input name="Activo" type="text" class="form-control @error('Activo') is-invalid @enderror" @if (empty($reprobado)) value="No" @else value="Sí" @endif placeholder="Ej. Sí" disabled>
                </div>
              </div>
              @if (!empty($reprobado))
              <div class="col py-2">
                <label name="PeriodoReprobado">Último periodo reprobado:</label>
                <input name="PeriodoReprobado" type="text" class="form-control @error('PeriodoReprobado') is-invalid @enderror" @if (!empty($reprobado)) value="{{$reprobado->periodo->NombrePeriodo}}" @endif placeholder="Ej. AGO - DIC 2020" disabled>
              </div>
              @endif
            </div>
            <h5>Movilidad</h5>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Movilidad">¿Realizó movilidad?</label>
                  <input name="Movilidad" type="text" class="form-control @error('Movilidad') is-invalid @enderror" @if (empty($movilidad)) value="No" @else value="Sí" @endif placeholder="Ej. Sí" disabled>
                </div>
                @if (!empty($movilidad))
                <div class="col">
                  <label name="FacultadDestino">Facultad de destino en movilidad:</label>
                  <input name="FacultadDestino" type="text" class="form-control @error('FacultadDestino') is-invalid @enderror" @if (!empty($movilidad)) value="{{$movilidad->FacultadDestino}}" @endif placeholder="Ej. FCA" disabled>
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
          <h5>Servicio Social</h5>
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
                <input name="EmpresaServicio" type="text" class="form-control @error('EmpresaServicio') is-invalid @enderror" value="{{$servicio->empresa->NombreEmpresa}}" placeholder="Ej. Coordinación de Desarrollo de Software" disabled>
              </div>
              @endif
            </div>
            <h5 class="mt-3">Prácticas Profesionales</h5>
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <label name="Practicas">¿Ya realizó las Prácticas Profesionales?</label>
                  <input name="Practicas" type="text" class="form-control @error('Practicas') is-invalid @enderror" @if (empty($practicas)) value="No" @else value="Sí" @endif placeholder="Ej. Sí" disabled>
                </div>
                @if (!empty($practicas))
              </div>
              <div class="col py-2 px-2">
                <label name="EmpresaPracticas">Empresa dónde realizó las Prácticas Profesionales:</label>
                <input name="EmpresaPracticas" type="text" class="form-control @error('EmpresaPracticas') is-invalid @enderror" value="{{$practicas->empresa->NombreEmpresa}}" placeholder="Ej. Coordinación de Desarrollo de Software" disabled>
              </div>
              @endif
            </div>
            <h5 class="mt-2">Titulación</h5>
            <div class="form-group">
              <div class="form-row ">
                <div class="col ">
                  <label name="Titulacion">¿Ya se tituló?</label>
                  <input name="Titulacion" type="text" class="form-control @error('Titulacion') is-invalid @enderror" @if (empty($titulacion)) value="No" @else value="Sí" @endif placeholder="Ej. Sí" disabled>
                </div>
                @if (!empty($titulacion))
                <div class="col">
                  <label name="ModalidadEgreso">Opción de acreditación de Experiencia Recepcional:</label>
                  <input name="ModalidadEgreso" type="text" class="form-control @error('ModalidadEgreso') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->modalidad->NombreModalidad}}" @endif placeholder="Ej. Tesis" disabled>
                </div>
              </div>
              <div class="form-row py-2 px-2">
                <div class="col ">
                  <label name="Promedio">Promedio Ponderado:</label>
                  <input name="Promedio" type="text" class="form-control @error('Promedio') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->PromedioEgreso}}" @endif placeholder="Ej. 10.0" disabled>
                </div>
                @if($titulacion->modalidad->NombreModalidad == "Examen CENEVAL")
                <div class="col ">
                  <label name="Resultado">Resultado de la Modalidad:</label>
                  <input name="Resultado" type="text" class="form-control @error('Resultado') is-invalid @enderror" @if (!empty($titulacion)) @if(is_null($titulacion->ResultadoTitulacion)) value="Aprobado" @else value="{{$titulacion->ResultadoTitulacion}}" @endif @endif placeholder="Ej. LIS 701" disabled>
                </div>
                @endif
              </div>
              <div class="form-row py-2 px-2">
                <div class="col ">
                  <label name="FechaInicio">Fecha de inicio del trámite del título:</label>
                  <input name="FechaInicio" type="text" class="form-control @error('FechaInicio') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->FechaInicioTramite}}" @endif placeholder="Ej. ENE-2020" disabled>
                </div>
                <div class="col ">
                  <label name="FechaFin">Fecha de finalización del trámite del título:</label>
                  <input name="FechaFin" type="text" class="form-control @error('FechaFin') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->FechaFinTramite}}" @endif placeholder="Ej. LIS 701" disabled>
                </div>
              </div>
              <div class="col ">
                <label name="Periodo">Periodo de Egreso:</label>
                <input name="Periodo" type="text" class="form-control @error('Periodo') is-invalid @enderror" @if (!empty($titulacion)) value="{{$titulacion->periodo->NombrePeriodo}}" @endif placeholder="Ej. LIS 701" disabled>
              </div>
              @endif
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

@include('grupos.estudiantes.modals.baja')
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script>
  $('#baja').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
  })
</script>
@endsection