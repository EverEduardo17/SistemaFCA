@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8">Participantes</h5>
      <a class="btn btn-primary col-4" href="{{ route('academicoEvento.create') }}" role="button">Añadir Participante</a>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Evento</th>
          <th>Participante</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($academicoEvento as $item)
        <tr>
          <td>{{ $item->evento->NombreEvento }}</td>
          <td>{{ $item->academico[0]->usuario->name }}</td>
          <td>
            <form method="POST" action="{{ route('academicoEvento.destroy', $item) }}">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection