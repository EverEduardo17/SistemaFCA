@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.show',$grupos) }}">{{$grupos->NombreGrupo}}-{{$grupos->cohorte->NombreCohorte}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Grupo</li>
  </ol>
</nav>
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8">Editar Grupo</h5>
      <a class="btn btn-outline-info col-4" href="{{ route('grupos.index') }}" role="button">Ver Grupos</a>
    </div>
  </div>
  <div class="card-body">

    <form method="POST" action="{{ route('grupos.update', $grupos) }}" autocomplete="off">
      @csrf @method('PATCH')
      @include('layouts.validaciones')
      <div class="form-group">
        <label name="NombreGrupo">Nombre del Grupo:</label>
        <input name="NombreGrupo" type="text" class="form-control @error('NombreGrupo') is-invalid @enderror" value="{{old('NombreGrupo',$grupos->NombreGrupo)}}" placeholder="Ej. LIS 701">
      </div>
      <div class="form-group">
        <label name="DescripcionGrupo">Descripción del Grupo:</label>
        <textarea name="DescripcionGrupo" type="text" class="form-control @error('DescripcionGrupo') is-invalid @enderror" value="{{old('DescripcionGrupo','$grupos->DescripcionGrupo')}}" placeholder="Ej. Grupo de LIS en 7mo semestre." rows="2">{{old('DescripcionGrupo',$grupos->DescripcionGrupo)}}</textarea>
      </div>
      <div class="form-group">
        <label name="TotalEstudiantesGrupo">Capacidad de Estudiantes:</label>
        <input name="TotalEstudiantesGrupo" type="number" class="form-control @error('TotalEstudiantesGrupo') is-invalid @enderror" step="1" value="{{old('TotalEstudiantesGrupo',$grupos->TotalEstudiantesGrupo)}}">
      </div>
      <div class="form-group">
        <label name="IdProgramaEducativo">Programa de pertenencia:</label>
        <select name="IdProgramaEducativo" class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
          @foreach ($programas as $programa)
          <option value="{{ $programa->IdProgramaEducativo }}" @if($programa->IdProgramaEducativo == $grupos->IdProgramaEducativo )selected @endif >{{ $programa->NombreProgramaEducativo }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label name="IdCohorte">Cohorte de pertenencia:</label>
        <select name="IdCohorte" class="form-control @error('IdCohorte') is-invalid @enderror">
          @foreach ($cohortes as $cohorte)
          <option value="{{ $cohorte->IdCohorte }}" @if($cohorte->IdCohorte == $grupos->IdCohorte )selected @endif > {{ $cohorte->NombreCohorte }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label name="IdPeriodoInicio">Periodo de inicio:</label>
        <select name="IdPeriodoInicio" class="form-control @error('IdPeriodoInicio') is-invalid @enderror">
          @foreach ($periodos as $periodo)
          <option value="{{ $periodo->IdPeriodo }}" @if($periodo->IdPeriodo == $grupos->IdPeriodoInicio )selected @endif >{{ $periodo->NombrePeriodo }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label name="IdPeriodoActivo">Último periodo activo:</label>
        <select name="IdPeriodoActivo" class="form-control @error('IdPeriodoActivo') is-invalid @enderror">
          @foreach ($periodos as $periodo)
          <option value="{{ $periodo->IdPeriodo }}" @if($periodo->IdPeriodo == $grupos->IdPeriodoActivo )selected @endif >{{ $periodo->NombrePeriodo }}</option>
          @endforeach
        </select>
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