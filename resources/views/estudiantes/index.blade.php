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
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title"><strong>Gestión de Estudiantes</strong></h5>
            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ route('home') }}" role="button">Regresar</a>
            <a class="btn btn-success col-4" href="{{ route('estudiantes.create') }}" role="button">Agregar Estudiante</a>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover border-bottom" id="table_grupos">
                <caption>Estudiantes registrados en el sistema.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border">Matrícula</th>
                        <th scope="col" class="border">Nombre</th>
                        <th scope="col" class="border">Grupo</th>
                        <th scope="col" class="border">Género</th>
                        <th scope="col" class="border actions-col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estudiantes as $estudiante)
                    <tr>
                        <th scope="row" class="border-right border-left">{{ $estudiante->MatriculaEstudiante }}</th>

                        <td class="border-right">
                            {{ $estudiante->trayectoria->datosPersonales->ApellidoPaternoDatosPersonales }}
                            {{ $estudiante->trayectoria->datosPersonales->ApellidoMaternoDatosPersonales }}
                            {{ $estudiante->trayectoria->datosPersonales->NombreDatosPersonales }}

                        </td>

                        <td class="border-right">{{ $estudiante->trayectoria->grupo->NombreGrupo }}</td>

                        <td class="border-right">{{ $estudiante->trayectoria->datosPersonales->Genero }}</td>

                        <td class="btn-group btn-group-sm border-right">
                            <a class="btn btn-outline-primary btn-sm mx-2" href="{{ route('estudiantes.show', $estudiante) }}">
                                Detalles
                            </a>
                            <a class="btn btn-primary btn-sm" href="{{ route('estudiantes.edit', $estudiante) }}">
                                Editar
                            </a>
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
        $('#table_grupos').DataTable({
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