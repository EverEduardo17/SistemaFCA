@extends('layouts.app')

@section('content')
  <div class="card">
    <div class="card-header row">
      <h5 class="card-title col-8">Editar Academia</h5>
      <a class="btn btn-primary col-4" href="{{ route('academias.index') }}" role="button">Ver Academias</a>
    </div>
    <div class="card-body">
      
      <form method="POST" action="{{ route('academias.update', $academia) }}" autocomplete="off">
        @csrf @method('PATCH')
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
              <option value="{{ $coordinador->IdAcademico }}" @if($academia->Coordinador == $coordinador->IdUsuario) selected @endif>{{ $coordinador->usuario->name }}</option>
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

      <hr>

      <form method="POST" action="{{ route('academias.destroy', $academia) }}">
        @csrf @method('DELETE')
          <button type="submit" class="btn btn-danger btn-block">¡Eliminar Permanentemente!</button>
      </form>

      <form action=""></form>

    </div>
  </div>
@endsection

@section('head')
    
@endsection

@section('script')

@endsection