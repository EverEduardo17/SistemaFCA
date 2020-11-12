@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Sedes</h5>
            <a class="btn btn-primary col-4" href="{{ route('sedeEventos.create') }}" role="button">Agregar Sede</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="table_sede">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sedes as $item)
                <tr>
                    <th>{{ $item->NombreSedeEvento }}</th>
                    <td>{{ $item->DescripcionSedeEvento }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('sedeEventos.edit', $item) }}">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}"/>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
    <script>
        $(document).ready( function () {
            $('#table_sede').DataTable();
        } );
    </script>
@endsection
