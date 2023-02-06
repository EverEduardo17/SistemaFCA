@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarCohorte') }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $grupos[0]->cohorte->NombreCohorte) }}">Cohorte
                {{$grupos[0]->cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $nombreGrupo]) }}">{{ $grupos[0]->NombreGrupo }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Egresados</li>
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
        <h5 class="mt-0 contenedor-botones text-muted">Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</h5>
        <h6 class="mt-3 contenedor-botones text-muted">Último Periodo: {{ $grupos[0]->PeriodoActivo->NombrePeriodo }}</h6>
        
        <div class="row justify-content-center  mt-3">
            <a class="btn btn-outline-info px-6 mb-3"
                href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $nombreGrupo]) }}"
                role="button">Ver Resumen</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEstado', [$grupos[0]->cohorte->NombreCohorte, $nombreGrupo]) }}"
                role="button">Ver Estado</a>
            <a class="btn btn-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEgresados', [$grupos[0]->cohorte->NombreCohorte, $nombreGrupo]) }}"
                role="button">Ver Egresados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarTraslados', [$grupos[0]->cohorte->NombreCohorte, $nombreGrupo]) }}"
                role="button">Ver Traslados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarReprobados', [$grupos[0]->cohorte->NombreCohorte, $nombreGrupo]) }}"
                role="button">Ver Reprobados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarBajas', [$grupos[0]->cohorte->NombreCohorte, $nombreGrupo]) }}"
                role="button">Ver Bajas</a>
        </div>
        <a class="btn btn-outline-success float-right mb-3"
            href="{{ route('cohortes.imprimirEgresados', [$grupos[0]->cohorte->NombreCohorte, $nombreGrupo]) }}"
            target="_blank" role="button"><em class="fas fa-save"></em> Guardar PDF</a>
        <div class="mt-3">
            <br>
            <hr class="mx-5">
        </div>
        <h6 class="contenedor-botones pb-3 text-muted">Egresados en general</h6>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_egresados">
                <caption>Estudiantes egresados registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del
                    cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right"></th>
                        <th scope="col" class="border-right">Hombres</th>
                        <th scope="col" class="border-right">Mujeres</th>
                        <th scope="col" class="border-right">Total</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-right">Egresados</td>
                        <td class="border-right">{{$hombre}}</td>
                        <td class="border-right">{{$mujer}}</td>
                        <td class="border-right"><strong>{{$totalEgresados}}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <hr class="mx-5">
        <h6 class="contenedor-botones pb-3 text-muted">Egresados por periodo</h6>

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_periodos">
                <caption>Estudiantes egresados registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del
                    cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right">Periodo</th>
                        <th scope="col" class="border-right">Hombres</th>
                        <th scope="col" class="border-right">Mujeres</th>
                        <th scope="col" class="border-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($periodos as $periodo)
                    @if(!empty($egresadosPeriodo))
                    @if ($loop->index <= $totalPeriodos ) <tr>
                        <th scope="row" class="border-right"><a
                                href="{{route('cohortes.mostrarEgresados.periodo',[$grupos[0]->cohorte->NombreCohorte , $nombreGrupo , $nombresPeriodos[$loop->index]])}}">{{$periodo->NombrePeriodo}}</a>
                        </th>
                        <td class="border-right">{{$egresadosPeriodo[$loop->index]["hombre"]}}</td>
                        <td class="border-right">{{$egresadosPeriodo[$loop->index]["mujer"]}}</td>
                        <td class="border-right">
                            <strong>{{$egresadosPeriodo[$loop->index]["hombre"] + $egresadosPeriodo[$loop->index]["mujer"]}}</strong>
                        </td>
                        </tr>
                        @endif
                        @else
                        <tr>
                            <th scope="row" class="border-right"><a
                                href="{{route('cohortes.mostrarEgresados.periodo',[$grupos[0]->cohorte->NombreCohorte , $nombreGrupo , $nombresPeriodos[$loop->index]])}}">{{$periodo->NombrePeriodo}}</a>
                            </th>
                            <td class="border-right">0</td>
                            <td class="border-right">0</td>
                            <td class="border-right"><strong>0</strong></td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <th scope="col" colspan="3" class="text-align-right"><strong>Total de Estudiantes
                                    Egresados</strong></th>
                            <td><strong>{{$totalEgresados}}</strong></td>
                        </tr>
                </tbody>
            </table>
        </div>
        <br>
        <hr class="mx-5">
        <h6 class="contenedor-botones py-3 text-muted">Egresados por modalidad</h6>

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_modalidades">
                <caption>Estudiantes egresados registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del
                    cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right">Modalidad</th>
                        <th scope="col" class="border-right">Hombres</th>
                        <th scope="col" class="border-right">Mujeres</th>
                        <th scope="col" class="border-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($modalidades as $modalidad)
                    @if(!empty($egresadosModalidad))
                    @if ($loop->index <= $totalModalidades ) <tr>
                        <th scope="row" class="border-right">{{$modalidad->NombreModalidad}}</th>
                        <td class="border-right">{{$egresadosModalidad[$loop->index]["hombre"]}}</td>
                        <td class="border-right">{{$egresadosModalidad[$loop->index]["mujer"]}}</td>
                        <td class="border-right">
                            <strong>{{$egresadosModalidad[$loop->index]["hombre"] + $egresadosModalidad[$loop->index]["mujer"]}}</strong>
                        </td>
                        </tr>
                        @endif
                        @else
                        <tr>
                            <th scope="row" class="border-right">{{$modalidad->NombreModalidad}}</th>
                            <td class="border-right">0</td>
                            <td class="border-right">0</td>
                            <td class="border-right"><strong>0</strong></td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <th scope="col" colspan="3" class="text-align-right"><strong>Total de Estudiantes
                                    Egresados</strong></th>
                            <td><strong>{{$totalEgresados}}</strong></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('grupos.modals.delete')
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    // $(document).ready(function() {
    //     $('#table_periodos').DataTable({
    //         "language": {
    //             "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
    //         }

    //     });
    // });
</script>
@endsection