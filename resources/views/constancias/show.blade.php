@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $constancia->NombreConstancia }}</a></li>
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
        <div class="row">
            <h5 class="card-title col-8">Estudiantes</h5>
            {{-- @can('havepermiso', 'estudiante-ver-cualquiera') --}}
                <a class="btn btn-primary col-4" href="/grupos" role="button">Gestión de Estudiantes</a>
            {{-- @endcan --}}
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover" id="table_Programa">
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
                    <tr>
                        <th scope="row" class="border-right">{{ $estudiante->MatriculaEstudiante }}</th>

                        <td class="border-right">
                            {{ $estudiante->Usuario->DatosPersonales->ApellidoPaternoDatosPersonales }}
                            {{ $estudiante->Usuario->DatosPersonales->ApellidoMaternoDatosPersonales }}
                            {{ $estudiante->Usuario->DatosPersonales->NombreDatosPersonales }}
                        </td>

                        <td class="border-right">{{ $estudiante->Trayectoria->Grupo->NombreGrupo }}</td>

                        <td class="py-2">
                            <a class="btn btn-sm btn-outline-success" href="{{ route('constancias.show', $estudiante->IdEstudiante) }}" data-toggle="tooltip" data-placement="bottom" title="Detalles"><em class="fas fa-eye"></em></a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('constancias.edit', $estudiante->IdEstudiante) }}" data-toggle="tooltip" data-placement="bottom" title="Editar"><em class="fas fa-pencil-alt"></em></a>
                            <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#delete" data-documento="{{ $estudiante->IdEstudiante }}" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><em class="fas fa-trash-alt"></em></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection