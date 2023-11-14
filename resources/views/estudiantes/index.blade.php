@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gestión de Estudiantes</li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title"><strong>Gestión de Estudiantes</strong></h5>
            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ route('home') }}" role="button">Regresar</a>

            @can('havepermiso', 'estudiantes-crear')
                <a class="btn btn-success col-4" href="{{ route('estudiantes.create') }}" role="button">Agregar Estudiante</a>
            @endcan
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover border-bottom border-right" id="table-jquery">
                <caption>Estudiantes registrados en el sistema.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border">Matrícula</th>
                        <th scope="col" class="border">Nombre</th>
                        <th scope="col" class="border">Rol</th>

                        @can('havepermiso', 'estudiantes-detalles')
                            <th scope="col" class="border actions-col">Acciones</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estudiantes as $estudiante)
                    <tr>
                        <th scope="row" class="border-right border-left">
                            <a href="{{ route('estudiantes.show', $estudiante) }}">{{ $estudiante->MatriculaEstudiante }}</a>
                        </th>

                        <td class="border-right">
                            {{ $estudiante->usuario->datosPersonales->ApellidoPaternoDatosPersonales }}
                            {{ $estudiante->usuario->datosPersonales->ApellidoMaternoDatosPersonales }}
                            {{ $estudiante->usuario->datosPersonales->NombreDatosPersonales }}
                        </td>

                        <td>{{ $estudiante->usuario->roles[0]->ClaveRole ?? "" }}</td>
                        
                        @can('havepermiso', 'estudiantes-detalles')
                            <td class="btn-group btn-group-sm border-left">
                                <a class="btn btn-outline-success btn-sm" href="{{ route('estudiantes.show', $estudiante) }}" title="Detalles">
                                    <em class="fas fa-list"></em>
                                </a>

                                @can('havepermiso','estudiantes-editar')
                                    <a class="btn btn-outline-primary btn-sm mr-1 ml-1" href="{{ route('estudiantes.edit', $estudiante) }}" title="Editar">
                                        <em class="fas fa-pen"></em>
                                    </a>
                                @endcan

                                @can('havepermiso','estudiantes-eliminar')
                                    <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#delete" data-id="{{ $estudiante->IdEstudiante }}" data-toggle="tooltip" data-placement="bottom" title="Eliminar">
                                        <em class="fas fa-trash-alt"></em>
                                    </a>
                                @endcan
                            </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('estudiantes.modals.delete')

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
        var action = $("#form-eliminar").attr('action') + '/' + id;
        modal.find('.modal-body form').attr('action', action);
    })
</script>
@endsection