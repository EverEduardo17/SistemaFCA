@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gestión de Grupos</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8"><strong>Gestión de Grupos</strong></h5>
            <a class="btn btn-success col-4" href="{{ route('grupos.create') }}" role="button">Agregar Grupo</a>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover" id="table_sede">
                <caption>Grupos registrados en el sistema.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right">Nombre</th>
                        <th scope="col" class="border-right">Programa Educativo</th>
                        <th scope="col" class="border-right">Cohorte de pertenencia</th>
                        <th scope="col" class="border-right">Estudiantes activos</th>
                        <th scope="col" class="border-right">Total de estudiantes</th>
                        <th scope="col" class="border-right">Último periodo activo</th>
                        <th scope="col" class="border-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grupos as $grupo)
                    <tr>
                        <th scope="row" class="border-right">{{ $grupo->NombreGrupo }}</th>
                        <td class="border-right">{{ $grupo->programaEducativo->AcronimoProgramaEducativo }}</td>
                        <td class="border-right">{{ $grupo->cohorte->NombreCohorte }}</td>
                        @inject('estudiantes', 'App\Http\Controllers\GrupoController')
                            <td class="border-right">{{$estudiantes->contarEstudiantes($grupo->IdGrupo)[0]}}</td>
                            <td class="border-right"><strong>{{$estudiantes->contarEstudiantes($grupo->IdGrupo)[0] + $estudiantes->contarEstudiantes($grupo->IdGrupo)[1]}}</strong></td>
                        <td class="border-right">{{ $grupo->periodoActivo->NombrePeriodo }}</td>
                        <td class="btn-group btn-group-sm px-3">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('grupos.show', $grupo) }}">Detalles</a>
                            <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#delete" data-id="{{ $grupo->IdGrupo }}">Eliminar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('grupos.modals.delete')

@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    $(document).ready(function() {
        $('#table_sede').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }

        });
    });
</script>
<script>
    /*Eliminar Grupo*/
    $('#delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        var action = $("#form-eliminar-grupo").attr('action') + '/' + id;
        modal.find('.modal-body form').attr('action', action);
    })
</script>
@endsection