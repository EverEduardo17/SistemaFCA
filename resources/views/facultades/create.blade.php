@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header row">
    <h5 class="card-title col-8">Crear Facultad</h5>
    <a class="btn btn-primary col-4" href="{{ route('facultades.index') }}" role="button">Ver Facultades</a>
  </div>
  <div class="card-body">

    <form method="POST" action="{{ route('facultades.store') }}" autocomplete="off">
      @csrf
      @include('layouts.validaciones')
      <div class="form-group">
        <label name="NombreFacultad">Nombre de la Facultad:</label>
        <input name="NombreFacultad" type="text" class="form-control @error('NombreFacultad') is-invalid @enderror">
      </div>
      <div class="form-group">
        <label name="ClaveFacultad">Clave de la Facultad:</label>
        <input name="ClaveFacultad" class="form-control @error('ClaveFacultad') is-invalid @enderror" maxlength="10"></input>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Guardar</button>
      <a href="{{ route('facultades.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
    </form>

  </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection