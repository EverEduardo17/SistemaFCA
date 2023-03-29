{{-- 
    mostrar grupos, 
    entrar a un grupo,
    dar click a un boton agregar a lado de cada estudiante, para agregarlo a la constancia al instante
    verificar que cada estudiante solo pueda estar una vez en la constancia
    y mostrar el boton de agregar como agregado cuando ya esté agregado
    (o que el boton de agregar no se muestre si ya está agregado)
    y quiza mostrar el boton de eliminar si ya está agregado (?)
--}}

@extends('layouts.plantilla')

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.show', $constancia->IdConstancia) }}">{{ $constancia->NombreConstancia }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Elegir Grupo</li>
    </ol>
</nav>
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8"><strong>Elegir Grupo</strong></h5>
            <a class="btn btn-success col-4" href="{{ route('grupos.index') }}" role="button">Gestión de Grupos</a>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover" id="table_sede">
                <caption>Grupos registrados en el sistema.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right">Nombre</th>
                        <th scope="col" class="border-right">Programa Educativo</th>
                        <th scope="col" class="border-right">Cohorte de pertenencia</th>
                        <th scope="col" class="border-right">Estudiantes activos</th>
                        <th scope="col" class="border-right">Total de estudiantes</th>
                        <th scope="col" class="border-right">Último periodo activo</th>
                        <th scope="col" class="border-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grupos as $grupo)
                    <tr>
                        <th scope="row" class="border-right">{{ $grupo->NombreGrupo }}</th>
                        <td class="border-right">{{ $grupo->programaEducativo->AcronimoProgramaEducativo }}</td>
                        <td class="border-right">{{ $grupo->cohorte->NombreCohorte }}</td>
                        @inject('estudiantes', 'App\Http\Controllers\GrupoController')
                            <td class="border-right">{{$estudiantes->contarEstudiantes($grupo->IdGrupo)[0]}}</td>
                            <td class="border-right"><strong>{{$estudiantes->contarEstudiantes($grupo->IdGrupo)[0] + $estudiantes->contarEstudiantes($grupo->IdGrupo)[1]}}</strong></td>
                        <td class="border-right">{{ $grupo->periodoActivo->NombrePeriodo }}</td>
                        <td class="btn-group btn-group-sm">
                            <a class="btn btn-sm btn-outline-info mx-2" href="{{ route('constancias.indexEstudiantes', ['constancia' => $constancia, 'grupo' => $grupo]) }}" data-toggle="tooltip" data-placement="bottom" title="Estudiantes"><em class="fas fa-user"></em></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    $(document).ready(function() {
        $('#table_sede').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }

        });
    });
</script>
@endsection