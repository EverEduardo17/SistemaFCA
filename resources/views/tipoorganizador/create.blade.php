@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tipoorganizador.index') }}">Tipo de Organizadores</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agregar Tipo de Organizador</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Agregar Tipo de Organizador</h5>
            <a class="btn btn-primary col-4" href="{{ route('tipoorganizador.index') }}" role="button">Ver Tipo de Organizadores</a>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('tipoorganizador.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombreTipoOrganizador">Nombre del Tipo de Organizador:</label>
                <input name="NombreTipoOrganizador" type="text" value="{{ old('NombreTipoOrganizador') }}" class="form-control @error('NombreTipoOrganizador') is-invalid @enderror" placeholder="Ej. Responsable">
            </div>
            <div class="form-group">
                <label name="DescripcionTipoOrganizador">Descripción del Tipo de Organizador</label>
                <input name="DescripcionTipoOrganizador" type="text" value="{{ old('DescripcionTipoOrganizador') }}" class="form-control @error('DescripcionTipoOrganizador') is-invalid @enderror" placeholder="Ej. Representante ante la facultad del evento. ">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            <a href="{{ route('tipoorganizador.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
        </form>
    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection