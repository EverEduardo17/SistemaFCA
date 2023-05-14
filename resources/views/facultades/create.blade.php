@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('facultades.index') }}">Facultades</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agregar Facultad</li>
    </ol>
</nav>
<div class="card shadow-sm">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Agregar Facultad</h5>
            @can('havepermiso', 'facultades-listar')
                <a class="btn btn-primary col-4" href="{{ route('facultades.index') }}" role="button">Ver Facultades</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('facultades.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombreFacultad">Nombre de la Facultad:</label>
                <input name="NombreFacultad" type="text" class="form-control @error('NombreFacultad') is-invalid @enderror" value="{{ old('NombreFacultad') }}" placeholder="Ej. FCA Coatzacoalcos">
            </div>
            <div class="form-group">
                <label name="ClaveFacultad">Clave de la Facultad:</label>
                <input name="ClaveFacultad" value="{{ old('ClaveFacultad') }}" class="form-control @error('ClaveFacultad') is-invalid @enderror" maxlength="10" placeholder="Ej. 51301">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            @can('havepermiso', 'facultades-listar')
                <a href="{{ route('facultades.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
            @endcan
        </form>
    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection
