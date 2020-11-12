@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8">Editar Sede</h5>
      <a class="btn btn-primary col-4" href="{{ route('sedeEventos.index') }}" role="button">Ver Sedes</a>
    </div>
  </div>
  <div class="card-body">

    <form method="POST" action="{{ route('sedeEventos.update', $sede) }}" autocomplete="off">
      @csrf @method('PATCH')
      @include('layouts.validaciones')
      <div class="form-group">
        <label name="NombreSedeEvento">Nombre de la Facultad:</label>
        <input name="NombreSedeEvento" type="text" value="{{ old('NombreSedeEvento', $sede->NombreSedeEvento) }}" class="form-control @error('NombreSedeEvento') is-invalid @enderror">
      </div>
      <div class="form-group">
        <label name="DescripcionSedeEvento">Clave de la Facultad:</label>
        <input name="DescripcionSedeEvento" class="form-control @error('DescripcionSedeEvento') is-invalid @enderror" value="{{ old('DescripcionSedeEvento', $sede->DescripcionSedeEvento) }}">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Guardar</button>
      <a href="{{ route('sedeEventos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
    </form>

    <hr>

    <form method="POST" id="form-eliminar" action="{{ route('sedeEventos.destroy', $sede) }}">
      @csrf @method('DELETE')
        <a href="#"  data-toggle="modal" data-target="#delete" class="btn btn-danger btn-block">¡Eliminar Permanentemente!</a>
    </form>

  </div>
</div>

@include('sedeEvento.modals.delete')
@endsection

@section('head')

@endsection

@section('script')
    <script>
        $('#delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        })
    </script>
@endsection
