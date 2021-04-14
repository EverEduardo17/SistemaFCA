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
        <li class="breadcrumb-item active" aria-current="page">Traslados</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h4 class="card-title col-12 contenedor-botones texto-primario"><strong>{{$grupos[0]->NombreGrupo}} </strong></h4>
        </div>

    </div>
    <div class="card-body">
        <h5 class="pt-0 mt-0 contenedor-botones text-muted">Cohorte
            {{$grupos[0]->cohorte->NombreCohorte}} </h5>
        <h6 class="contenedor-botones text-muted">Traslados</h6>
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
            <a class="btn btn-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarTraslados', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Traslados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarReprobados', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Reprobados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarBajas', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->NombreGrupo]) }}"
                role="button">Ver Bajas</a>
        </div>
        <br>
        <hr class="mx-5">
        <h6 class="contenedor-botones pb-3 text-muted">Traslados salientes</h6>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_saliente">
                <caption>Estudiantes registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte
                    {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col">Matrícula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Facultad de destino</th>
                        <th scope="col">Campus de destino</th>
                        <th scope="col">Periodo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estudiantesSalientes as $estudiante)
                    <tr>
                        <td>{{$estudiante->trayectoria->estudiante->MatriculaEstudiante}}</td>
                        <td>{{$estudiante->trayectoria->datosPersonales->NombreDatosPersonales}}
                            {{$estudiante->trayectoria->datosPersonales->ApellidoPaternoDatosPersonales}}
                            {{$estudiante->trayectoria->datosPersonales->ApellidoMaternoDatosPersonales}}</td>
                        <td>{{$estudiante->FacultadDestino}}</td>
                        <td>{{$estudiante->CampusDestino}}</td>
                        <td>{{$estudiante->periodo->NombrePeriodo}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <hr class="mx-5">
        <h6 class="contenedor-botones pb-3 text-muted">Traslados entrantes</h6>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_entrante">
                <caption>Estudiantes registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte
                    {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col">Matrícula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Facultad de procedencia</th>
                        <th scope="col">Campus de procedencia</th>
                        <th scope="col">Periodo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estudiantesEntrantes as $estudiante)
                    <tr>
                        <td>{{$estudiante->trayectoria->estudiante->MatriculaEstudiante}}</td>
                        <td>{{$estudiante->trayectoria->datosPersonales->NombreDatosPersonales}}
                            {{$estudiante->trayectoria->datosPersonales->ApellidoPaternoDatosPersonales}}
                            {{$estudiante->trayectoria->datosPersonales->ApellidoMaternoDatosPersonales}}</td>
                        <td>{{$estudiante->FacultadDestino}}</td>
                        <td>{{$estudiante->CampusDestino}}</td>
                        <td>{{$estudiante->periodo->NombrePeriodo}}</td>
                    </tr>
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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    $(document).ready(function() {
        $('#table_saliente').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }

        });
        $('#table_entrante').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }

        });
    });
</script>
@endsection