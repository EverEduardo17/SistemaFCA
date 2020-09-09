@extends('layouts.app')

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <h5 class="card-title col-8">Academias</h5>
        <a class="btn btn-primary col-4" href="{{ route('academias.create') }}" role="button">Añadir Academia</a>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Coordinador</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($academias as $item)
            <tr>
              <th>{{ $item->NombreAcademia }}</th>
              <td>{{ $item->DescripcionAcademia }}</td>
              <td>{{ $item->coordinador->usuario->name }}</td>
              <td>
                <a class="btn btn-primary btn-sm" href="{{ route('academias.edit', $item) }}">Editar</a>
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
