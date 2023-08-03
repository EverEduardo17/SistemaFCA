@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sedes</li>
    </ol>
</nav>
<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Sedes</h5>

            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ route('home') }}" role="button">Regresar</a>
            
            @can('havepermiso', 'sedes-listar')
                <a class="btn btn-success col-4" href="{{ route('sedeEventos.create') }}" role="button">Agregar Sede</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="table-jquery">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th class="actions-col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sedes as $item)
                <tr>
                    <th class="border-left">{{ $item->NombreSedeEvento }}</th>
                    <td>{{ $item->DescripcionSedeEvento }}</td>
                    <td class="d-flex justify-content-center mr-4 ml-4">
                        @can('havepermiso', 'sedes-editar')
                            <a class="btn btn-primary btn-sm" href="{{ route('sedeEventos.edit', $item) }}">Editar</a>
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
    <script src="{{ asset('js/table-script.js') }}"></script>
@endsection
