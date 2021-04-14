@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('programaEducativo.index') }}">Gestión de Programas Educativos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Programa Educativo</li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8"><strong>Editar Programa Educativo</strong></h5>
      <a class="btn btn-secondary col-4" href="{{ route('programaEducativo.index') }}" role="button">Ver Programas Educativos</a>
    </div>
  </div>

  <div class="card-body">
    <form method="POST" action="{{ route('programaEducativo.update', $programas) }}" autocomplete="off">
      @csrf @method('PATCH')
      @include('layouts.validaciones')
      <div class="form-group">
        <label name="NombreProgramaEducativo">Nombre del Programa Educativo:</label>
        <input name="NombreProgramaEducativo" type="text" class="form-control @error('NombreProgramaEducativo') is-invalid @enderror" value="{{old('NombreProgramaEducativo', $programas->NombreProgramaEducativo)}}" placeholder="Ej. Licenciatura en Ingeniería de Software">
      </div>
      <div class="form-group">
        <label name="AcronimoProgramaEducativo">Acrónimo del Programa Educativo:</label>
        <input name="AcronimoProgramaEducativo" class="form-control @error('AcronimoProgramaEducativo') is-invalid @enderror" value="{{old('AcronimoProgramaEducativo', $programas->AcronimoProgramaEducativo)}}" placeholder="Ej. LIS">
      </div>
      <div class="form-group">
        <label name="IdFacultad">Facultad de procedencia:</label>
        <input name="NombreFacultad" class="form-control @error('NombreFacultad') is-invalid @enderror" value="{{old('$programas->facultad->IdFacultad', $facultad[0]->NombreFacultad)}}" placeholder="Ej. Facultad de Contaduría y Administración" disabled>
        <input type="hidden" name="IdFacultad" class="form-control @error('IdFacultad') is-invalid @enderror" value="{{$facultad[0]->IdFacultad}}">
      </div>
      <br>
      <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
      <a href="{{ route('programaEducativo.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
    </form>
  </div>
</div>
@include('programaEducativo.modals.delete')
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