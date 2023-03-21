@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarCohorte') }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $cohorte->NombreCohorte) }}">Cohorte
                {{$cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Egresados</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h4 class="card-title col-12 contenedor-botones texto-primario"><strong>
                    Cohorte {{$cohorte->NombreCohorte}}</strong></h4>
        </div>

    </div>
    <div class="card-body">
        <h5 class="pt-0 mt-0 mb-3 contenedor-botones text-muted">Egresados</h5>
        <h6 class="pt-0 mt-0 mb-3 contenedor-botones text-muted">Último periodo registrado: {{ $ultimoPeriodo }}</h6>
        <div class="row justify-content-center  mt-3">
            <a class="btn btn-outline-info px-6 mb-3"
                href="{{ route('cohortes.mostrarResumen', [$cohorte->NombreCohorte]) }}" role="button">Ver Resumen</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEstadoCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Estado</a>
            <a class="btn btn-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEgresadosCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Egresados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarTrasladosCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Traslados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarReprobadosCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Reprobados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarBajasCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Bajas</a>
        </div>
        <a class="btn btn-outline-success float-right mb-3"
            href="{{ route('cohortes.imprimirEgresadosCohorte', [$cohorte->NombreCohorte]) }}" target="_blank"
            role="button"><em class="fas fa-save"></em> Guardar PDF</a>

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_egresados">
                <caption>Estudiantes egresados registrados en el sistema para el cohorte {{$cohorte->NombreCohorte}}
                    clasificados
                    por Programa Educativo.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col"></th>
                        @foreach ($programas as $programa)
                        <th scope="col">{{ $programa->AcronimoProgramaEducativo }}</th>
                        @endforeach

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th rowspan="3">Egresados</th>
                        @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Hombres:
                            &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadoHombre"]}}</td>
                            @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Mujeres:
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadoMujer"]}}</td>
                            @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++) <td><strong>Total:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["totalEgresados"]}}</strong>
                            </td>
                            @endfor
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <hr class="mx-5">
        <h6 class="contenedor-botones pb-3 text-muted">Egresados por periodo</h6>

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_periodos">
                <caption>Estudiantes egresados clasificados por periodo registrados en el sistema para el cohorte {{$cohorte->NombreCohorte}} clasificados
                    por Programa Educativo.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right">Periodo</th>
                         @foreach ($programas as $programa)
                        <th scope="col" class="border-right">{{ $programa->AcronimoProgramaEducativo }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($periodos as $periodo)
                        @if ($loop->index <= $totalPeriodos )
                            <tr>
                                <th class="border-right border-left" rowspan="3"><a href="#">{{$periodo->NombrePeriodo}}</a></th>
                                @for ($i = 0; $i < $tamanioProgramas; $i++)
                                    @if(!empty($informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["hombre"]))
                                        <td class="border-right">Hombres:&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["hombre"]}}</td>     
                                        @else
                                        <td class="border-right">Hombres:&nbsp;&nbsp;&nbsp;&nbsp;0</td>     
                                    @endif
                                @endfor
                            </tr>
                            <tr>
                                @for ($i = 0; $i < $tamanioProgramas; $i++) 
                                    @if(!empty($informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["mujer"]))
                                        <td>Mujeres:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["mujer"]}}</td>
                                    @else
                                        <td>Mujeres:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0</td>
                                    @endif
                                @endfor
                            </tr>
                            <tr>
                                @for ($i = 0; $i < $tamanioProgramas; $i++) 
                                    @if(!empty($informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["total"]))
                                        <td><strong>Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["total"]}}</strong></td>
                                    @else
                                        <td><strong>Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0</strong></td>
                                    @endif
                                @endfor
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <br>
        <hr class="mx-5">
        <h6 class="contenedor-botones py-3 text-muted">Egresados por modalidad</h6>

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_modalidades">
                <caption>Estudiantes egresados clasificados por modalidad de acreditación registrados en el sistema para el cohorte {{$cohorte->NombreCohorte}} clasificados
                    por Programa Educativo.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right">Modalidad</th>
                         @foreach ($programas as $programa)
                        <th scope="col" class="border-right">{{ $programa->AcronimoProgramaEducativo }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($modalidades as $modalidad)
                        @if ($loop->index <= $totalModalidades )
                            <tr>
                                <th class="border-right border-left" rowspan="3"><a href="#">{{$modalidad->NombreModalidad}}</a></th>
                                @for ($i = 0; $i < $tamanioProgramas; $i++)
                                    @if(!empty($informacionPorPrograma[$i]["egresadosPorModalidad"][$loop->index]["hombre"]))
                                        <td class="border-right">Hombres:&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadosPorModalidad"][$loop->index]["hombre"]}}</td>     
                                        @else
                                        <td class="border-right">Hombres:&nbsp;&nbsp;&nbsp;&nbsp;0</td>     
                                    @endif
                                @endfor
                            </tr>
                            <tr>
                                @for ($i = 0; $i < $tamanioProgramas; $i++) 
                                    @if(!empty($informacionPorPrograma[$i]["egresadosPorModalidad"][$loop->index]["mujer"]))
                                        <td>Mujeres:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadosPorModalidad"][$loop->index]["mujer"]}}</td>
                                    @else
                                        <td>Mujeres:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0</td>
                                    @endif
                                @endfor
                            </tr>
                            <tr>
                                @for ($i = 0; $i < $tamanioProgramas; $i++) 
                                    @if(!empty($informacionPorPrograma[$i]["egresadosPorModalidad"][$loop->index]["total"]))
                                        <td><strong>Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadosPorModalidad"][$loop->index]["total"]}}</strong></td>
                                    @else
                                        <td><strong>Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0</strong></td>
                                    @endif
                                @endfor
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('script')
@endsection