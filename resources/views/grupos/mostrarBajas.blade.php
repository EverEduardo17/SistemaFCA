@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', "S200") }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $grupos[0]->cohorte->NombreCohorte) }}">Cohorte
                {{$grupos[0]->cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->IdGrupo]) }}">{{$grupos[0]->NombreGrupo}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Bajas</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h4 class="card-title col-12 contenedor-botones texto-primario"><strong>{{$grupos[0]->NombreGrupo}}</strong>
            </h4>
        </div>

    </div>
    <div class="card-body">
        <h5 class="pt-0 mt-0 contenedor-botones text-muted">Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</h5>
        <h6 class="contenedor-botones text-muted">Bajas</h6>
        <div class="contenedor-botones mt-3">
            <a class="btn btn-outline-info px-6 mb-3"
                href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Resumen</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEstado', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Estado</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEgresados', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Egresados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarTraslados', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Traslados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarReprobados', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Reprobados</a>
            <a class="btn btn-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarBajas', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Bajas</a>
        </div>

        <br>
        <hr class="mx-5">
        <h6 class="contenedor-botones pb-3 text-muted">Bajas totales</h6>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_sede">
                <caption>Estudiantes dados de baja registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}}
                    del cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
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
                        <td class="border-right">Temporal</td>
                        <td class="border-right">{{$hombreTemporal}}</td>
                        <td class="border-right">{{$mujerTemporal}}</td>
                        <td class="border-right">{{$hombreTemporal + $mujerTemporal}}</td>
                    </tr>
                    <tr>
                        <td class="border-right">Definitiva</td>
                        <td class="border-right">{{$hombreDefinitivo}}</td>
                        <td class="border-right">{{$mujerDefinitivo}}</td>
                        <td class="border-right">{{$hombreDefinitivo + $mujerDefinitivo}}</td>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3" class="text-align-right"><strong>Total de Estudiantes</strong></th>
                        <td><strong>{{$hombreTemporal + $mujerTemporal + $hombreDefinitivo + $mujerDefinitivo}}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>
        <hr class="mx-5">
        <h6 class="contenedor-botones pb-3 text-muted">Bajas por motivo</h6>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover" id="table_periodos">
                <caption>Estudiantes dados de baja por motivo registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}}
                    del cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right">Motivo</th>
                        <th scope="col" class="border-right">Hombres</th>
                        <th scope="col" class="border-right">Mujeres</th>
                        <th scope="col" class="border-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($motivos as $motivo)
                        @if(!empty($resultados))
                            @if(isset($resultados[$motivo->IdMotivo]))
                            <tr>
                                <th scope="row" class="border-right">{{$motivo->NombreMotivo}}</th>
                                <td class="border-right">{{$resultados[$motivo->IdMotivo - 1 ]["hombre"]}}</td>
                                <td class="border-right">{{$resultados[$motivo->IdMotivo - 1 ]["mujer"]}}</td>
                                <td class="border-right">
                                    <strong>{{$resultados[$motivo->IdMotivo - 1 ]["hombre"] + $resultados[$motivo->IdMotivo]["mujer"]}}</strong>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <th scope="row" class="border-right">{{$motivo->NombreMotivo}}</th>
                                <td class="border-right">0</td>
                                <td class="border-right">0</td>
                                <td class="border-right"><strong>0</strong></td>
                            </tr>
                            @endif
                        @else
                        <tr>
                            <th scope="row" class="border-right">{{$motivo->NombreMotivo}}</th>
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
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
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