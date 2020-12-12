@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('academias.index') }}">Academias</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agregar Academia</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Agregar Academia</h5>
            @can('havepermiso', 'academias-listar')
                <a class="btn btn-primary col-4" href="{{ route('academias.index') }}" role="button">Ver Academias</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('academias.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombreAcademia">Nombre de la Academia:</label>
                <input name="NombreAcademia" type="text" value="{{ old('NombreAcademia', $academia->NombreAcademia) }}" class="form-control @error('NombreAcademia') is-invalid @enderror" placeholder="Ej. Academia de Informática.">

            </div>
            <div class="form-group">
                <label name="Coordinador">Docente Coordinador:</label>
                <select name="Coordinador" class="form-control @error('Coordinador') is-invalid @enderror">
                    @foreach ($coordinadores as $coordinador)
                    <option value="{{ $coordinador->IdAcademico }}">{{ $coordinador->usuario->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label name="DescripcionAcademia">Descripción de la Academia:</label>
                <textarea name="DescripcionAcademia" class="form-control @error('DescripcionAcademia') is-invalid @enderror" rows="3" placeholder="Ej. Academia de Informática de la FCA Coatzacoalcos.">{{ old('DescripcionAcademia', $academia->DescripcionAcademia) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            <a href="{{ route('academias.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
        </form>
    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection
