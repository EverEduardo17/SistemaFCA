@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tipo de Organizadores</li>
    </ol>
</nav>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="row">
                <h5 class="card-title col-8">Tipo de Organizadores</h5>
                {{-- @can('havepermiso', 'tipoorganizador-listar') --}}
                    <a class="btn btn-success col-4" href="{{ route('tipoorganizador.create') }}" role="button">Agregar Tipo de Organizador</a>
                {{-- @endcan --}}
            </div>
        </div>
        <div class="card-body">
            <table id="table_tipoorganizador" class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="actions-col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipoorganizadores as $item)
                        <tr>
                            <th>{{ $item->NombreTipoOrganizador }}</th>
                            <td>{{ $item->DescripcionTipoOrganizador }}</td>
                            <td class="btn-group">
                                {{-- @can('havepermiso', 'tipoorganizador-editar') --}}
                                    <a class="btn btn-primary btn-sm" href="#"
                                       data-toggle="modal" data-target="#editTipo"
                                       data-tipo="{{ $item->IdTipoOrganizador }}"
                                       data-nombre="{{ $item->NombreTipoOrganizador }}"
                                       data-descripcion="{{ $item->DescripcionTipoOrganizador }}">Editar</a>
                                {{-- @endcan
                                @can('havepermiso', 'tipoorganizador-eliminar') --}}
                                    <a class="btn btn-danger btn-sm ml-1" href="#"
                                       data-toggle="modal" data-target="#deleteTipo"
                                       data-tipo="{{ $item->IdTipoOrganizador }}">Eliminar</a>
                                {{-- @endcan --}}
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
        /*delete documento*/
        $('#deleteTipo').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('tipo');
            var modal = $(this);
            var actionStart = '{{ route('tipoorganizador.destroy', '') }}';
            modal.find('.modal-body form').attr('action', actionStart);
            var action = $("#form-eliminar-tipo").attr('action') + '/' + id;
            modal.find('.modal-body form').attr('action', action);
        });
    </script>

@endsection
