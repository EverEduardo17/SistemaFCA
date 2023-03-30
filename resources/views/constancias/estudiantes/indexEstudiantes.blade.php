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
        <li class="breadcrumb-item"><a href="{{ route('constancias.indexGrupos', $constancia) }}">Elegir Grupo</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $grupo->NombreGrupo }} - {{ $cohorte->NombreCohorte }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title"><strong> Estudiantes del grupo "{{$grupo->NombreGrupo}}" del cohorte
                "{{$cohorte->NombreCohorte}}"</strong></h5>
                <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">Regresar</a>
                <a class="btn btn-success col-4" href="{{ route('constancias.show', $constancia->IdConstancia) }}" role="button">Ver Constancia</a>
        </div>
    </div>

    <div class="card-body">
        @csrf @method('PATCH')
        @include('layouts.validaciones')

        <hr>

        <div class="table-responsive-xl">

        <table class="table table-striped table-hover" id="table_estudiante">
            <caption>Estudiantes registrados en el sistema para el grupo {{$grupo->NombreGrupo}} del cohorte {{$cohorte->NombreCohorte}}.</caption>

            <thead class="bg-table">
            <tr class="text-white">
                <th scope="col" class="border-right">Matrícula</th>
                <th scope="col" class="border-right">Nombre</th>
                <th scope="col" class="border-right">Género</th>
                <th scope="col" class="border-right">Modalidad de entrada</th>
                <th scope="col" class="border-right">Acciones</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($estudiantes as $estudiante)
                <tr>
                    <th scope="row" class="border-right">{{$estudiante->estudiante->MatriculaEstudiante}}</th>
                    <td class="border-right">
                        {{$estudiante->datosPersonales->ApellidoPaternoDatosPersonales}}
                        {{$estudiante->datosPersonales->ApellidoMaternoDatosPersonales}}
                        {{ $estudiante->datosPersonales->NombreDatosPersonales }} 
                    </td>
                    <td class="border-right">{{$estudiante->datosPersonales->Genero}}</td>
                    <td class="border-right">{{$estudiante->modalidad->NombreModalidad}}</td>

                    <td class="btn-group btn-group-sm">
                        <a href="#" data-estudiante="{{ $estudiante->IdEstudiante }}" class="btn btn-constancia
                            @if (($estudiante->estudiante)->constancias()->where('Constancia.IdConstancia', $constancia->IdConstancia)->exists())
                                btn btn-danger btn-sm">
                                    Eliminar
                            @else
                                btn-success btn-sm">
                                    Agregar
                            @endif
                        </a>
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
    $('#table_estudiante').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
      }
    });
  });
</script>

{{-- botones reactivos en Acciones --}}
<script>
    $(document).ready(function() {
        $('.btn-constancia').on('click', function(e) {
            e.preventDefault();
            var idEstudiante = $(this).data('estudiante');
            var url = '{{ route("constancias.addEstudiante") }}';
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    idEstudiante: idEstudiante,
                    idConstancia: '{{ $constancia->IdConstancia }}'
                },
                success: function(data) {
                    if (data.success) {
                        $('.btn-constancia[data-estudiante="' + idEstudiante + '"]')
                            .removeClass('btn-success')
                            .addClass('btn-danger')
                            .text('Eliminar');
                    } else {
                        $('.btn-constancia[data-estudiante="' + idEstudiante + '"]')
                            .removeClass('btn-danger')
                            .addClass('btn-success')
                            .text('Agregar');
                    }
                }
            });
        });
    });
</script>
    
@endsection