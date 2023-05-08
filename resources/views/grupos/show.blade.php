@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$grupo->NombreGrupo}} - {{$grupo->cohorte->NombreCohorte}}</a></li>
  </ol>
</nav>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="card-title"><strong>Detalles del grupo "{{$grupo->NombreGrupo}}" del cohorte "{{$grupo->cohorte->NombreCohorte}}"</strong></h5>
      <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">Regresar</a>
      <a class="btn btn-secondary col-4" href="{{ route('grupos.index') }}" role="button">Ver Grupos</a>
    </div>
  </div>

  <div class="card-body">
    <div class="form-group">
      <label name="NombreGrupo">Nombre del grupo:</label>
      <input name="NombreGrupo" type="text" class="form-control @error('NombreGrupo') is-invalid @enderror" value="{{old('NombreGrupo',$grupo->NombreGrupo)}}" placeholder="Ej. LIS 701" disabled>
    </div>

    <div class="form-group" @if($grupo->DescripcionGrupo == null )style="display:none"@endif>
      <label name="DescripcionGrupo">Descripción del grupo:</label>
      <textarea name="DescripcionGrupo" type="text" class="form-control @error('DescripcionGrupo') is-invalid @enderror" value="{{old('DescripcionGrupo','$grupo->DescripcionGrupo')}}" placeholder="<-- Sin descripción -->" rows="2" disabled>{{old('DescripcionGrupo',$grupo->DescripcionGrupo)}}</textarea>
    </div>

    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label name="IdProgramaEducativo">Programa Educativo de pertenencia:</label>
          <input name="IdProgramaEducativo" type="text" class="form-control @error('IdProgramaEducativo') is-invalid @enderror" value="{{old('IdProgramaEducativo',$grupo->programaEducativo->NombreProgramaEducativo)}}" placeholder="Ej. LIS 701" disabled>
        </div>

        <div class="col">
          <label name="IdCohorte">Cohorte de pertenencia:</label>
          <input name="IdCohorte" type="text" class="form-control @error('IdCohorte') is-invalid @enderror" value="{{old('IdCohorte',$grupo->cohorte->NombreCohorte)}}" placeholder="Ej. LIS 701" disabled>
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
          <input name="IdPeriodoInicio" type="text" class="form-control @error('IdPeriodoInicio') is-invalid @enderror" value="{{$grupo->periodoInicio->NombrePeriodo}}" disabled>
        </div>

        <div class="col">
          <label name="IdPeriodoActivo">Último periodo activo del grupo:</label>
          <input name="IdPeriodoActivo" type="text" class="form-control @error('IdPeriodoActivo') is-invalid @enderror" value="{{$grupo->periodoActivo->NombrePeriodo}}" disabled>
        </div>
      </div>
    </div>

    <br>
    <a href="{{ route('grupos.edit',$grupo) }}" class="btn btn-primary btn-block">Editar</a>
    <a href="{{ route('grupos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>

  </div>
</div>
@endsection
