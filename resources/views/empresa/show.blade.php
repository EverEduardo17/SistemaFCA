@extends('layouts.plantilla')
@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('empresas.index') }}">Gestión de Empresas</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$empresa->NombreEmpresa}}</li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <div class="row align-center">
      <h5 class="card-title col-8"><strong>Detalles de la empresa: "{{$empresa->NombreEmpresa}}"</strong></h5>
      <a class="btn btn-secondary col-4" href="{{ route('empresas.index') }}" role="button">Ver Empresas</a>
    </div>
  </div>

  <div class="card-body">
    @csrf @method('PATCH')
    @include('layouts.validaciones')
    <div class="form-group">
      <label for="NombreEmpresa">Nombre de la empresa:</label>
      <input name="NombreEmpresa" type="text" class="form-control @error('NombreEmpresa') is-invalid @enderror"
        value="{{old('NombreEmpresa', $empresa->NombreEmpresa)}}"
        placeholder="Ej. Universidad Veracruzana: Coordinación de Proyectos de Desarrollo" disabled id="NombreEmpresa">
    </div>
    <div class="form-group">
      <label for="DireccionEmpresa">Dirección de la empresa:</label>
      <input name="DireccionEmpresa" type="text" class="form-control @error('DireccionEmpresa') is-invalid @enderror"
        value="{{old('DireccionEmpresa', $empresa->DireccionEmpresa)}}" placeholder="Ej. Av. Universidad Km 7.5"
        disabled id="DireccionEmpresa">
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label for="LocalidadEmpresa">Localidad de residencia de la empresa:</label>
          <input name="LocalidadEmpresa" type="text"
            class="form-control @error('LocalidadEmpresa') is-invalid @enderror"
            value="{{old('LocalidadEmpresa', $empresa->LocalidadEmpresa)}}" placeholder="Ej. Coatzacoalcos" disabled
            id="LocalidadEmpresa">
        </div>
        <div class="col">
          <label for="EmailEmpresa">Correo electrónico de la empresa:</label>
          <input name="EmailEmpresa" type="text"
            class="form-control @error('EmailEmpresa') is-invalid @enderror"
            value="{{old('EmailEmpresa', $empresa->EmailEmpresa)}}" placeholder="Ej. correo@empresa.uv.mx" disabled
            id="EmailEmpresa">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label for="ResponsableEmpresa">Responsable de la empresa:</label>
          <input name="ResponsableEmpresa" type="text"
            class="form-control @error('ResponsableEmpresa') is-invalid @enderror"
            value="{{old('ResponsableEmpresa', $empresa->ResponsableEmpresa)}}" placeholder="Ej. Javier Pino Herrera"
            disabled id="ResponsableEmpresa">
        </div>
        <div class="col">
          <label for="TelefonoEmpresa">Teléfono de la empresa:</label>
          <input name="TelefonoEmpresa" type="text" class="form-control @error('TelefonoEmpresa') is-invalid @enderror"
            value="{{old('TelefonoEmpresa', $empresa->TelefonoEmpresa)}}" placeholder="Ej. 9212115700 ext 55714"
            maxlength="25" disabled id="TelefonoEmpresa">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label for="TipoEmpresa">Sector al que pertenece:</label>
          <input name="TipoEmpresa" type="text" class="form-control @error('TipoEmpresa') is-invalid @enderror"
            value="{{old('TipoEmpresa', $empresa->TipoEmpresa)}}" placeholder="Ej. Público" disabled id="TipoEmpresa">
        </div>
        <div class="col" @if($empresa->TipoEmpresa == "UV" )style="display:none"@endif>
          <label for="ActividadEmpresa">Actividad de la empresa:</label>
          <input name="ActividadEmpresa" type="text"
            class="form-control @error('ActividadEmpresa') is-invalid @enderror"
            value="{{old('ActividadEmpresa', $empresa->ActividadEmpresa)}}" placeholder="Ej. Comercio" disabled
            id="ActividadEmpresa">
        </div>
        <div class="col" @if($empresa->TipoEmpresa == "UV" )style="display:none"@endif>
          <label for="ClasificacionEmpresa">Tamaño de la empresa:</label>
          <input name="ClasificacionEmpresa" type="text"
            class="form-control @error('ClasificacionEmpresa') is-invalid @enderror"
            value="{{old('ClasificacionEmpresa', $empresa->ClasificacionEmpresa)}}" placeholder="Ej. Público" disabled
            id="ClasificacionEmpresa">
        </div>

      </div>
    </div>

    <a href="{{ route('empresas.edit', $nombreEmpresa) }}" class="btn btn-primary btn-block">Editar Empresa</a>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary btn-block">Cancelar</a>

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