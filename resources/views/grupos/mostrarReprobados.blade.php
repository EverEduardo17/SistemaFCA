@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', "S200") }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $grupos[0]->cohorte->NombreCohorte) }}">Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->IdGrupo]) }}">{{$grupos[0]->NombreGrupo}} - {{$grupos[0]->cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Reprobados</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h4 class="card-title col-12 contenedor-botones texto-primario"><strong> Cohorte {{$grupos[0]->cohorte->NombreCohorte}} </strong></h4>
        </div>

    </div>
    <div class="card-body">
        <h5 class="pt-0 mt-0 contenedor-botones text-muted">{{$grupos[0]->NombreGrupo}}</h5>
        <h6 class="contenedor-botones text-muted">Reprobados</h6>

        <a class="btn btn-outline-dark float-left px-6 mb-3" href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->IdGrupo]) }}" role="button"><em class="fas fa-arrow-left"></em> Regresar</a>
        <a class="btn btn-outline-info float-right px-6 mb-3" href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->IdGrupo]) }}" role="button">Ver Resumen</a>


        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_sede">
                <caption>Estudiantes reprobados registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
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
                        <td class="border-right">Reprobados</td>
                        <td class="border-right">{{$hombre}}</td>
                        <td class="border-right">{{$mujer}}</td>
                        <td class="border-right"><strong>{{$totalReprobados}}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <hr class="mx-5">
        <h6 class="contenedor-botones pb-3 text-muted">Reprobados por periodo</h6>

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover" id="table_periodos">
                <caption>Estudiantes reprobados registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
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
                            <tr>
                                <th scope="row" class="border-right"><a href="{{route('cohortes.mostrarReprobados.periodo',[$grupos[0]->cohorte->NombreCohorte , $grupos[0]->IdGrupo , $periodo->IdPeriodo])}}">{{$periodo->NombrePeriodo}}</a></th>
                                <td class="border-right">{{$egresadosPeriodo[$loop->index][0]}}</td>
                                <td class="border-right">{{$egresadosPeriodo[$loop->index][1]}}</td>
                                <td class="border-right"><strong>{{$egresadosPeriodo[$loop->index][0] + $egresadosPeriodo[$loop->index][1]}}</strong></td>
                            </tr>
                        @else
                            <tr>
                                <th scope="row" class="border-right"><a href="{{route('cohortes.mostrarEgresados.periodo',[$grupos[0]->cohorte->NombreCohorte , $grupos[0]->IdGrupo , $periodo->IdPeriodo])}}">{{$periodo->NombrePeriodo}}</a></th>
                                <td class="border-right">0</td>
                                <td class="border-right">0</td>
                                <td class="border-right"><strong>0</strong></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
       
    </div>
</div>
@include('grupos.modals.delete')
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    $(document).ready(function() {
        $('#table_periodos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }

        });
    });
</script>
@endsection