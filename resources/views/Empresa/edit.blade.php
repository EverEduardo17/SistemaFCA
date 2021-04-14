@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('empresas.index') }}">Gestión de Empresas</a></li>
    <li class="breadcrumb-item"><a href="{{ route('empresas.show', $empresa->IdEmpresa) }}">{{$empresa->NombreEmpresa}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Empresa</li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <div class="row">
      <h5 class="card-title col-8"><strong>Editar Empresa</strong></h5>
      <a class="btn btn-secondary col-4" href="{{ route('empresas.index') }}" role="button">Ver Empresas</a>
    </div>
  </div>

  <div class="card-body">
    <form method="POST" action="{{ route('empresas.update', $empresa) }}" autocomplete="off">
      @csrf @method('PATCH')
      @include('layouts.validaciones')
      <div class="form-group">
        <label for="NombreEmpresa">Nombre de la empresa:</label>
        <input name="NombreEmpresa" type="text" class="form-control @error('NombreEmpresa') is-invalid @enderror" 
        value="{{old('NombreEmpresa', $empresa->NombreEmpresa)}}" placeholder="Ej. Universidad Veracruzana: Coordinación de Proyectos de Desarrollo"
        id="NombreEmpresa">
      </div>
      <div class="form-group">
        <label for="DireccionEmpresa">Dirección de la empresa:</label>
        <input name="DireccionEmpresa" type="text" class="form-control @error('DireccionEmpresa') is-invalid @enderror" 
        value="{{old('DireccionEmpresa', $empresa->DireccionEmpresa)}}" placeholder="Ej. Av. Universidad Km 7.5"
        id="DireccionEmpresa">
      </div>
      <div class="form-group">
        <label for="LocalidadEmpresa">Localidad de residencia de la empresa:</label>
        <input name="LocalidadEmpresa" type="text" class="form-control @error('LocalidadEmpresa') is-invalid @enderror" 
        value="{{old('LocalidadEmpresa', $empresa->LocalidadEmpresa)}}" placeholder="Ej. Coatzacoalcos"
        id="LocalidadEmpresa">
      </div>
      <div class="form-group">
        <label for="TelefonoEmpresa">Teléfono de la empresa:</label>
        <input name="TelefonoEmpresa" type="text" class="form-control @error('TelefonoEmpresa') is-invalid @enderror" 
        value="{{old('TelefonoEmpresa', $empresa->TelefonoEmpresa)}}" placeholder="Ej. 9212115700 ext 55714" maxlength="25"
        id="TelefonoEmpresa">
      </div>
      <div class="form-group">
        <label for="ResponsableEmpresa">Responsable de la empresa:</label>
        <input name="ResponsableEmpresa" type="text" class="form-control @error('ResponsableEmpresa') is-invalid @enderror" 
        value="{{old('ResponsableEmpresa', $empresa->ResponsableEmpresa)}}" placeholder="Ej. Javier Pino Herrera"
        id="ResponsableEmpresa">
      </div>
      <div class="form-group">
        <label for="TipoEmpresa">Sector al que pertenece:</label>
        <select name="TipoEmpresa" class="form-control @error('TipoEmpresa') is-invalid @enderror" id="TipoEmpresa">
          <option value="Privado" @if('Privado' == $empresa->TipoEmpresa)selected @endif >Privado</option>
          <option value="Público" @if('Público' == $empresa->TipoEmpresa)selected @endif >Público</option>
          <option value="Social" @if('Social' == $empresa->TipoEmpresa)selected @endif >Social</option>
          <option value="UV" @if('UV' == $empresa->TipoEmpresa)selected @endif >UV</option>
        </select>
      </div>
      <div class="form-group">
        <label for="ActividadEmpresa">Actividad de la empresa:</label>
        <select name="ActividadEmpresa" class="form-control @error('ActividadEmpresa') is-invalid @enderror" id="ActividadEmpresa">
          <option value="Comercial" @if('Comercial'== $empresa->ActividadEmpresa)selected @endif >Comercial</option>
          <option value="Industrial" @if('Industrial'== $empresa->ActividadEmpresa)selected @endif>Industrial</option>
          <option value="Servicios" @if('Servicios'== $empresa->ActividadEmpresa)selected @endif >Servicios</option>
        </select>
      </div>
      <div class="form-group">
        <label for="ClasificacionEmpresa">Tamaño de la empresa:</label>
        <select name="ClasificacionEmpresa" class="form-control @error('ClasificacionEmpresa') is-invalid @enderror" id="ClasificacionEmpresa">
          <option value="Micro"@if('Micro'== $empresa->ClasificacionEmpresa)selected @endif >Micro</option>
          <option value="Pequeña" @if('Pequeña'== $empresa->ClasificacionEmpresa)selected @endif >Pequeña</option>
          <option value="Mediana" @if('Mediana'== $empresa->ClasificacionEmpresa)selected @endif >Mediana</option>
          <option value="Grande" @if('Grande'== $empresa->ClasificacionEmpresa)selected @endif>Grande</option>
        </select>
      </div>
      <br>
      <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
      <a href="{{ route('empresas.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
    </form>
  </div>
</div>
@include('empresa.modals.delete')
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