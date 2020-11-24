@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('academicos.index') }}">Académicos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agregar académico</li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Agregar Académico</h5>
            <a class="btn btn-primary col-4" href="{{ route('academicos.index') }}" role="button">Ver Académicos</a>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('academicos.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombreDatosPersonales">Nombre del Académico:</label>
                <input name="NombreDatosPersonales" type="text" class="form-control @error('NombreDatosPersonales') is-invalid @enderror" placeholder="Ej. Javier">
                </div>
                <div class=" form-group">
                <label name="ApellidoPaternoDatosPersonales">Apellido Paterno del Académico:</label>
                <input name="ApellidoPaternoDatosPersonales" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" placeholder="Ej. Pino">
                </div>
                <div class=" form-group">
                <label name="ApellidoMaternoDatosPersonales">Apellido Materno del Académico:</label>
                <input name="ApellidoMaternoDatosPersonales" type="text" class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror" placeholder="Ej. Herrera">
                </div>
                <hr>
                <div class=" form-group">
                <label name="NoPersonalAcademico">Número de Personal:</label>
                <input name="NoPersonalAcademico" type="text" class="form-control @error('NoPersonalAcademico') is-invalid @enderror" maxlength="10" placeholder="Ej. 0000000000">
            </div>
            <div class="form-group">
                <label name="RfcAcademico">RFC:</label>
                <input name="RfcAcademico" class="form-control @error('RfcAcademico') is-invalid @enderror" maxlength="13" placeholder="Ej. 0000000000000">
            </div>
            <hr>
            <div class="form-group">
                <label name="name">Nombre de Usuario:</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Ej. Javier Pino">
                </div>
                <div class=" form-group">
                <label name="email">Correo electrónico:</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Ej. correo@correo.com">
            </div>
            <div class="form-group">
                <label name="password">Contraseña:</label>
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" minlength="8" placeholder="Ej. Contraseña123">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            <a href="{{ route('academicos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
        </form>
    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection