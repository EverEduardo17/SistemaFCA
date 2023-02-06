@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarCohorte') }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $cohorte->NombreCohorte) }}">Cohorte
                {{$cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Traslados</li>
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
        <h5 class="pt-0 mt-0 mb-3 contenedor-botones text-muted">Traslados</h5>
        <h6 class="pt-0 mt-0 mb-3 contenedor-botones text-muted">Último periodo registrado: {{ $ultimoPeriodo }}</h6>
        <div class="row justify-content-center  mt-3">
            <a class="btn btn-outline-info px-6 mb-3" href="{{ route('cohortes.mostrarResumen', [$cohorte->NombreCohorte]) }}"
                role="button">Ver Resumen</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEstadoCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Estado</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEgresadosCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Egresados</a>
            <a class="btn btn-info px-6 mb-3 ml-2"
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
        href="{{ route('cohortes.imprimirTrasladosCohorte', [$cohorte->NombreCohorte]) }}"
        target="_blank" role="button"><em class="fas fa-save"></em> Guardar PDF</a>
        
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_sede">
                <caption>Estudiantes trasladados registrados en el sistema para el cohorte {{$cohorte->NombreCohorte}} clasificados
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
                        <th rowspan="3">Entrantes</th>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Hombres: &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]['entrantes']["hombre"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Mujeres: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]['entrantes']["mujer"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td><strong>Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]['entrantes']["total"]}}</strong></td>
                        @endfor
                    </tr>
                    
                    <tr>
                        <th rowspan="3">Salientes</th>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Hombres: &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]['salientes']["hombre"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Mujeres: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]['salientes']["mujer"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td><strong>Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]['salientes']["total"]}}</strong></td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('head')

@endsection

@section('script')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.0/dist/chart.min.js"></script> --}}
@endsection