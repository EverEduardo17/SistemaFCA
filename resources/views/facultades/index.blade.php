@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Facultades</li>
    </ol>
</nav>
<div class="card shadow-sm">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Facultades</h5>
            @can('havepermiso', 'facultades-crear')
                <a class="btn btn-success col-4" href="{{ route('facultades.create') }}" role="button">Agregar Facultad</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="table_facultades">
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
                        @can('havepermiso', 'facultades-editar')
                            <a class="btn btn-primary btn-sm" href="{{ route('facultades.edit', $item) }}">Editar</a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    $(document).ready(function() {
        $('#table_facultades').DataTable();
    });
</script>
@endsection
