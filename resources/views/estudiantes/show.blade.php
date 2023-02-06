@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.show', $grupo->IdGrupo) }}">{{$grupo->NombreGrupo}} -
        {{$cohorte->NombreCohorte}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Estudiantes</li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <div class="row align-center">
      <h5 class="card-title col-8"><strong> Estudiantes del grupo "{{$grupo->NombreGrupo}}" del cohorte
          "{{$cohorte->NombreCohorte}}"</strong></h5>
      <a class="btn btn-outline-info col-4" href="{{ route('grupos.show', $grupo->IdGrupo) }}" role="button">Ver
        Grupo</a>
    </div>
  </div>

  <div class="card-body">
    @csrf @method('PATCH')
    @include('layouts.validaciones')
    <div class="contenedor-botones justify-content-center align-items-center">
      <a class="btn btn-outline-dark mr-2" href="{{ route('cohortes.show', $cohorte->NombreCohorte) }}"><em
          class="fas fa-eye"></em> Ver Cohorte</a>
      <a class="btn btn-outline-dark mr-2" href="{{ route('agregarEstudiante', $grupo->IdGrupo) }}"><em
          class="fas fa-plus-circle"></em> Agregar Estudiante</a>
      <a class="btn btn-outline-dark mr-2" href="#"><em class="fas fa-arrow-circle-up"></em> Cargar Plantilla</a>
    </div>
    <hr>
    <div class="table-responsive-xl">
      <table class="table table-striped table-hover" id="table_estudiante">
        <caption>Estudiantes registrados en el sistema para el grupo {{$grupo->NombreGrupo}} del cohorte
          {{$cohorte->NombreCohorte}}.</caption>
        <thead class="bg-table">
          <tr class="text-white">
            <th scope="col" class="border-right">Matrícula</th>
            <th scope="col" class="border-right">Nombre</th>
            <th scope="col" class="border-right">Género</th>
            <th scope="col" class="border-right">Modalidad de entrada</th>
            <th scope="col" class="border-right">Estado</th>
            <th scope="col" class="border-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($estudiantes as $estudiante)
            <tr>
              <th scope="row" class="border-right">{{$estudiante->estudiante->MatriculaEstudiante}}</th>
              <td class="border-right">{{$estudiante->datosPersonales->ApellidoPaternoDatosPersonales}}
                {{$estudiante->datosPersonales->ApellidoMaternoDatosPersonales}}
                {{ $estudiante->datosPersonales->NombreDatosPersonales }} </td>
              <td class="border-right">{{$estudiante->datosPersonales->Genero}}</td>
              <td class="border-right">{{$estudiante->modalidad->NombreModalidad}}</td>
              @foreach($estados as $estado)
                @if($estudiante->IdTrayectoria == $estado->IdTrayectoria )
                  <td class="border-right">
                    @if($estado->Estado == "Activo")
                      Activo
                      </td>
                    @else
                      {{$estado->Estado}}
                      </td>
                    @endif
                @endif
                @endforeach
                <td class="btn-group btn-group-sm">
                    <a class="btn btn-outline-primary btn-sm mx-2"
                      href="{{ route('mostrarEstudiante', [$grupo->IdGrupo, $estudiante->estudiante->MatriculaEstudiante]) }}">Detalles</a>
                    <a class="btn btn-primary btn-sm"
                      href="{{ route('editarEstudiante', [$grupo->IdGrupo, $estudiante->IdTrayectoria]) }}">Editar</a>
                </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
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
@endsection