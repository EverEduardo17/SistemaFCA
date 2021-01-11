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
      <a class="btn btn-outline-info col-4" href="{{ route('empresas.index') }}" role="button">Ver Empresas</a>
    </div>
  </div>

  <div class="card-body">
    @csrf @method('PATCH')
    @include('layouts.validaciones')
    <div class="form-group">
      <label name="NombreEmpresa">Nombre de la empresa:</label>
      <input name="NombreEmpresa" type="text" class="form-control @error('NombreEmpresa') is-invalid @enderror" value="{{old('NombreEmpresa', $empresa->NombreEmpresa)}}" placeholder="Ej. Universidad Veracruzana: Coordinación de Proyectos de Desarrollo" disabled>
    </div>
    <div class="form-group">
      <label name="DireccionEmpresa">Dirección de la empresa:</label>
      <input name="DireccionEmpresa" type="text" class="form-control @error('DireccionEmpresa') is-invalid @enderror" value="{{old('DireccionEmpresa', $empresa->DireccionEmpresa)}}" placeholder="Ej. Av. Universidad Km 7.5" disabled>
    </div>
    <div class="form-group">
      <label name="LocalidadEmpresa">Localidad de residencia de la empresa:</label>
      <input name="LocalidadEmpresa" type="text" class="form-control @error('LocalidadEmpresa') is-invalid @enderror" value="{{old('LocalidadEmpresa', $empresa->LocalidadEmpresa)}}" placeholder="Ej. Coatzacoalcos" disabled>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label name="ResponsableEmpresa">Responsable de la empresa:</label>
          <input name="ResponsableEmpresa" type="text" class="form-control @error('ResponsableEmpresa') is-invalid @enderror" value="{{old('ResponsableEmpresa', $empresa->ResponsableEmpresa)}}" placeholder="Ej. Javier Pino Herrera" disabled>
        </div>
        <div class="col">
          <label name="TelefonoEmpresa">Teléfono de la empresa:</label>
          <input name="TelefonoEmpresa" type="text" class="form-control @error('TelefonoEmpresa') is-invalid @enderror" value="{{old('TelefonoEmpresa', $empresa->TelefonoEmpresa)}}" placeholder="Ej. 9212115700 ext 55714" maxlength="25" disabled>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label name="TipoEmpresa">Sector al que pertenece:</label>
          <input name="TipoEmpresa" type="text" class="form-control @error('TipoEmpresa') is-invalid @enderror" value="{{old('TipoEmpresa', $empresa->TipoEmpresa)}}" placeholder="Ej. Público" disabled>
        </div>
        <div class="col">
          <label name="ActividadEmpresa">Actividad de la empresa:</label>
          <input name="ActividadEmpresa" type="text" class="form-control @error('ActividadEmpresa') is-invalid @enderror" value="{{old('ActividadEmpresa', $empresa->ActividadEmpresa)}}" placeholder="Ej. Comercio" disabled>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label name="ClasificacionEmpresa">Tamaño de la empresa:</label>
      <input name="ClasificacionEmpresa" type="text" class="form-control @error('ClasificacionEmpresa') is-invalid @enderror" value="{{old('ClasificacionEmpresa', $empresa->ClasificacionEmpresa)}}" placeholder="Ej. Público" disabled>
    </div>

    <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-primary btn-block">Editar Empresa</a>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary btn-block">Regresar</a>

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