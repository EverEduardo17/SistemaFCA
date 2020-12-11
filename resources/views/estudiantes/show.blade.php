@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.show', $idGrupo) }}">{{$nombreGrupo}} - {{$nombreCohorte}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Estudiantes</li>
  </ol>
</nav>
<div class="card">
  <div class="card-header">
    <div class="row align-center">
      <h5 class="card-title col-8">Estudiantes de <strong>{{$nombreGrupo}}</strong> Cohorte <strong>{{$nombreCohorte}}</strong></h5>
      <a class="btn btn-outline-info col-4" href="{{ route('grupos.show', $idGrupo) }}" role="button">Ver Grupo</a>
    </div>
  </div>

  <div class="card-body">
    @csrf @method('PATCH')
    @include('layouts.validaciones')
    <div class="contenedor-botones justify-content-center align-items-center">
      <a class="btn btn-outline-dark" href="{{ route('cohortes.show', $nombreCohorte) }}">Ver Cohorte</a>
      <a href="#" data-toggle="modal" data-target="#create" class="btn btn-outline-dark">Agregar Estudiante</a>
      <a class="btn btn-outline-dark" href="#">Cargar Plantilla</a>
    </div>
    <hr>
    <div class="table-responsive-xl">
      <table class="table table-striped table-hover" id="table_estudiante">
        <caption>Estudiantes registrados en el sistema para {{$nombreGrupo}} del cohorte {{$nombreCohorte}}.</caption>
        <thead class="bg-table">
          <tr class="text-white">
            <th scope="col">Matricula</th>
            <th scope="col">Nombre Completo</th>
            <th scope="col">Género</th>
            <th scope="col">Modalidad de entrada</th>
            <th scope="col">Estudiante activo</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($estudiantes as $estudiante)
          <tr>
            <th scope="row">{{ $estudiante->estudiante->MatriculaEstudiante }}</th>
            <td>{{ $estudiante->datosPersonales->NombreDatosPersonales }} {{$estudiante->datosPersonales->ApellidoPaternoDatosPersonales}} {{$estudiante->datosPersonales->ApellidoMaternoDatosPersonales}}</td>
            <td>{{ $estudiante->datosPersonales->Genero }}</td>
            <td>{{ $estudiante->modalidad->NombreModalidad }}</td>
            <td> @if($estudiante->EstudianteActivo == 1)Si @elseif($estudiante->EstudianteActivo<>1) No @endif </td>
            <td class="btn-group btn-group-sm px-3">
              <a class="btn btn-outline-primary btn-sm" href="{{ route('mostrarEstudiante', [$idGrupo, $estudiante]) }}">Detalles</a>
              <a class="btn btn-primary btn-sm" href="#">Editar</a>
              <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" @if($estudiante->EstudianteActivo == 1)data-target="#delete" @else data-tager="#" @endif data-trayectoria="{{$estudiante->IdTrayectoria}}">Baja</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@isset($estudiante)
@include('Estudiantes.modals.delete')
@endisset
@include('Estudiantes.modals.createGrupo')
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
  $(document).ready(function() {
    $('#table_estudiante').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
      }
    });
  });
</script>

<script>
  /*Dar de baja*/
  $('#delete').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
  })
</script>

<script>
  $('#create').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
  })
</script>
@endsection