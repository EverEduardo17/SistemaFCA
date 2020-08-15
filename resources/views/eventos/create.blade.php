@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registrar Evento</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('eventos_create') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="nombre" class="col-md-3 col-form-label text-md-right">Evento</label>

                                <div class="col-md-8">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>

                                    @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-3 col-form-label text-md-right">Descripción</label>

                                <div class="col-md-8">
                                    <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" required autocomplete="descripcion" autofocus>

                                    @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <label for="fechaInicio" class="col-md-3 col-form-label text-md-right">Fecha</label>

                                <div class="col-md-4">
                                        <input id="fechaInicio" type="text" class="form-control @error('fechaInicio') is-invalid @enderror" name="fechaInicio" value="{{ old('fechaInicio') }}" required autofocus placeholder="Dia/Mes/Año">
                                    @error('fechaInicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="horaInicio" class="col-md-3 col-form-label text-md-right">Hora</label>
                                <div class="col-md-4">
                                    <input id="horaInicio" type="text" class="form-control  @error('horaInicio') is-invalid @enderror" name="horaInicio" value="{{ old('horaInicio') }}" required autofocus placeholder="Inicio">
                                    @error('horaInicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <input id="horaFin" type="text" class="form-control datetimepicker-input @error('horaFin') is-invalid @enderror" name="horaFin" value="{{ old('horaFin') }}" required autofocus placeholder="Fin">
                                    @error('horaFin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">

                                <label class="col-md-3 col-form-label text-md-right">Sede</label>

                                <div class="col-md-8">
                                    <select class="form-control @error('sede') is-invalid @enderror" id="sede" name="sede" required autofocus>
                                        <option></option>
                                        @foreach( $sedes as $sede)
                                            <option value="{{$sede->IdSedeEvento}}" {{ old('sede') == $sede->IdSedeEvento ? ' selected' : ''}}>{{$sede->NombreSedeEvento}}</option>
                                        @endforeach
                                    </select>
                                    @error('sede')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Continuar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" href="{{asset('lib/bootstrap3/css/bootstrap-mod.css')}}" />
    <link rel="stylesheet" href="/lib/datetimepicker/css/bootstrap-datetimepicker.min.css" />
@endsection

@section('script')
    {{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>--}}
    <script type="text/javascript" src="/lib/moment/min/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/lib/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
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
