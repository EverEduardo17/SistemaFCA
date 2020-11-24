@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Académicos</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Académicos</h5>
            <a class="btn btn-success col-4" href="{{ route('academicos.create') }}" role="button">Agregar Académico</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="table_academicos">
            <thead>
                <tr>
                    <th>No. Personal</th>
                    <th>Nombre Completo</th>
                    <th>Correo electrónico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($academicos as $academico)
                <tr>
                    <td>{{$academico->NoPersonalAcademico ?? ""}}</td>
                    <td>
                        {{$academico->usuario->datosPersonales->ApellidoPaternoDatosPersonales ?? ""}}
                        {{$academico->usuario->datosPersonales->ApellidoMaternoDatosPersonales ?? "-"}}
                        {{$academico->usuario->datosPersonales->NombreDatosPersonales ?? ""}}
                    </td>
                    <td>{{$academico->usuario->email ?? ""}}</td>
                    <td>
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('academicos.show', $academico) }}">Detalles</a>                        
                        <a class="btn btn-primary btn-sm" href="{{ route('academicos.edit', $academico) }}">Editar</a>
                        <a class="btn btn-danger btn-sm" href="{{ route('academicos.destroy', $academico) }}">Eliminar</a>
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
        $('#table_academicos').DataTable();
    });
</script>
@endsection