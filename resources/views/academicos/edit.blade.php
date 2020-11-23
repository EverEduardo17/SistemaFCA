@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Actualizar Académico</h5>
            <a class="btn btn-primary col-4" href="{{ route('academicos.index') }}" role="button">Ver Académicos</a>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('academicos.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombreDatosPersonales">Nombre del Académico:</label>
                <input name="NombreDatosPersonales" type="text" class="form-control @error('NombreDatosPersonales') is-invalid @enderror" value="{{ old('NombreDatosPersonales', $academico->usuario->datospersonales->NombreDatosPersonales) }}">
            </div>
            <div class="form-group">
                <label name="ApellidoPaternoDatosPersonales">Apellido Paterno del Académico:</label>
                <input name="ApellidoPaternoDatosPersonales" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" value="{{ old('ApellidoPaternoDatosPersonales', $academico->usuario->datospersonales->ApellidoPaternoDatosPersonales) }}">
            </div>
            <div class="form-group">
                <label name="ApellidoMaternoDatosPersonales">Apellido Materno del Académico:</label>
                <input name="ApellidoMaternoDatosPersonales" type="text" class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror" value="{{ old('ApellidoMaternoDatosPersonales', $academico->usuario->datospersonales->ApellidoMaternoDatosPersonales) }}">
            </div>
            <hr>
            <div class="form-group">
                <label name="NoPersonalAcademico">Número de Personal:</label>
                <input name="NoPersonalAcademico" type="text" class="form-control @error('NoPersonalAcademico') is-invalid @enderror" maxlength="10" value="{{ old('NoPersonalAcademico', $academico->NoPersonalAcademico) }}">
            </div>
            <div class="form-group">
                <label name="RfcAcademico">RFC:</label>
                <input name="RfcAcademico" class="form-control @error('RfcAcademico') is-invalid @enderror" maxlength="14" value="{{ old('RfcAcademico', $academico->RfcAcademico) }}">
            </div>
            <hr>
            <div class="form-group">
                <label name="name">Nombre de Usuario:</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $academico->usuario->name) }}">
            </div>
            <div class="form-group">
                <label name="email">Correo electrónico:</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $academico->usuario->email) }}">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
            <a href="{{ route('academicos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
        </form>
    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection