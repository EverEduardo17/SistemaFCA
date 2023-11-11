{{-- 
    mostrar grupos, 
    entrar a un grupo,
    dar click a un boton agregar a lado de cada estudiante, para agregarlo a la constancia al instante
    verificar que cada estudiante solo pueda estar una vez en la constancia
    y mostrar el boton de agregar como agregado cuando ya esté agregado
    (o que el boton de agregar no se muestre si ya está agregado)
    y quiza mostrar el boton de eliminar si ya está agregado (?)
--}}

@extends('layouts.app')

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.show', $constancia->IdConstancia) }}">{{ $constancia->NombreConstancia }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Elegir Grupo</li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mr-auto"><strong>Elegir Grupo</strong></h5>
            <a class="btn btn-outline-info col-4 ml-auto mr-4 " href="{{ route('constancias.show', $constancia->IdConstancia) }}" role="button">Regresar</a>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive-">
            <table class="table table-striped table-hover border-bottom border-right" id="table-jquery">
                <caption>Grupos registrados en el sistema.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border">Nombre</th>
                        <th scope="col" class="border">Programa Educativo</th>
                        <th scope="col" class="border">Cohorte de pertenencia</th>
                        <th scope="col" class="border">Total de estudiantes</th>
                        <th scope="col" class="border">Último periodo activo</th>
                        <th scope="col" class="border actions-col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grupos as $grupo)
                    <tr>
                        <th scope="row" class="border-right border-left">
                            <a href="{{ route('constancias.indexEstudiantes', ['constancia' => $constancia, 'grupo' => $grupo]) }}">
                                {{ $grupo->NombreGrupo }}
                            </a>
                        </th>

                        <td class="border-right">{{ $grupo->programaEducativo->AcronimoProgramaEducativo }}</td>

                        <td class="border-right">{{ $grupo->cohorte->NombreCohorte }}</td>

                        @inject('estudiantes', 'App\Http\Controllers\GrupoController')
                            <td class="border-right">{{ $estudiantes->contarEstudiantes($grupo->IdGrupo) }}</td>
                        
                        <td class="border-right">{{ $grupo->periodoActivo->NombrePeriodo }}</td>

                        <td class="btn-group btn-group-sm d-flex justify-content-center">
                            <a class="btn btn-sm btn-outline-info mx-4" href="{{ route('constancias.indexEstudiantes', ['constancia' => $constancia]) }}" data-toggle="tooltip" data-placement="bottom" title="Estudiantes"><em class="fas fa-user"></em></a>
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
<script src="{{ asset('js/table-script.js') }}"></script>
@endsection