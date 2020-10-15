@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <h5 class="card-title col-8">Tipo de Organizadores</h5>
                <a class="btn btn-primary col-4" href="{{ route('tipoorganizador.create') }}" role="button">Añadir Tipo de Organizador</a>
            </div>
        </div>
        <div class="card-body">
            <table id="table_tipoorganizador" class="table">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tipoorganizadores as $item)
                    <tr>
                        <th>{{ $item->NombreTipoOrganizador }}</th>
                        <td>{{ $item->DescripcionTipoOrganizador }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="#"
                               data-toggle="modal" data-target="#editTipo"
                               data-tipo="{{ $item->IdTipoOrganizador }}"
                               data-nombre="{{ $item->NombreTipoOrganizador }}"
                               data-descripcion="{{ $item->DescripcionTipoOrganizador }}">Editar</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('tipoorganizador.modal.edit')

@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}"/>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>

    <script>
        $(document).ready( function () {
            $('#table_tipoorganizador').DataTable();
        } );

        /*edit documento*/
        $('#editTipo').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('tipo');
            var nombre = button.data('nombre');
            var descripcion = button.data('descripcion');
            var modal = $(this);
            var actionStart = '{{ route('tipoorganizador.update', '') }}';
            modal.find('.modal-body form').attr('action', actionStart);
            var action = $("#form-editar-tipo").attr('action') + '/' + id;
            modal.find('.modal-body form').attr('action', action);
            modal.find('.modal-body input[name=NombreTipoOrganizador]').val(nombre);
            modal.find('.modal-body input[name=DescripcionTipoOrganizador]').val(descripcion);
        });
    </script>

@endsection
