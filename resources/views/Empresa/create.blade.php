@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('empresas.index') }}">Gestión de Empresas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Agregar Empresa</li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8"><strong>Agregar Empresa</strong></h5>
      <a class="btn btn-outline-info col-4" href="{{ route('empresas.index') }}" role="button">Ver Empresas</a>
    </div>
  </div>
  <div class="card-body">

    <form method="POST" action="{{ route('empresas.store') }}" autocomplete="off">
      @csrf
      @include('layouts.validaciones')
      <div class="form-group">
        <label name="NombreEmpresa">Nombre de la empresa:</label>
        <input name="NombreEmpresa" type="text" class="form-control @error('NombreEmpresa') is-invalid @enderror" value="{{old('NombreEmpresa')}}" placeholder="Ej. Universidad Veracruzana: Coordinación de Proyectos de Desarrollo">
      </div>
      <div class="form-group">
        <label name="DireccionEmpresa">Dirección de la empresa:</label>
        <input name="DireccionEmpresa" type="text" class="form-control @error('DireccionEmpresa') is-invalid @enderror" value="{{old('DireccionEmpresa')}}" placeholder="Ej. Av. Universidad Km 7.5">
      </div>
      <div class="form-group">
        <label name="LocalidadEmpresa">Localidad de residencia de la empresa:</label>
        <input name="LocalidadEmpresa" type="text" class="form-control @error('LocalidadEmpresa') is-invalid @enderror" value="{{old('LocalidadEmpresa')}}" placeholder="Ej. Coatzacoalcos">
      </div>
      <div class="form-group">
        <label name="TelefonoEmpresa">Teléfono de la empresa:</label>
        <input name="TelefonoEmpresa" type="text" class="form-control @error('TelefonoEmpresa') is-invalid @enderror" value="{{old('TelefonoEmpresa')}}" placeholder="Ej. 9212115700 ext 55714" maxlength="25">
      </div>
      <div class="form-group">
        <label name="ResponsableEmpresa">Responsable de la empresa:</label>
        <input name="ResponsableEmpresa" type="text" class="form-control @error('ResponsableEmpresa') is-invalid @enderror" value="{{old('ResponsableEmpresa')}}" placeholder="Ej. Javier Pino Herrera">
      </div>
      <div class="form-group">
        <label name="TipoEmpresa">Sector al que pertenece:</label>
        <select name="TipoEmpresa" class="form-control @error('TipoEmpresa') is-invalid @enderror">
          <option value="Privado">Privado</option>
          <option value="Público">Público</option>
          <option value="Social">Social</option>
          <option value="UV">UV</option>
        </select>
      </div>
      <div class="form-group">
        <label name="ActividadEmpresa">Actividad de la empresa:</label>
        <select name="ActividadEmpresa" class="form-control @error('ActividadEmpresa') is-invalid @enderror">
          <option value="Comercial">Comercial</option>
          <option value="Industrial">Industrial</option>
          <option value="Servicios">Servicios</option>
        </select>
      </div>
      <div class="form-group">
        <label name="ClasificacionEmpresa">Tamaño de la empresa:</label>
        <select name="ClasificacionEmpresa" class="form-control @error('ClasificacionEmpresa') is-invalid @enderror">
          <option value="Micro">Micro</option>
          <option value="Pequeña">Pequeña</option>
          <option value="Mediana">Mediana</option>
          <option value="Grande">Grande</option>
        </select>
      </div>

      <br>
      <button type="submit" class="btn btn-primary btn-block">Guardar</button>
      <a href="{{ route('empresas.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
    </form>

  </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection