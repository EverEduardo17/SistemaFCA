@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarCohorte') }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cohorte {{ $nombreCohorte }}</li>
    </ol>
</nav>
@endsection
@section('content')
@csrf @method('PATCH')
@include('layouts.validaciones')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h4 class="card-title col-8">Gestión de Estudiantes</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="contenedor-botones justify-content-center align-items-center">
            {{-- <a class="btn btn-outline-dark mr-2" href="#"> <em class="fas fa-eye"></em> Ver Cohorte</a> --}}
            <a href="{{ route('cohortes.agregarEstudiante',$nombreCohorte) }}" class="btn btn-outline-dark mr-2"><em
                    class="fas fa-plus-circle"></em> Carga masiva de Estudiante</a>
            </a>
        </div>
        <h5 class="py-2">Cohortes</h5>
        <div class="testimonial-group mx-3 my-2">
            <div class="row text-center text-white">
                @foreach($cohortes as $cohorte)
                <a class="col-s-4 btn mb-3 @if($cohorte->IdCohorte == $idCohorte)btn-primary @elseif($cohorte->IdCohorte <> $idCohorte)btn-outline-primary @endif"
                    href="{{ route('cohortes.show', $cohorte->NombreCohorte) }}">{{$cohorte->NombreCohorte}}</a>
                @endforeach
            </div>
        </div>
        <div class="contenedor-botones justify-content-center align-items-center">
            <a class="btn btn-outline-dark mr-2" href="#"> <em class="fas fa-eye"></em> Ver Cohorte</a>
            {{-- <a href="{{ route('cohortes.agregarEstudiante',$nombreCohorte) }}" class="btn btn-outline-dark
            mr-2"><em class="fas fa-plus-circle"></em> Carga masiva de Estudiante</a>
            </a> --}}
        </div>
        <hr class="my-4">
        <h5 class="py-2">Grupos</h5>
        <ul class="nav nav-tabs" id="nav-tab" role="tablist">
            @foreach ($programas as $programa)
            <li class="nav-item" role="presentation">
                <a class="btn-outline-primary nav-link 
                @if($programa->AcronimoProgramaEducativo == $programas[0]->AcronimoProgramaEducativo) active" @endif
                    id="nav-{{$programa->AcronimoProgramaEducativo}}-tab" data-toggle="tab"
                    href="#nav-{{$programa->AcronimoProgramaEducativo}}" role="tab"
                    aria-controls="nav-{{$programa->AcronimoProgramaEducativo}}"
                    aria-selected="@if($programa->AcronimoProgramaEducativo == $programas[0]->AcronimoProgramaEducativo)true"
                    @endif @if($programa->AcronimoProgramaEducativo != $programas[0]->AcronimoProgramaEducativo)"false"
                    @endif >{{ $programa->AcronimoProgramaEducativo }}</a>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="nav-tabContent">
            @foreach ($programas as $programa)
            <div class="py-3 tab-pane fade @if($programa->AcronimoProgramaEducativo == $programas[0]->AcronimoProgramaEducativo)show active @endif"
                id="nav-{{$programa->AcronimoProgramaEducativo}}" role="tabpanel"
                aria-labelledby="nav-{{$programa->AcronimoProgramaEducativo}}-tab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center mb-0 pb-0">
                            <h5 class="mr-auto pl-3">{{$programa->AcronimoProgramaEducativo}} - {{$nombreCohorte}}</h5>
                            <div class="btn-group" role="group">
                                <button class="btn btn-success" data-toggle="modal" data-target="#create">Agregar Grupo</button>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table class="table table-striped table-hover"
                            id="table_{{$programa->AcronimoProgramaEducativo}}">
                            <caption>Grupos registrados en el sistema para el programa
                                {{$programa->AcronimoProgramaEducativo}} en
                                el cohorte {{$nombreCohorte}}.</caption>
                            <thead class="bg-table">
                                <tr class="text-white">
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Estudiantes Activos</th>
                                    <th scope="col">Estudiantes Inactivos</th>
                                    <th scope="col">Total de estudiantes</th>
                                    <th scope="col">Último periodo activo</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupos as $grupo)
                                @if($grupo->IdProgramaEducativo == $programa->IdProgramaEducativo)
                                <tr>
                                    @inject('cantidades', 'App\Http\Controllers\GrupoController')
                                    <th scope="row">{{ $grupo->NombreGrupo }}</th>

                                    <td>@if($cantidades->contarEstudiantes($grupo->IdGrupo)[0] == null)0
                                        @elseif($cantidades->contarEstudiantes($grupo->IdGrupo)[0] <>
                                            null) {{$cantidades->contarEstudiantes($grupo->IdGrupo)[0]}}@endif</td>
                                    <td>@if($cantidades->contarEstudiantes($grupo->IdGrupo)[1] == null)0
                                        @elseif($cantidades->contarEstudiantes($grupo->IdGrupo)[1] <>
                                            null) {{$cantidades->contarEstudiantes($grupo->IdGrupo)[1]}}@endif</td>
                                    <td><strong>{{ $cantidades->contarEstudiantes($grupo->IdGrupo)[0]+ $cantidades->contarEstudiantes($grupo->IdGrupo)[1]}}</strong>
                                    </td>
                                    <td>{{ $grupo->periodoActivo->NombrePeriodo }}</td>
                                    <td class="btn-group btn-group-sm">
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('cohortes.mostrarGrupo', [$nombreCohorte, $grupo->NombreGrupo]) }}">Agregar Estudiante</a>
                                        <a class="btn btn-outline-primary btn-sm"
                                            href="{{ route('cohortes.mostrarGrupo', [$nombreCohorte, $grupo->NombreGrupo]) }}">Visualizar grupo</a>
                                        <a class="btn btn-outline-info btn-sm"
                                            href="{{ route('grupos.show', $grupo) }}">Detalles grupo</a>
                                        <form method="POST" id="form-eliminar"
                                            action="{{ route('grupos.destroy', $grupo) }}">
                                            @csrf @method('DELETE')
                                            <a href="#" data-toggle="modal" data-target="#delete"
                                                class="btn btn-outline-danger btn-sm">Eliminar grupo</a>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@include('grupos.modals.create')
@include('grupos.modals.delete')
@endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    @foreach ($programas as $programa){
        $(document).ready(function() {
            $('#table_{{$programa->AcronimoProgramaEducativo}}').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
                }        
            });
        });
    }
    @endforeach
</script>
<script>
    $('#delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })

    $('#create').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
  
</script>

@endsection