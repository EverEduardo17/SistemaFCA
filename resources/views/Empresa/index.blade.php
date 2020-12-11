@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gestión de Empresas</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Empresas Registradas</h5>
            <a class="btn btn-success col-4" href="{{ route('empresas.create') }}" role="button">Agregar Empresa</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover" id="table_Empresa">
                <caption>Empresas registradas en el sistema.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col">Nombre</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Tamaño</th>
                        <th scope="col">Actividad</th>
                        <th scope="col">Sector</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empresas as $empresa)
                    <tr>
                        <th scope="row">{{ $empresa->NombreEmpresa }}</th>
                        <td>{{ $empresa->ResponsableEmpresa }}</td>
                        <td>{{ $empresa->TelefonoEmpresa }}</td>
                        <td>{{ $empresa->ClasificacionEmpresa }}</td>
                        <td>{{ $empresa->ActividadEmpresa }}</td>
                        <td>{{ $empresa->TipoEmpresa }}</td>
                        <td class="btn-group btn-group-sm px-3">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('empresas.show', $empresa) }}">Detalles</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('empresas.edit', $empresa) }}">Editar</a>
                            <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#delete" data-documento="{{ $empresa->IdEmpresa }}">Eliminar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('Empresa.modals.delete')
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    $(document).ready(function() {
        $('#table_Empresa').DataTable({
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
        var id = button.data('documento');
        var modal = $(this);
        var action = $("#form-eliminar-empresa").attr('action') + '/' + id;
        modal.find('.modal-body form').attr('action', action);
    })
</script>
@endsection