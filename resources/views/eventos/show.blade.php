@extends('layouts.app')

@section('content')
    <div class="card">
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
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addfechaModal" data-do="create">Agregar</button>
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
                                                <a href="#" data-toggle="modal" data-target="#addfechaModal"
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
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addDocument">Agregar</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table_documentos" class="display">
                                <thead>
                                    <tr>
                                        <th>NombreDocumento</th>
                                        <th>DescripcionDocumento</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentos as $documento)
                                        <tr>
                                            <td>{{ $documento->NombreDocumento }}</td>
                                            <td>{{ $documento->DescripcionDocumento }}</td>
                                            <td>
                                                <a href="{{ route('documento.show', $documento->IdDocumento) }}">Descargar</a>
                                                <a href="#" data-toggle="modal" data-target="#deleteDocumento"
                                                   data-documento="{{ $documento->IdDocumento }}">Eliminar</a>
                                                <a href="#" data-toggle="modal" data-target="#editDocumento"
                                                   data-documento="{{ $documento->IdDocumento }}"
                                                   data-nombre="{{ $documento->NombreDocumento }}"
                                                   data-descripcion="{{ $documento->DescripcionDocumento }}">Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('eventos.modals.deleteFecha')
    @include('eventos.modals.addFecha')
    @include('eventos.modals.addDocument')
@endsection

@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap3/css/bootstrap-mod.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
    <script type="text/javascript" src="{{asset('lib/moment/min/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script>
        $(document).ready( function () {
            $('#table_eventos').DataTable();
            $('#table_documentos').DataTable();
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

        //Modal Fechas
        $('#addfechaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('fecha');
            var modal = $(this);
            var action = button.data('do');
            if( action == 'create' ){
                modal.find('.modal-title').text('Agregar fecha');
                modal.find('.modal-body input[name=fechaEvento]').val( 1 );
                modal.find('.modal-body input[name=_method]').val('post');
                modal.find('.modal-body form').attr('action', '{{ route('fechaEventos.store') }}');
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
                modal.find('.modal-body form').attr('action', '{{ route('fechaEventos.update') }}');
                modal.find('#fechaInicio').val(fechaInicio);
                modal.find('#horaInicio').val(horaInicio);
                modal.find('#horaFin').val(horaFin);
                modal.find('#sede').val(sedeEvento);
                modal.find('.modal-footer button[type=submit]').text('Editar');
            }
        })

        $('#addDocument').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        })

        /*Eliminar documento*/
        $('#deleteDocumento').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('documento');
            var modal = $(this);
            var action = $("#form-eliminar-documento").attr('action') + '/' + id;
            modal.find('.modal-body form').attr('action', action);
        })

        /*edit documento*/
        $('#editDocumento').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('documento');
            var nombre = button.data('nombre');
            var descripcion = button.data('descripcion');
            var modal = $(this);
            var action = $("#form-editar-documento").attr('action') + '/' + id;
            modal.find('.modal-body form').attr('action', action);
            modal.find('.modal-body input[name=NombreDocumento]').val(nombre);
            modal.find('.modal-body input[name=DescripcionDocumento]').val(descripcion);
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
