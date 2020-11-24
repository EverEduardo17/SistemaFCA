@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sedeEventos.index') }}">Sedes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Agregar Sede</li>
  </ol>
</nav>
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8">Agregar Sede</h5>
      <a class="btn btn-primary col-4" href="{{ route('sedeEventos.index') }}" role="button">Ver Sedes</a>
    </div>
  </div>
  <div class="card-body">

    <form method="POST" action="{{ route('sedeEventos.store') }}" autocomplete="off">
      @csrf
      @include('layouts.validaciones')
      <div class="form-group">
        <label name="NombreSedeEvento">Nombre de la Sede:</label>
        <input name="NombreSedeEvento" type="text" class="form-control @error('NombreSedeEvento') is-invalid @enderror" placeholder="Ej. LABLIS">
      </div>
      <div class="form-group">
        <label name="DescripcionSedeEvento">Descripción de la sede:</label>
        <input name="DescripcionSedeEvento" class="form-control @error('DescripcionSedeEvento') is-invalid @enderror" placeholder="Ej. Centro de cómputo de LIS">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Guardar</button>
      <a href="{{ route('sedeEventos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
    </form>

  </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection