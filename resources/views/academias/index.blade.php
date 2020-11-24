@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Academias</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Academias</h5>
            <a class="btn btn-success col-4" href="{{ route('academias.create') }}" role="button">Agregar Academia</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="table_academias">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Coordinador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($academias as $item)
                <tr>
                    <th>{{ $item->NombreAcademia }}</th>
                    <td>{{ $item->DescripcionAcademia }}</td>
                    <td>{{ $item->coordinador->usuario->name }}</td>
                    <td>
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('academias.show', $item) }}">Detalles</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('academias.edit', $item) }}">Editar</a>
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
        $('#table_academias').DataTable();
    });
</script>
@endsection