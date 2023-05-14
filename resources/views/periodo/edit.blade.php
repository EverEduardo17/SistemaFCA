@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Crear Periodo</h5>
            <a class="btn btn-primary col-4" href="{{ route('periodo.index') }}" role="button">Ver Periodos</a>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('periodo.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombrePeriodo">Nombre del Periodo:</label>
                <input name="NombrePeriodo" type="text" class="form-control @error('NombrePeriodo') is-invalid @enderror" value="{{ old('NombrePeriodo', $periodoes->NombrePeriodo) }}">
            </div>
            <div class="form-group">
                <label name="FechaInicioPerido">Inicio del Periodo:</label>
                <input type="date" name="FechaInicioPerido" class="form-control @error('FechaInicioPerido') is-invalid @enderror" value="{{ old('FechaInicioPerido', $periodoes->FechaInicioPerido) }}"></input>
            </div>
            <div class="form-group">
                <label name="FechaFinPerido">Término del Periodo:</label>
                <input type="date" name="FechaFinPerido" class="form-control @error('FechaFinPerido') is-invalid @enderror" value="{{ old('FechaFinPerido', $periodoes->FechaFinPerido) }}"></input>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            <a href="{{ route('periodo.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
        </form>

    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection