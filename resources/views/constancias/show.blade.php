@extends('layouts.app')

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $constancia->NombreConstancia }}</li>
        <li class="descargar-plantilla col-12"> <a href="{{ route('constancias.downloadGenerica', $constancia->IdConstancia) }}"> Descargar Plantilla Generica </a></li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Detalles de la Constancia</h5>
            {{-- @can('havepermiso', 'academicos-listar') --}}
                <a class="btn btn-primary col-4" href="{{ route('constancias.index') }}" role="button">Ver Constancias</a>
            {{-- @endcan --}}
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('constancias.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')

            <div class="form-group">
                <label name="NombreConstancia">Nombre de la Constancia:</label>
                <input name="NombreConstancia" type="text" class="form-control @error('NombreConstancia') is-invalid @enderror" value="{{ old('NombreConstancia', $constancia->NombreConstancia) }}" disabled>
            </div>

            <div class="form-group">
                <label name="DescripcionConstancia">Descripción de la Constancia:</label>
                <input name="DescripcionConstancia" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" value="{{ old('DescripcionConstancia', $constancia->DescripcionConstancia) }}" disabled>
            </div>

            <div class="form-group">
                <label name="VigenteHasta">Vigente Hasta:</label>
                <input name="VigenteHasta" type="text" class="form-control @error('VigenteHasta') is-invalid @enderror" value="{{ old('VigenteHasta', printDate($constancia->VigenteHasta)) }}" disabled>
            </div>

            <a class="mi-plantilla" 
                href="{{ route('constancias.download', [
                    'IdConstancia' => $constancia->IdConstancia, 
                    'NombreConstancia' => $constancia->NombreConstancia
                    ]) }}">

                Descargar mi Plantilla
            </a>

            <hr>
            <a href="{{ route('constancias.edit', $constancia) }}" class="btn btn-primary btn-block">Editar </a>
        </form>
    </div>
</div> 

<br> <br>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Estudiantes</h5>
            {{-- @can('havepermiso', 'estudiante-ver-cualquiera') --}}
                <a class="btn btn-primary col-3 ml-auto mr-4" href="{{ route('estudiantes.index') }}" role="button">Gestión de Estudiantes</a>
            {{-- @endcan --}}
            <a class="btn btn-success col-3" href="{{ route('constancias.indexGrupos', $constancia) }}" role="button">Agregar Estudiantes</a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover" id="table_Constancia">
                <caption>Estudiantes que participaron en el evento.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border-right">Matrícula</th>
                        <th scope="col" class="border-right">Nombre</th>
                        <th scope="col" class="border-right">Grupo</th>
                        <th scope="col" class="border-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estudiantes as $estudiante)
                    <tr id="fila-{{ $estudiante->IdEstudiante }}">
                        <th scope="row" class="border-right">{{ $estudiante->MatriculaEstudiante }}</th>

                        <td class="border-right">
                            {{ $estudiante->Usuario->DatosPersonales->ApellidoPaternoDatosPersonales }}
                            {{ $estudiante->Usuario->DatosPersonales->ApellidoMaternoDatosPersonales }}
                            {{ $estudiante->Usuario->DatosPersonales->NombreDatosPersonales }}
                        </td>

                        <td class="border-right">{{ $estudiante->Trayectoria->Grupo->NombreGrupo }}</td>

                        <td class="py-2">
                            <a class="btn btn-sm btn-outline-success" href="{{ route('constancias.showEstudiante', ['constancia' => $constancia->IdConstancia, 'estudiante' => $estudiante->IdEstudiante]) }}" data-toggle="tooltip" data-placement="bottom" title="Detalles">
                                <em class="fas fa-eye"></em>
                            </a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('constancias.generar', ['constancia' => $constancia, 'estudiante' => $estudiante]) }}" data-toggle="tooltip" data-placement="bottom" title="Descargar PDF">
                                <em class="fas fa-file-pdf"></em>
                            </a>
                            <a class="btn btn-sm btn-outline-danger btn-constancia" href="#" data-url="{{ route('constancias.destroyEstudiante', ['constancia' => $constancia->IdConstancia, 'estudiante' => $estudiante->IdEstudiante]) }}" data-method="delete" title="Quitar">
                                <em class="fas fa-trash-alt"></em>
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
        $('#table_Constancia').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
            }

        });
    });


    $(document).on('click', '.btn-constancia', function (e) {
        e.preventDefault();

        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var idEstudiante = url.split('/').pop();

        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
                '_token': token
            },
            success: function (data) {
                console.log('Eliminado exitosamente');
                var filaEstudiante = $('#fila-' + idEstudiante);
                filaEstudiante.closest('tr').remove();
            },
            error: function (data) {
                console.log('Ocurrió un error al eliminar');
            }
        });
    });

</script>    
@endsection