@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$grupos->NombreGrupo}} - {{$grupos->cohorte->NombreCohorte}}</a></li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8"><strong>Detalles del grupo "{{$grupos->NombreGrupo}}" del cohorte "{{$grupos->cohorte->NombreCohorte}}"</strong></h5>
      <a class="btn btn-outline-info col-4" href="{{ route('estudiantesGrupo', $grupos->IdGrupo) }}" role="button">Ver Estudiantes</a>
    </div>
  </div>
  <div class="card-body">

    <div class="form-group">
      <label name="NombreGrupo">Nombre del grupo:</label>
      <input name="NombreGrupo" type="text" class="form-control @error('NombreGrupo') is-invalid @enderror" value="{{old('NombreGrupo',$grupos->NombreGrupo)}}" placeholder="Ej. LIS 701" disabled>
    </div>
    <div class="form-group">
      <label name="DescripcionGrupo">Descripción del grupo:</label>
      <textarea name="DescripcionGrupo" type="text" class="form-control @error('DescripcionGrupo') is-invalid @enderror" value="{{old('DescripcionGrupo','$grupos->DescripcionGrupo')}}" placeholder="<-- Sin descripción -->" rows="2" disabled>{{old('DescripcionGrupo',$grupos->DescripcionGrupo)}}</textarea>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label name="IdProgramaEducativo">Programa Educativo de pertenencia:</label>
          <input name="IdProgramaEducativo" type="text" class="form-control @error('IdProgramaEducativo') is-invalid @enderror" value="{{old('IdProgramaEducativo',$grupos->programaEducativo->NombreProgramaEducativo)}}" placeholder="Ej. LIS 701" disabled>
        </div>
        <div class="col">
          <label name="IdCohorte">Cohorte de pertenencia:</label>
          <input name="IdCohorte" type="text" class="form-control @error('IdCohorte') is-invalid @enderror" value="{{old('IdCohorte',$grupos->cohorte->NombreCohorte)}}" placeholder="Ej. LIS 701" disabled>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label name="EstudiantesActivos">Estudiantes activos del último periodo registrado:</label>
          <input name="EstudiantesActivos" type="text" class="form-control @error('EstudiantesActivos') is-invalid @enderror" @if($activos==0) value="Ninguno" @else value="{{old('EstudiantesActivos',$activos)}}" @endif disabled>
        </div>
        <div class="col">
          <label name="EstudiantesInactivos">Estudiantes inactivos del último periodo registrado:</label>
          <input name="EstudiantesInactivos" type="text" class="form-control @error('EstudiantesInactivos') is-invalid @enderror" @if($inactivos==0) value="Ninguno" @else value="{{old('EstudiantesInactivos',$inactivos)}}" @endif disabled>
        </div>

      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label name="IdPeriodoInicio">Periodo de inicio del grupo:</label>
          <input name="IdPeriodoInicio" type="text" class="form-control @error('IdPeriodoInicio') is-invalid @enderror" value="{{$grupos->periodoInicio->NombrePeriodo}}" disabled>
        </div>
        <div class="col">
          <label name="IdPeriodoActivo">Último periodo activo del grupo:</label>
          <input name="IdPeriodoActivo" type="text" class="form-control @error('IdPeriodoActivo') is-invalid @enderror" value="{{$grupos->periodoActivo->NombrePeriodo}}" disabled>
        </div>
      </div>
    </div>

    <br>
    <a href="{{ route('grupos.edit',$grupos) }}" class="btn btn-primary btn-block">Editar</a>
    <a href="{{ route('grupos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>

  </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection