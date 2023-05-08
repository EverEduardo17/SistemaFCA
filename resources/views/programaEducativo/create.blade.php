@extends('layouts.app')


@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('programaEducativo.index') }}">Gestión de Programas Educativos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Agregar Programa Educativo</li>
  </ol>
</nav>

<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8"><strong>Agregar Programa Educativo</strong></h5>
      <a class="btn btn-secondary col-4" href="{{ route('programaEducativo.index') }}" role="button">Ver Programas Educativos</a>
    </div>
  </div>
  <div class="card-body">

    <form method="POST" action="{{ route('programaEducativo.store') }}" autocomplete="off">
      @csrf
      @include('layouts.validaciones')
      <div class="form-group">
        <label name="NombreProgramaEducativo">Nombre del Programa Educativo:</label>
        <input name="NombreProgramaEducativo" type="text" class="form-control @error('NombreProgramaEducativo') is-invalid @enderror" value="{{old('NombreProgramaEducativo')}}" placeholder="Ej. Licenciatura en Ingeniería de Software" autofocus>
      </div>
      <div class="form-group">
        <label name="AcronimoProgramaEducativo">Acrónimo del Programa Educativo:</label>
        <input name="AcronimoProgramaEducativo" class="form-control @error('AcronimoProgramaEducativo') is-invalid @enderror" value="{{old('AcronimoProgramaEducativo')}}" placeholder="Ej. LIS">
      </div>
      <div class="form-group">
        <label name="IdFacultad">Facultad de pertenencia:</label>
        <input name="NombreFacultad" class="form-control @error('NombreFacultad') is-invalid @enderror" value="{{$facultad[0]->NombreFacultad}}" placeholder="Ej. Facultad de Contaduría y Administración" disabled>
        <input type="hidden" name="IdFacultad" class="form-control @error('IdFacultad') is-invalid @enderror" value="{{$facultad[0]->IdFacultad}}">
      </div>

      <br>
      <button type="submit" class="btn btn-primary btn-block">Guardar</button>
      <a href="{{ route('programaEducativo.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
    </form>

  </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection