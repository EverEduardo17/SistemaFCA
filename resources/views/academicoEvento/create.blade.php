@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Asignar Participantes</h5>
            <a class="btn btn-primary col-4" href="{{ route('academicoEvento.index') }}" role="button">Ver Participantes</a>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('academicoEvento.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="NombreEvento">Evento:</label>
                <select name="NombreEvento" class="form-control @error('NombreEvento') is-invalid @enderror">
                    @foreach ($eventos as $evento)
                    <option value="{{ $evento->IdEvento }}">{{ $evento->NombreEvento }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label name="IdAcademico">Participante:</label>
                <select name="IdAcademico" class="form-control @error('IdAcademico') is-invalid @enderror">
                    @foreach ($academicoes as $academico)
                    <option value="{{ $academico->IdAcademico }}">{{ $academico->usuario->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            <a href="{{ route('academicoEvento.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
        </form>

    </div>
</div>
@endsection

@section('head')

@endsection

@section('script')

@endsection