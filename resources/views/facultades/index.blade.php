@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <h5 class="card-title col-8">Facultades</h5>
                <a class="btn btn-primary col-4" href="{{ route('facultades.create') }}" role="button">Agregar Facultad</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table_facultades+098765">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Clave</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facultades as $item)
                        <tr>
                            <th>{{ $item->NombreFacultad }}</th>
                            <td>{{ $item->ClaveFacultad }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('facultades.edit', $item) }}">Editar</a>
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
            $('#table_facultades').DataTable();
        } );
    </script>
@endsection
