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
    <h1>ss</h1>
</div>

@endsection