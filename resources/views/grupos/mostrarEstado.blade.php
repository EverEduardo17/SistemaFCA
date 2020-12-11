@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', "S200") }}">Gestión de Grupos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $grupos[0]->cohorte->NombreCohorte) }}">Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$grupos[0]->NombreGrupo}} - {{$grupos[0]->cohorte->NombreCohorte}}</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Cohorte: <strong>{{$grupos[0]->cohorte->NombreCohorte}}</strong> - Grupo: <strong>{{$grupos[0]->NombreGrupo}}</strong></h5>
            <div class="dropdown show col-4">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown link
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>

    </div>
    <div class="card-body">
        <h6 class="pb-3">Resumen</h6>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_sede">
                <caption>Estudiantes registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
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