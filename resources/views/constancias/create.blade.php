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
        <li class="breadcrumb-item active" aria-current="page">Agregar Constancia</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Agregar Constancia</h5>
            {{-- @can('havepermiso', 'academicos-listar') --}}
                <a class="btn btn-primary col-4" href="{{ route('constancias.index') }}" role="button">Ver Constancias</a>
            {{-- @endcan --}}
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('constancias.store') }}" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombreConstancia">Nombre de la Constancia:</label>
                <input name="NombreConstancia" value="{{ old('NombreConstancia') }}" type="text" class="form-control @error('NombreConstancia') is-invalid @enderror" placeholder="Ej. Constancia de Evento">
                </div>
                <div class=" form-group">
                <label name="DescripcionConstancia">Descripción de la Constancia:</label>
                <input name="DescripcionConstancia" value="{{ old('DescripcionConstancia') }}" type="text" class="form-control @error('DescripcionConstancia') is-invalid @enderror" placeholder="Ej. Detalles">
                </div>
                <div class=" form-group">
                <label name="VigenteHasta">Vigente Hasta:</label>
                <input name="VigenteHasta" id="fecha" value="{{ old('VigenteHasta') }}" type="text" class="form-control @error('VigenteHasta') is-invalid @enderror" placeholder="Día/Mes/Año">
                </div>
                <div class=" form-group">
                    <label name="Plantilla">Subir plantilla en formato DOCX (Word):</label> <br>
                    <input name="Plantilla" value="Subir Archivo" type="file" class="@error('Plantilla') is-invalid @enderror">
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            {{-- @can('havepermiso', 'academicos-listar') --}}
                <a href="{{ route('academicos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
            {{-- @endcan --}}
        </form>
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