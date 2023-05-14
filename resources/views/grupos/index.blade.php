@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gestión de Grupos</li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title"><strong>Gestión de Grupos</strong></h5>
            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ route('home') }}" role="button">Regresar</a>
            <a class="btn btn-success col-4" href="{{ route('grupos.create') }}" role="button">Agregar Grupo</a>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover border-bottom border-right" id="table-jquery">
                <caption>Grupos registrados en el sistema.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border">Nombre</th>
                        <th scope="col" class="border">Programa Educativo</th>
                        <th scope="col" class="border">Cohorte de pertenencia</th>
                        <th scope="col" class="border">Total de estudiantes</th>
                        <th scope="col" class="border">Último periodo activo</th>
                        <th scope="col" class="border actions-col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grupos as $grupo)
                    <tr>
                        <th scope="row" class="border-right border-left">
                            <a href="{{ route('grupos.show', $grupo) }}">{{ $grupo->NombreGrupo }}</a>
                        </th>
                        <td class="border-right">{{ $grupo->programaEducativo->AcronimoProgramaEducativo }}</td>
                        <td class="border-right">{{ $grupo->cohorte->NombreCohorte }}</td>
                        @inject('estudiantes', 'App\Http\Controllers\GrupoController')
                            <td class="border-right">{{$estudiantes->contarEstudiantes($grupo->IdGrupo)}}</td>
                        <td class="border-right">{{ $grupo->periodoActivo->NombrePeriodo }}</td>
                        <td class="btn-group btn-group-sm">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('grupos.show', $grupo) }}" data-toggle="tooltip" data-placement="bottom" title="Detalles" ><em class="fas fa-eye"></em></a>
                            <a class="btn btn-sm btn-outline-info mx-2" href="{{ route('grupos.edit',$grupo) }}" data-toggle="tooltip" data-placement="bottom" title="Editar"><em class="fas fa-pen"></em></a>
                            <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#delete" data-id="{{ $grupo->IdGrupo }}" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><em class="fas fa-trash-alt"></em></a>
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
<script src="{{ asset('js/table-script.js') }}"></script>

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