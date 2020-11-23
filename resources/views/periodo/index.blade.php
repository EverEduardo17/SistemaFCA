@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Periodos</h5>
            <a class="btn btn-primary col-4" href="{{ route('periodo.create') }}" role="button">Agregar Periodo</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Término</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($periodoes as $item)
                <tr>
                    <th>{{ $item->NombrePeriodo }}</th>
                    <td>{{ $item->FechaInicioPeriodo }}</td>
                    <td>{{ $item->FechaFinPeriodo }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('periodo.edit', $item) }}">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection