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
      <a class="btn btn-secondary col-4" href="{{ route('empresas.index') }}" role="button">Ver Empresas</a>
    </div>
  </div>
  <div class="card-body">

    <form method="POST" action="{{ route('empresas.store') }}" autocomplete="off">
      @csrf
      @include('layouts.validaciones')
      <div class="form-group">
        <label for="NombreEmpresa">Nombre de la empresa:</label>
        <input name="NombreEmpresa" type="text" class="form-control @error('NombreEmpresa') is-invalid @enderror" 
        value="{{old('NombreEmpresa')}}" placeholder="Ej. Universidad Veracruzana: Coordinación de Proyectos de Desarrollo"
        id="NombreEmpresa" autofocus>
      </div>
      <div class="form-group">
        <label for="DireccionEmpresa">Dirección de la empresa:</label>
        <input name="DireccionEmpresa" type="text" class="form-control @error('DireccionEmpresa') is-invalid @enderror" 
        value="{{old('DireccionEmpresa')}}" placeholder="Ej. Av. Universidad Km 7.5" id="DireccionEmpresa">
      </div>
      <div class="form-group">
        <label for="LocalidadEmpresa">Localidad de residencia de la empresa:</label>
        <input name="LocalidadEmpresa" type="text" class="form-control @error('LocalidadEmpresa') is-invalid @enderror" 
        value="{{old('LocalidadEmpresa')}}" placeholder="Ej. Coatzacoalcos" id="LocalidadEmpresa">
      </div>
      <div class="form-group">
        <label for="TelefonoEmpresa">Teléfono de la empresa:</label>
        <input name="TelefonoEmpresa" type="text" class="form-control @error('TelefonoEmpresa') is-invalid @enderror" 
        value="{{old('TelefonoEmpresa')}}" placeholder="Ej. 9212115700 ext 55714" maxlength="25" id="TelefonoEmpresa">
      </div>
      <div class="form-group">
        <label for="EmailEmpresa">Correo electrónico de la empresa:</label>
        <input name="EmailEmpresa" type="text" class="form-control @error('EmailEmpresa') is-invalid @enderror" 
        value="{{old('EmailEmpresa')}}" placeholder="Ej. correo@empresa.com" id="EmailEmpresa">
      </div>
      <div class="form-group">
        <label for="ResponsableEmpresa">Responsable de la empresa:</label>
        <input name="ResponsableEmpresa" type="text" class="form-control @error('ResponsableEmpresa') is-invalid @enderror" 
        value="{{old('ResponsableEmpresa')}}" placeholder="Ej. Javier Pino Herrera" id="ResponsableEmpresa">
      </div>
      <div class="form-group">
        <label for="TipoEmpresa">Sector al que pertenece:</label>
        <select name="TipoEmpresa" class="form-control @error('TipoEmpresa') is-invalid @enderror" id="TipoEmpresa">
          <option></option>
          <option value="Privado" @if(old('TipoEmpresa')== "Privado") selected @endif>Privado</option>
          <option value="Público"@if(old('TipoEmpresa')== "Público") selected @endif>Público</option>
          <option value="Social"@if(old('TipoEmpresa')== "Social") selected @endif>Social</option>
          <option value="UV"@if(old('TipoEmpresa')== "UV") selected @endif>UV</option>
        </select>
      </div>
      <div class="form-group" id="ActividadDeEmpresa" @if(old('TipoEmpresa') == 5 )style="display:none"@endif>
        <label for="ActividadEmpresa">Actividad de la empresa:</label>
        <select name="ActividadEmpresa" class="form-control @error('ActividadEmpresa') is-invalid @enderror" id="ActividadEmpresa">
          <option></option>
          <option value="Comercial"@if(old('ActividadEmpresa')== "Comercial") selected @endif>Comercial</option>
          <option value="Industrial"@if(old('ActividadEmpresa')== "Industrial") selected @endif>Industrial</option>
          <option value="Servicios"@if(old('ActividadEmpresa')== "Servicios") selected @endif>Servicios</option>
        </select>
      </div>
      <div class="form-group" id="TamanioEmpresa" @if(old('TipoEmpresa') == 5 )style="display:none"@endif>
        <label for="ClasificacionEmpresa">Tamaño de la empresa:</label>
        <select name="ClasificacionEmpresa" class="form-control @error('ClasificacionEmpresa') is-invalid @enderror" id="ClasificacionEmpresa">
          <option></option>
          <option value="Micro"@if(old('ClasificacionEmpresa')== "Micro") selected @endif>Micro</option>
          <option value="Pequeña"@if(old('ClasificacionEmpresa')== "Pequeña") selected @endif>Pequeña</option>
          <option value="Mediana"@if(old('ClasificacionEmpresa')== "Mediana") selected @endif>Mediana</option>
          <option value="Grande"@if(old('ClasificacionEmpresa')== "Grande") selected @endif>Grande</option>
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
<script>
  $(document).ready( function(){
      $(document).on('change','#TipoEmpresa', function(){
          var seleccion = $('#TipoEmpresa option:selected').text();
          if( seleccion != "UV" ){
              $('#TamanioEmpresa').show();
              $('#ActividadDeEmpresa').show();
          }else{
              $('#TamanioEmpresa').hide();
              $('#ActividadDeEmpresa').hide();
          }
      });
  });
  
</script>
@endsection