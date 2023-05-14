@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Gestión de Grupos</a></li>
    <li class="breadcrumb-item"><a
        href="{{ route('grupos.show',$grupos) }}">{{$grupos->NombreGrupo}}-{{$grupos->cohorte->NombreCohorte}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Grupo</li>
  </ol>
</nav>

<div class="card shadow-sm">
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="card-title">
        <strong>
          Editar al Grupo: "{{ $grupos->NombreGrupo }}" del cohorte "{{$grupos->cohorte->NombreCohorte}}"
        </strong>
      </h5>

      <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="javascript:history.back()" role="button">Regresar</a>
      <a class="btn btn-secondary col-4" href="{{ route('grupos.index') }}" role="button">Ver Grupos</a>
    </div>
  </div>
  <div class="card-body">

    <form method="POST" action="{{ route('grupos.update', $grupos) }}" autocomplete="off">
      @csrf 
      @method('PATCH')
      @include('layouts.validaciones')
      
      <input type="hidden" name="IdFacultad" value="{{$facultad}}">
      <input type="hidden" name="IdGrupo" value="{{$grupos->IdGrupo}}">
      <div class="form-group">
        <label name="NombreGrupo">Nombre del grupo:</label>
        <input name="NombreGrupo" type="text" class="form-control @error('NombreGrupo') is-invalid @enderror"
          value="{{old('NombreGrupo',$grupos->NombreGrupo)}}" placeholder="Ej. LIS 701">
      </div>
      <div class="form-group">
        <label name="DescripcionGrupo">Descripción del grupo:</label>
        <textarea name="DescripcionGrupo" type="text"
          class="form-control @error('DescripcionGrupo') is-invalid @enderror"
          value="{{old('DescripcionGrupo','$grupos->DescripcionGrupo')}}"
          placeholder="<-- Sin descripción -->"
          rows="2">{{old('DescripcionGrupo',$grupos->DescripcionGrupo)}}</textarea>
      </div>
      <div class="form-group">
        <label name="IdProgramaEducativo">Programa Educativo de pertenencia:</label>
        <select name="IdProgramaEducativo" class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
          @foreach ($programas as $programa)
          <option value="{{ $programa->IdProgramaEducativo }}" @if($programa->IdProgramaEducativo ==
            $grupos->IdProgramaEducativo )selected @endif >{{ $programa->NombreProgramaEducativo }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label name="IdCohorte">Cohorte de pertenencia:</label>
        <select name="IdCohorte" class="form-control @error('IdCohorte') is-invalid @enderror">
          @foreach ($cohortes as $cohorte)
          <option value="{{ $cohorte->IdCohorte }}" @if($cohorte->IdCohorte == $grupos->IdCohorte )selected @endif >
            {{ $cohorte->NombreCohorte }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col">
            <label name="IdPeriodoInicio">Periodo de inicio:</label>
            <select name="IdPeriodoInicio" class="form-control @error('IdPeriodoInicio') is-invalid @enderror">
              @foreach ($periodos as $periodo)
              <option value="{{ $periodo->IdPeriodo }}" @if($periodo->IdPeriodo == $grupos->IdPeriodoInicio )selected
                @endif >{{ $periodo->NombrePeriodo }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <label name="IdPeriodoActivo">Último periodo activo:</label>
            <select name="IdPeriodoActivo" class="form-control @error('IdPeriodoActivo') is-invalid @enderror">
              @foreach ($periodos as $periodo)
              <option value="{{ $periodo->IdPeriodo }}" @if($periodo->IdPeriodo == $grupos->IdPeriodoActivo )selected
                @endif >{{ $periodo->NombrePeriodo }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <br>
      <button type="submit" class="btn btn-primary btn-block">Guardar</button>
      
    </form>
    <a href="javascript:history.back()" class="btn btn-secondary btn-block mt-2">Cancelar</a>

  </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection