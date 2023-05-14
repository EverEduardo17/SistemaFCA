@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="row d-flex align-items-center mr-2">
                <h4 class="mr-auto p-3">Evento</h4>
                <div class="btn-group" role="group">
                    <button class="btn btn-primary">Editar</button>
                    <button class="btn btn-danger" style="margin-left: 1em" >Eliminar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="nombre" class="col-md-3 col-form-label text-md-right">Evento</label>

                <div class="col-md-8">
                    <input id="nombre" type="text" class="form-control" name="nombre" value="{{$evento->NombreEvento ?? ""}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label for="descripcion" class="col-md-3 col-form-label text-md-right">Descripción</label>

                <div class="col-md-8">
                    <textarea id="descripcion" class="form-control" name="descripcion" rows="3" disabled>{{ $evento->DescripcionEvento ?? "" }}</textarea>

                    @error('descripcion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="estado" class="col-md-3 col-form-label text-md-right">Estatus</label>

                <div class="col-md-8">
                    {{$evento->EstadoEvento}}
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="evento-list" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#fechas" role="tab" aria-controls="fechas" aria-selected="true">Fechas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="#responsables" role="tab" aria-controls="responsables" aria-selected="false">Responsables</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#participantes" role="tab" aria-controls="participantes" aria-selected="false">Participantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#documentos" role="tab" aria-controls="documentos" aria-selected="false">Documentos</a>
                </li>
            </ul>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content mt-3">
                <div class="tab-pane active" id="fechas" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <h4 class="mr-auto pl-3">Fechas</h4>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#fechaModal" data-do="create">Agregar</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table_eventos" class="display">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Sede</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($evento_fecha_sede_s as $efs)
                                    <tr>
                                        <td>{{$efs->fechaEvento->InicioFechaEvento->format('d/m/Y') ?? ""}}</td>
                                        <td>{{$efs->fechaEvento->InicioFechaEvento->format('h:i A') ?? ""}}</td>
                                        <td>{{$efs->fechaEvento->FinFechaEvento->format('h:i A') ?? ""}}</td>
                                        <td>{{$efs->sedeEvento->NombreSedeEvento ?? ""}}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#fechaModal"
                                               data-do="update" data-fecha="{{$efs->IdFechaEvento}}"
                                               data-fechainicio="{{$efs->fechaEvento->InicioFechaEvento->format('d/m/Y')}}"
                                               data-horainicio="{{$efs->fechaEvento->InicioFechaEvento->format('g:i A')}}"
                                               data-horafin="{{$efs->fechaEvento->FinFechaEvento->format('g:i A')}}"
                                               data-sedeevento="{{$efs->IdSedeEvento}}" >Editar</a> |
                                            <a href="#" data-toggle="modal" data-target="#exampleModal" data-fecha="{{$efs->IdFechaEvento}}">Eliminar</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Sede</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="responsables" role="tabpanel" aria-labelledby="responsables-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <h4 class="mr-auto pl-3">Responsables</h4>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="participantes" role="tabpanel" aria-labelledby="participantes-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <h4 class="mr-auto pl-3">Participantes</h4>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="documentos" role="tabpanel" aria-labelledby="documentos-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <h4 class="mr-auto pl-3">Documentos</h4>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('eventos.modals.deleteFecha')
    {{-- @include('eventos.modals.addFecha') --}}
@endsection

@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap3/css/bootstrap-mod.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
    <script type="text/javascript" src="/lib/moment/min/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/lib/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#table_eventos').DataTable();
        } );

        $('#evento-list a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        })

        /*Eliminar Fechas*/
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('fecha');
            var modal = $(this);
            modal.find('.modal-body input[name=fechaEvento]').val(recipient);
        })

        /*Modal Fechas*/
        $('#fechaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('fecha');
            var modal = $(this);
            var action = button.data('do');
            if( action == 'create' ){
                modal.find('.modal-title').text('Agregar fecha');
                modal.find('.modal-body input[name=fechaEvento]').val(recipient);
                modal.find('.modal-body input[name=_method]').val('post');
                modal.find('.modal-body form').attr('action', '{{ route('fechaEventos_store') }}');
                modal.find('.modal-footer button[type=submit]').text('Agregar');
                modal.find('#fechaInicio').val(null);
                modal.find('#horaInicio').val(null);
                modal.find('#horaFin').val(null);
                modal.find('#sede').val(null);
            }else if( action == 'update'){
                var fechaInicio = button.data('fechainicio');
                var horaInicio = button.data('horainicio');
                var horaFin = button.data('horafin');
                var sedeEvento = button.data('sedeevento');
                modal.find('.modal-title').text('Editar fecha');
                modal.find('.modal-body input[name=fechaEvento]').val(recipient);
                modal.find('.modal-body input[name=_method]').val('put');
                modal.find('.modal-body form').attr('action', '{{ route('fechaEventos_update') }}');
                modal.find('#fechaInicio').val(fechaInicio);
                modal.find('#horaInicio').val(horaInicio);
                modal.find('#horaFin').val(horaFin);
                modal.find('#sede').val(sedeEvento);
                modal.find('.modal-footer button[type=submit]').text('Editar');

            }


        })

        /*Date Picker*/
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


{{-- 
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="mr-auto p-3">Evento</h4>
                            <div class="btn-group" role="group">
                                <button class="btn btn-primary">Editar</button>
                                <button class="btn btn-danger" style="margin-left: 1em" >Eliminar</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <label for="nombre" class="col-md-3 col-form-label text-md-right">Evento</label>

                            <div class="col-md-8">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{$evento->NombreEvento ?? ""}}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-3 col-form-label text-md-right">Descripción</label>

                            <div class="col-md-8">
                                <textarea id="descripcion" class="form-control" name="descripcion" rows="3" disabled>{{ $evento->DescripcionEvento ?? "" }}</textarea>

                                @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="estado" class="col-md-3 col-form-label text-md-right">Estatus</label>

                            <div class="col-md-8">
                                {{$evento->EstadoEvento}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="evento-list" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#fechas" role="tab" aria-controls="fechas" aria-selected="true">Fechas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  href="#responsables" role="tab" aria-controls="responsables" aria-selected="false">Responsables</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#participantes" role="tab" aria-controls="participantes" aria-selected="false">Participantes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#documentos" role="tab" aria-controls="documentos" aria-selected="false">Documentos</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body pt-0">
                        <div class="tab-content mt-3">
                            <div class="tab-pane active" id="fechas" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center">
                                            <h4 class="mr-auto pl-3">Fechas</h4>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#fechaModal" data-do="create">Agregar</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table_eventos" class="display">
                                            <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Inicio</th>
                                                <th>Fin</th>
                                                <th>Sede</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($evento_fecha_sede_s as $efs)
                                                <tr>
                                                    <td>{{$efs->fechaEvento->InicioFechaEvento->format('d/m/Y') ?? ""}}</td>
                                                    <td>{{$efs->fechaEvento->InicioFechaEvento->format('h:i A') ?? ""}}</td>
                                                    <td>{{$efs->fechaEvento->FinFechaEvento->format('h:i A') ?? ""}}</td>
                                                    <td>{{$efs->sedeEvento->NombreSedeEvento ?? ""}}</td>
                                                    <td>
                                                        <a href="#" data-toggle="modal" data-target="#fechaModal"
                                                           data-do="update" data-fecha="{{$efs->IdFechaEvento}}"
                                                           data-fechainicio="{{$efs->fechaEvento->InicioFechaEvento->format('d/m/Y')}}"
                                                           data-horainicio="{{$efs->fechaEvento->InicioFechaEvento->format('g:i A')}}"
                                                           data-horafin="{{$efs->fechaEvento->FinFechaEvento->format('g:i A')}}"
                                                           data-sedeevento="{{$efs->IdSedeEvento}}" >Editar</a> |
                                                        <a href="#" data-toggle="modal" data-target="#exampleModal" data-fecha="{{$efs->IdFechaEvento}}">Eliminar</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Inicio</th>
                                                <th>Fin</th>
                                                <th>Sede</th>
                                                <th></th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="responsables" role="tabpanel" aria-labelledby="responsables-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center">
                                            <h4 class="mr-auto pl-3">Responsables</h4>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="participantes" role="tabpanel" aria-labelledby="participantes-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center">
                                            <h4 class="mr-auto pl-3">Participantes</h4>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="documentos" role="tabpanel" aria-labelledby="documentos-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center">
                                            <h4 class="mr-auto pl-3">Documentos</h4>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Usted está por eliminar una fecha.</p>
                    <h4>¿Desea continuar?</h4>
                    <form id="form-eliminar-fecha" method="post" action="{{route('fechaeventos_delete')}}">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="fechaEvento">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" form="form-eliminar-fecha">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="fechaModal" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fechaModalLabel">Agregar fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="form-fecha" action="">
                        @csrf
                        <input type="hidden" name="_method" value="">
                        <input type="hidden" name="evento" value="{{$evento->IdEvento}}">
                        <input type="hidden" name="fechaEvento" value="">
                        <div class="form-group">
                            <label for="fechaInicio" class="col-form-label">Fecha</label>

                            <input id="fechaInicio" type="text" class="form-control @error('fechaInicio') is-invalid @enderror" name="fechaInicio" value="{{ old('fechaInicio') }}" required autofocus placeholder="Dia/Mes/Año">
                            @error('fechaInicio')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="horaInicio" class="col-form-label">Hora de inicio</label>
                            <input id="horaInicio" type="text" class="form-control  @error('horaInicio') is-invalid @enderror" name="horaInicio" value="{{ old('horaInicio') }}" required autofocus placeholder="Inicio">
                            @error('horaInicio')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="horaFin" class="col-form-label">Hora de fin</label>
                            <input id="horaFin" type="text" class="form-control datetimepicker-input @error('horaFin') is-invalid @enderror" name="horaFin" value="{{ old('horaFin') }}" required autofocus placeholder="Fin">
                            @error('horaFin')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-form-label">Sede</label>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" form="form-fecha">Agregar</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/bootstrap3/css/bootstrap-mod.css')}}" />
    <link rel="stylesheet" href="/lib/datetimepicker/css/bootstrap-datetimepicker.min.css" />
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
    <script type="text/javascript" src="/lib/moment/min/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/lib/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#table_eventos').DataTable();
        } );

        $('#evento-list a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        })

        /*Eliminar Fechas*/
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('fecha');
            var modal = $(this);
            modal.find('.modal-body input[name=fechaEvento]').val(recipient);
        })

        /*Modal Fechas*/
        $('#fechaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('fecha');
            var modal = $(this);
            var action = button.data('do');
            if( action == 'create' ){
                modal.find('.modal-title').text('Agregar fecha');
                modal.find('.modal-body input[name=fechaEvento]').val(recipient);
                modal.find('.modal-body input[name=_method]').val('post');
                modal.find('.modal-body form').attr('action', '{{ route('fechaEventos_store') }}');
                modal.find('.modal-footer button[type=submit]').text('Agregar');
                modal.find('#fechaInicio').val(null);
                modal.find('#horaInicio').val(null);
                modal.find('#horaFin').val(null);
                modal.find('#sede').val(null);
            }else if( action == 'update'){
                var fechaInicio = button.data('fechainicio');
                var horaInicio = button.data('horainicio');
                var horaFin = button.data('horafin');
                var sedeEvento = button.data('sedeevento');
                modal.find('.modal-title').text('Editar fecha');
                modal.find('.modal-body input[name=fechaEvento]').val(recipient);
                modal.find('.modal-body input[name=_method]').val('put');
                modal.find('.modal-body form').attr('action', '{{ route('fechaEventos_update') }}');
                modal.find('#fechaInicio').val(fechaInicio);
                modal.find('#horaInicio').val(horaInicio);
                modal.find('#horaFin').val(horaFin);
                modal.find('#sede').val(sedeEvento);
                modal.find('.modal-footer button[type=submit]').text('Editar');

            }


        })

        /*Date Picker*/
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

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registrar Evento</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('eventos_create') }}" autocomplete="off">
                            @csrf
                            <div class="form-group row">
                                <label for="nombre" class="col-md-3 col-form-label text-md-right">Evento</label>

                                <div class="col-md-8">
                                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autofocus>

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
                                    <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" required autofocus>

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
    <link rel="stylesheet" href="{{asset('lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
@endsection

@section('script')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
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
@endsection --}}
