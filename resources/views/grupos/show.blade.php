@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$grupos->NombreGrupo}} - {{$grupos->cohorte->NombreCohorte}}</a></li>
  </ol>
</nav>
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8">{{$grupos->NombreGrupo}} - {{$grupos->cohorte->NombreCohorte}}</h5>
      <a class="btn btn-outline-info col-4" href="{{ route('estudiantesGrupo', $grupos->IdGrupo) }}" role="button">Ver Estudiantes</a>
    </div>
  </div>
  <div class="card-body">

    <div class="form-group">
      <label name="NombreGrupo">Nombre del Grupo:</label>
      <input name="NombreGrupo" type="text" class="form-control @error('NombreGrupo') is-invalid @enderror" value="{{old('NombreGrupo',$grupos->NombreGrupo)}}" placeholder="Ej. LIS 701" disabled>
    </div>
    <div class="form-group">
      <label name="DescripcionGrupo">Descripción del Grupo:</label>
      <textarea name="DescripcionGrupo" type="text" class="form-control @error('DescripcionGrupo') is-invalid @enderror" value="{{old('DescripcionGrupo','$grupos->DescripcionGrupo')}}" placeholder="Ej. Grupo de LIS en 7mo semestre." rows="2" disabled>{{old('DescripcionGrupo',$grupos->DescripcionGrupo)}}</textarea>
    </div>
    <div class="form-group">
      <label name="IdProgramaEducativo">Programa Educativo de pertenencia:</label>
      <input name="IdProgramaEducativo" type="text" class="form-control @error('IdProgramaEducativo') is-invalid @enderror" value="{{old('IdProgramaEducativo',$grupos->programaEducativo->NombreProgramaEducativo)}}" placeholder="Ej. LIS 701" disabled>
    </div>
    <div class="form-group">
      <label name="IdCohorte">Cohorte de pertenencia:</label>
      <input name="IdCohorte" type="text" class="form-control @error('IdCohorte') is-invalid @enderror" value="{{old('IdCohorte',$grupos->cohorte->NombreCohorte)}}" placeholder="Ej. LIS 701" disabled>
    </div>
    <div class="form-group">
      <label name="TotalEstudiantesGrupo">Capacidad de Estudiantes:</label>
      <input name="TotalEstudiantesGrupo" type="text" class="form-control @error('TotalEstudiantesGrupo') is-invalid @enderror" @if($grupos->TotalEstudiantesGrupo == null) value="Ninguno" @endif value="{{old('TotalEstudiantesGrupo',$grupos->TotalEstudiantesGrupo)}}" disabled>
    </div>
    <div class="form-group">
      <label name="EstudiantesActivos">Estudiantes Activos del último periodo:</label>
      <input name="EstudiantesActivos" type="text" class="form-control @error('EstudiantesActivos') is-invalid @enderror" @if($grupos->EstudiantesActivos == null) value="Ninguno" @endif value="{{old('EstudiantesActivos',$grupos->EstudiantesActivos)}}" disabled>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label name="EstudiantesInactivos">Estudiantes Inactivos del último periodo:</label>
          <input name="EstudiantesInactivos" type="text" class="form-control @error('EstudiantesInactivos') is-invalid @enderror" @if($grupos->EstudiantesInactivos == null) value="Ninguno" @endif value="{{old('EstudiantesInactivos',$grupos->EstudiantesInactivos)}}" disabled>
        </div>
        <div class="col">
          <label name="EstudiantesStandBy">Estudiantes StandBy del último periodo:</label>
          <input name="EstudiantesStandBy" type="text" class="form-control @error('EstudiantesStandBy') is-invalid @enderror" @if($grupos->EstudiantesStandBy == null) value="Ninguno" @endif value="{{old('EstudiantesStandBy',$grupos->EstudiantesStandBy)}}" disabled>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label name="IdPeriodoInicio">Periodo de inicio:</label>
          <input name="IdPeriodoInicio" type="text" class="form-control @error('IdPeriodoInicio') is-invalid @enderror" value="{{$grupos->periodoInicio->NombrePeriodo}}" disabled>
        </div>
        <div class="col">
          <label name="IdPeriodoActivo">Último periodo activo:</label>
          <input name="IdPeriodoActivo" type="text" class="form-control @error('IdPeriodoActivo') is-invalid @enderror" value="{{$grupos->periodoActivo->NombrePeriodo}}" disabled>
        </div>
      </div>
    </div>
    
    <br>
    <a href="{{ route('grupos.edit',$grupos) }}" class="btn btn-primary btn-block">Editar</a>
    <a href="{{ route('grupos.index') }}" class="btn btn-secondary btn-block">Ver Grupos</a>

  </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection