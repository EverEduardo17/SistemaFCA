@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('eventos.index') }}">Eventos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Agregar evento</li>
    </ol>
</nav>
<div class="card shadow-sm">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8">Agregar Evento</h5>
            @can('havepermiso', 'eventos-listar')
                <a class="btn btn-primary col-4" href="{{ route('eventos.index') }}" role="button">Ver Eventos</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('eventos.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')
            <div class="form-group">
                <label name="nombre">Nombre del Evento:</label>
                <input name="nombre" type="text" value="{{ old('nombre') }}" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ej. Nuevo Evento">
            </div>

            <div class="form-group">
                <label name="descripcion">Descripción del Evento:</label>
                <input name="descripcion" type="text" value="{{ old('descripcion') }}" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Ej. Descripción del Nuevo Evento Creado.">
            </div>
            <hr>
            <div class="form-group">
                <label for="fechaInicio">Fecha del Evento:</label>
                <input id="fechaInicio" type="text" class="form-control @error('fechaInicio') is-invalid @enderror" name="fechaInicio" value="{{ old('fechaInicio') }}" placeholder="Día/Mes/Año">
            </div>

            <div class="form-group">
                <div class="form-row">
                    <div class="col">
                        <label for="horaInicio">Hora de Inicio:</label>
                        <input id="horaInicio" type="text" class="form-control  @error('horaInicio') is-invalid @enderror" name="horaInicio" value="{{ old('horaInicio') }}" placeholder="Hora de Inicio">
                    </div>
                    <div class="col">
                        <label for="horaInicio">Hora de Término:</label>
                        <input id="horaFin" type="text" class="form-control datetimepicker-input @error('horaFin') is-invalid @enderror" name="horaFin" value="{{ old('horaFin') }}" placeholder="Hora de Término">
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label name="sede">Sede del Evento:</label>
                <select name="sede" id="sede" class="form-control @error('sede') is-invalid @enderror">
                    @foreach ($sedes as $sede)
                    <option value="{{$sede->IdSedeEvento}}" {{ old('sede') == $sede->IdSedeEvento ? ' selected' : ''}}>{{$sede->NombreSedeEvento}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            @can('havepermiso', 'eventos-listar')
                <a href="{{ route('eventos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
            @endcan
        </form>
    </div>
</div>
@endsection

@section('head')
<link rel="stylesheet" href="{{asset('lib/bootstrap3/css/bootstrap-mod.css')}}" />
<link rel="stylesheet" href="{{asset('lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
@endsection

@section('script')
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>--}}
<script type="text/javascript" src="{{asset('lib/moment/min/moment-with-locales.min.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script>
    $('#fechaInicio').datetimepicker({
        locale: 'es',
        format: 'L'
    });

    $('#horaInicio').datetimepicker({
        format: 'LT'
    });

    $('#horaFin').datetimepicker({
        format: 'LT'
    });
</script>
@endsection
