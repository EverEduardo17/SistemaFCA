@extends('layouts.app')

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <h5 class="card-title col-8">Crear Academia</h5>
        <a class="btn btn-primary col-4" href="{{ route('academias.index') }}" role="button">Ver Academias</a>
      </div>
    </div>
    <div class="card-body">
      
      <form method="POST" action="{{ route('academias.store') }}" autocomplete="off">
        @csrf
        @include('layouts.validaciones')
        <div class="form-group">
          <label name="NombreAcademia">Nombre de la Academia:</label>
          <input name="NombreAcademia" type="text" value="{{ old('NombreAcademia', $academia->NombreAcademia) }}" class="form-control @error('NombreAcademia') is-invalid @enderror">
          <small class="form-text text-muted">El nombre puede cambiar despues.</small>
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
          <label name="DescripcionAcademia">Descripcion de la Academia</label>
          <textarea name="DescripcionAcademia" class="form-control @error('DescripcionAcademia') is-invalid @enderror" rows="3">{{ old('DescripcionAcademia', $academia->DescripcionAcademia) }}</textarea>
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
