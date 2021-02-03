@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarCohorte') }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $grupos[0]->cohorte->NombreCohorte) }}">Cohorte
                {{$grupos[0]->cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}">{{ $grupos[0]->NombreGrupo }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Estado</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h4 class="card-title col-12 contenedor-botones texto-primario"><strong>
                    {{$grupos[0]->NombreGrupo}}</strong></h4>
        </div>

    </div>
    <div class="card-body">
        <h5 class="pt-0 mt-0 contenedor-botones text-muted">Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</h5>
        <h6 class="contenedor-botones text-muted">Estado</h6>
        <div class="contenedor-botones mt-3">
            <a class="btn btn-outline-info px-6 mb-3"
                href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Resumen</a>
            <a class="btn btn-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEstado', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Estado</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEgresados', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Egresados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEstado', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Traslados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEstado', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Bajas</a>
        </div>

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_sede">
                <caption>Estudiantes registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte
                    {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col"></th>
                        <th scope="col">Hombres</th>
                        <th scope="col">Mujeres</th>
                        <th scope="col">Total</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Activos</td>
                        <td>{{$activoHombre}}</td>
                        <td>{{$activoMujer}}</td>
                        <td>{{$totalActivos}}</td>
                    </tr>
                    <tr>
                        <td>Egresados</td>
                        <td>{{$egresadoHombre}}</td>
                        <td>{{$egresadoMujer}}</td>
                        <td>{{$totalEgresados}}</td>
                    <tr>
                        <td>Bajas</td>
                        <td>{{$bajaHombre}}</td>
                        <td>{{$bajaMujer}}</td>
                        <td>{{$totalBajas}}</td>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3" class="text-align-right"><strong>Total Estudiantes</strong></th>
                        <td><strong>{{$totalActivos + $totalEgresados +$totalBajas}}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('grupos.modals.delete')
@endsection

@section('head')

@endsection

@section('script')


@endsection