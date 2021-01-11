@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', "S200") }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $grupos[0]->cohorte->NombreCohorte) }}">Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarGrupo', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->IdGrupo]) }}">{{$grupos[0]->NombreGrupo}} - {{$grupos[0]->cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarReprobados', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->IdGrupo, $periodos[0]->IdPeriodo]) }}">Reprobados</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$periodos[0]->NombrePeriodo}}</li>
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
        <h6 class="contenedor-botones text-muted">Reprobados del periodo {{$periodos[0]->NombrePeriodo}}</h6>
        <a class="btn btn-outline-dark float-left px-6 mb-3" href="{{ route('cohortes.mostrarReprobados', [$grupos[0]->cohorte->NombreCohorte, $grupos[0]->IdGrupo]) }}" role="button"><em class="fas fa-arrow-left"></em> Regresar</a>

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_periodo">
                <caption>Estudiantes reprobados en el periodo {{$periodos[0]->NombrePeriodo }} registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col">Matrícula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Periodo de reprobación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estudiantes as $estudiante)
                    <tr>
                        <td>{{$estudiante->trayectoria->estudiante->MatriculaEstudiante}}</td>
                        <td>{{$estudiante->trayectoria->datosPersonales->NombreDatosPersonales}} {{$estudiante->trayectoria->datosPersonales->ApellidoPaternoDatosPersonales}} {{$estudiante->trayectoria->datosPersonales->ApellidoMaternoDatosPersonales}}</td>
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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    $(document).ready(function() {
        $('#table_periodo').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }

        });
    });
</script>
@endsection