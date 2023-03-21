@extends('layouts.plantilla')

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gestión de Programas Educativos</li>
    </ol>
</nav>
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8"><strong> Gestión de Constancias</strong></h5>
            <a class="btn btn-success col-4" href="{{ route('constancias.create') }}" role="button">Agregar Constancia</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover" id="table_Programa">
                <caption>Programas Educativos registrados en el sistema.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right">Nombre</th>
                        <th scope="col" class="border-right">Descripción</th>
                        <th scope="col" class="border-right">Autor</th>
                        <th scope="col" class="border-right">Valido Hasta</th>
                        <th scope="col" class="border-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($constancias as $constancia)
                    <tr>
                        <th scope="row" class="border-right">{{ $constancia->NombreConstancia }}</th>

                        <td class="border-right">{{ $constancia->DescripcionConstancia }}</td>

                        <td class="border-right">
                            {{ $constancia->usuario->datosPersonales->ApellidoPaternoDatosPersonales }}
                            {{ $constancia->usuario->datosPersonales->ApellidoMaternoDatosPersonales }}
                            {{ $constancia->usuario->datosPersonales->NombreDatosPersonales }}
                        </td>

                        <td class="border-right">{{ printDate(($constancia->VigenteHasta)) }}</td>
                        <td class="py-2">
                            <a class="btn btn-sm btn-outline-success" href="{{ route('constancias.show', $constancia->IdConstancia) }}" data-toggle="tooltip" data-placement="bottom" title="Detalles"><em class="fas fa-eye"></em></a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('constancias.edit', $constancia->IdConstancia) }}" data-toggle="tooltip" data-placement="bottom" title="Editar"><em class="fas fa-pencil-alt"></em></a>
                            <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#delete" data-documento="{{ $constancia->IdProgramaEducativo }}" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><em class="fas fa-trash-alt"></em></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('constancias.modals.delete')
@endsection


@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    $(document).ready(function() {
        $('#table_Programa').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }

        });
    });
</script>
<script>
    /* Eliminar */
    $('#delete').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget);
        let id = button.data('documento');
        let modal = $(this);
        let action = $("#form-eliminar-constancia").attr('action') + '/' + id;
        modal.find('.modal-body form').attr('action', action);
    })
</script>
@endsection