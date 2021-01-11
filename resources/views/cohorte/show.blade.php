@extends('layouts.app')

@section('content')
@csrf @method('PATCH')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gestión de Cohortes</li>
    </ol>
</nav>
@include('layouts.validaciones')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h4 class="card-title col-8">Gestión de Cohortes</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="contenedor-botones justify-content-center align-items-center">
            <a class="btn btn-outline-dark" href="#">Ver Cohorte</a>
            <a href="#" class="btn btn-outline-dark">Agregar Estudiante</a>
            <a class="btn btn-outline-dark" href="#">Editar Estudiante</a>
            <a class="btn btn-outline-dark" href="#">Dar de Baja Estudiante</a>
        </div>
        <h5 class="py-2">Cohortes</h5>
        <div class="testimonial-group mx-3 my-2">
            <div class="row text-center text-white">
                @foreach($cohortes as $cohorte)
                <a class="col-s-4 btn @if($cohorte->IdCohorte == $idCohorte)btn-primary @elseif($cohorte->IdCohorte <> $idCohorte)btn-outline-primary @endif" href="{{ route('cohortes.show', $cohorte->NombreCohorte) }}">{{$cohorte->NombreCohorte}}</a>
                @endforeach
            </div>
        </div>
        <hr>
        <h5 class="py-2">Grupos</h5>
        <ul class="nav nav-tabs" id="nav-tab" role="tablist">
            @foreach ($programas as $programa)
            <li class="nav-item" role="presentation">
                <a class="btn-outline-primary nav-link @if($programa->AcronimoProgramaEducativo == $programas[0]->AcronimoProgramaEducativo)active" @endif id="nav-{{$programa->AcronimoProgramaEducativo}}-tab" data-toggle="tab" href="#nav-{{$programa->AcronimoProgramaEducativo}}" role="tab" aria-controls="nav-{{$programa->AcronimoProgramaEducativo}}" aria-selected="@if($programa->AcronimoProgramaEducativo == $programas[0]->AcronimoProgramaEducativo)true" @endif @if($programa->AcronimoProgramaEducativo != $programas[0]->AcronimoProgramaEducativo)"false" "@endif >{{ $programa->AcronimoProgramaEducativo }}</a>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="nav-tabContent">
            @foreach ($programas as $programa)
            <div class="py-3 tab-pane fade @if($programa->AcronimoProgramaEducativo == $programas[0]->AcronimoProgramaEducativo)show active @endif" id="nav-{{$programa->AcronimoProgramaEducativo}}" role="tabpanel" aria-labelledby="nav-{{$programa->AcronimoProgramaEducativo}}-tab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center mb-0 pb-0">
                            <h4 class="mr-auto pl-3">{{$programa->NombreProgramaEducativo}}
                                <p>Cohorte: <strong>{{$nombreCohorte}}</strong></p>
                            </h4>
                            <div class="btn-group" role="group">
                                <button class="btn btn-success" data-toggle="modal" data-target="#create">Agregar Grupo</button>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table class="table table-striped table-hover" id="table_{{$programa->AcronimoProgramaEducativo}}">
                            <caption>Grupos registrados en el sistema para {{$programa->AcronimoProgramaEducativo}} en el cohorte {{$nombreCohorte}}.</caption>
                            <thead class="bg-table">
                                <tr class="text-white">
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Total de estudiantes</th>
                                    <th scope="col">Estudiantes Activos</th>
                                    <th scope="col">Estudiantes Inactivos</th>
                                    <th scope="col">Último periodo activo</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupos as $grupo)
                                @if($grupo->IdProgramaEducativo == $programa->IdProgramaEducativo)
                                <tr>
                                    <th scope="row">{{ $grupo->NombreGrupo }}</th>
                                    <td>{{ $grupo->EstudiantesActivos + $grupo->EstudiantesInactivos + $grupo->EstudiantesStandBy}}</td>
                                    <td>@if($grupo->EstudiantesActivos == null)0 @elseif($grupo->EstudiantesActivos <> null){{ $grupo->EstudiantesActivos }}@endif</td>
                                    <td>@if($grupo->EstudiantesInactivos == null)0 @elseif($grupo->EstudiantesInactivos <> null){{ $grupo->EstudiantesInactivos }}@endif</td>
                                    <td>{{ $grupo->periodoActivo->NombrePeriodo }}</td>
                                    <td class="btn-group btn-group-sm px-3">
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('cohortes.mostrarGrupo', [$nombreCohorte, $grupo->IdGrupo]) }}">Visualizar</a>
                                        <a class="btn btn-info btn-sm" href="{{ route('grupos.show', $grupo) }}">Detalles</a>
                                        <form method="POST" id="form-eliminar" action="{{ route('grupos.destroy', $grupo) }}">
                                            @csrf @method('DELETE')
                                            <a href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm">Eliminar</a>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@include('grupos.modals.create')
@include('grupos.modals.delete')
@endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    //!! Checar, cuando se agreguen nuevos PE va a fallar.
    $(document).ready(function() {
        $('#table_LA').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }
        });
        $('#table_LC').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }
        });
        $('#table_LGDN').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }
        });
        $('#table_LIS').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }
        });
        $('#table_LSCA').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }
        });
    });
</script>
<script>
    $('#delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
    $('#create').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
  
</script>

@endsection