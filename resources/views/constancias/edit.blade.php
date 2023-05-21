@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{asset('lib/bootstrap3/css/bootstrap-mod.css')}}" />
    <link rel="stylesheet" href="{{asset('lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />

@endsection


@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">{{ $constancia->NombreConstancia }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar Constancia</li>
        <li class="descargar-plantilla col-12"> <a href="{{ route('constancias.downloadGenerica') }}"> Descargar Plantilla Generica </a></li>
    </ol>
</nav>
<div class="card shadow-sm">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Editar Constancia</h5>
            {{-- @can('havepermiso', 'academicos-listar') --}}
                <a class="btn btn-primary col-4" href="{{ route('constancias.index') }}" role="button">Ver Constancias</a>
            {{-- @endcan --}}
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('constancias.update', $constancia->IdConstancia) }}" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('layouts.validaciones')

            <div class="form-group">
                <label name="NombreConstancia">Nombre de la Constancia:</label>
                <input name="NombreConstancia" type="text" class="form-control @error('NombreConstancia') is-invalid @enderror" 
                value="{{ old('NombreDatosPersonales', $constancia->NombreConstancia) }}" placeholder="Ej. Constancia de Evento">
            </div>

            <div class="form-group">
                <label name="DescripcionConstancia">Descripción de la Constancia:</label>
                <input name="DescripcionConstancia" type="text" class="form-control @error('DescripcionConstancia') is-invalid @enderror" 
                value="{{ old('DescripcionConstancia', $constancia->DescripcionConstancia) }}" placeholder="Ej. Pino">
            </div>

            <div class="form-group">
                <label name="VigenteHasta">Vigente Hasta:</label>
                <input name="VigenteHasta" type="text" id="fecha" class="form-control @error('VigenteHasta') is-invalid @enderror" 
                value="{{ old('VigenteHasta', printDate($constancia->VigenteHasta)) }}" placeholder="Día/Mes/Año">
            </div>

            <div class=" form-group">
                <label name="Plantilla">Cambiar Plantilla en formato DOCX (Word):</label> <br>
                <input name="Plantilla" type="file" class="@error('Plantilla') form-control is-invalid @enderror"> <br>
                
                <a class="mi-plantilla"
                        href="{{ route('constancias.downloadMiPlantilla', [
                        'IdConstancia' => $constancia->IdConstancia, 
                        'NombreConstancia' => $constancia->NombreConstancia
                        ]) }}">
                    Descargar mi Plantilla
                </a>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
            
        </form>
        {{-- @can('havepermiso', 'academicos-listar') --}}
        <a href="javascript:history.back()" class="btn btn-secondary btn-block mt-2">Cancelar</a>
        {{-- @endcan --}}
    </div>
</div>
@endsection


@section('script')
    <script type="text/javascript" src="{{asset('lib/moment/min/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('#fecha').datetimepicker({
            locale: 'es',
            format: 'L'
        });
    </script>
@endsection
