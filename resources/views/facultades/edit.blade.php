@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('facultades.index') }}">Facultades</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar Facultad</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Editar Facultad</h5>
            <a class="btn btn-primary col-4" href="{{ route('facultades.index') }}" role="button">Ver Facultades</a>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('facultades.update', $facultad) }}" autocomplete="off">
            @csrf
            @method('PATCH')
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombreFacultad">Nombre de la Facultad:</label>
                <input name="NombreFacultad" type="text" value="{{ old('NombreFacultad', $facultad->NombreFacultad) }}" class="form-control @error('NombreFacultad') is-invalid @enderror" placeholder="Ej. FCA Coatzacoalcos">
            </div>
            <div class="form-group">
                <label name="ClaveFacultad">Clave de la Facultad:</label>
                <input name="ClaveFacultad" class="form-control @error('ClaveFacultad') is-invalid @enderror" value="{{ old('ClaveFacultad', $facultad->ClaveFacultad) }}" maxlength="10" placeholder="Ej. 51301">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            <a href="{{ route('facultades.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
        </form>
        <hr>
        <form method="POST" id="form-eliminar" action="{{ route('facultades.destroy', $facultad) }}">
            @csrf
            @method('DELETE')
            <a href="#" href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-block">Eliminar Permanentemente</a>
        </form>
    </div>
</div>
@include('facultades.modals.delete')
@endsection

@section('head')

@endsection

@section('script')
<script>
    $('#delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    })
</script>
@endsection