@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Agregar Grupo</li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8"><strong>Agregar Grupo</strong></h5>
      <a class="btn btn-secondary col-4" href="{{ route('grupos.index') }}" role="button">Ver Grupos</a>
    </div>
  </div>
  <div class="card-body">

    <form method="POST" action="{{ route('grupos.store') }}" autocomplete="off">
      @csrf
      @include('layouts.validaciones')
      <input type="hidden" name="IdFacultad" value="{{$facultad}}">
      <div class="form-group">
        <label name="NombreGrupo">Nombre del grupo:</label>
        <input name="NombreGrupo" type="text" class="form-control @error('NombreGrupo') is-invalid @enderror"
          value="{{old('NombreGrupo')}}" placeholder="Ej. LIS 701">
      </div>
      <div class="form-group">
        <label name="DescripcionGrupo">Descripción del grupo:</label>
        <textarea name="DescripcionGrupo" type="text"
          class="form-control @error('DescripcionGrupo') is-invalid @enderror" value="{{old('DescripcionGrupo')}}"
          placeholder="Ej. Grupo de LIS en 7mo semestre." rows="2">{{old('DescripcionGrupo')}}</textarea>
      </div>
      <div class="form-group">
        <label name="IdProgramaEducativo">Programa Educativo de pertenencia:</label>
        <select name="IdProgramaEducativo" class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
          <option></option>
          @foreach ($programas as $programa)
            <option value="{{ $programa->IdProgramaEducativo }}">{{ $programa->NombreProgramaEducativo }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label name="IdCohorte">Cohorte de pertenencia:</label>
        <select name="IdCohorte" class="form-control @error('IdCohorte') is-invalid @enderror">
          @foreach ($cohortes as $cohorte)
          <option value="{{ $cohorte->IdCohorte }}" {{   (old('IdCohorte') == $cohorte->IdCohorte ) ? "selected = selected":"" }}> {{ $cohorte->NombreCohorte }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col">
            <label name="IdPeriodoInicio">Periodo de inicio del grupo:</label>
            <select name="IdPeriodoInicio" class="form-control @error('IdPeriodoInicio') is-invalid @enderror">
              @foreach ($periodos as $periodo)
              <option value="{{$periodo->IdPeriodo }} @if(old('IdPeriodo') == $periodo->IdPeriodo )selected = selected @endif">{{ $periodo->NombrePeriodo }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <label name="IdPeriodoActivo">Último periodo activo del grupo:</label>
            <select name="IdPeriodoActivo" class="form-control @error('IdPeriodoActivo') is-invalid @enderror">
              @foreach ($periodos as $periodo)
              <option value="{{ $periodo->IdPeriodo }}  @if(old('IdPeriodo') == $periodo->IdPeriodo )selected @endif ">{{ $periodo->NombrePeriodo }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <br>
      <button type="submit" class="btn btn-primary btn-block">Guardar</button>
      <a href="{{ route('grupos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
    </form>

  </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection