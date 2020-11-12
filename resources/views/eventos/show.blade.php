@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center mr-2">
                <h4 class="mr-auto p-3">Evento</h4>
                <div class="btn-group" role="group">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editEvento">Editar</a>
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
            @include('layouts.validaciones')
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
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addfecha" data-do="create">Agregar</button>
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
                                        <th>Acciones</th>
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
                                                <a href="#" data-toggle="modal" data-target="#addfecha"
                                                data-do="update" data-fecha="{{$efs->IdFechaEvento}}"
                                                data-fechainicio="{{$efs->fechaEvento->InicioFechaEvento->format('d/m/Y')}}"
                                                data-horainicio="{{$efs->fechaEvento->InicioFechaEvento->format('g:i A')}}"
                                                data-horafin="{{$efs->fechaEvento->FinFechaEvento->format('g:i A')}}"
                                                data-sedeevento="{{$efs->IdSedeEvento}}" >Editar</a> |
                                                <a href="#" data-toggle="modal" data-target="#deletefecha" data-fecha="{{$efs->IdFechaEvento}}">Eliminar</a>
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
                                        <th>Acciones</th>
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
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTipoOrganizador">Agregar</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table_responsable" class="display">
                                <thead>
                                <tr>
                                    <th>Responsable</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($evento->organizador as $responsable)
                                    <tr>
                                        <td>{{ $responsable->academico->usuario->name }}</td>
                                        <td>{{ $responsable->tipo_organizador->NombreTipoOrganizador }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#deleteTipoOrganizador"
                                               data-tipoorganizador="{{ $responsable->IdOrganizador }}">Eliminar</a>
                                            <!--<a href="#" data-toggle="modal" data-target="#editTipoOrganizador"
                                               data-tipoorganizador="{{ $responsable->IdOrganizador }}"
                                               data-tipoact="{{ $responsable->IdTipoOrganizador }}">Editar</a>-->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="participantes" role="tabpanel" aria-labelledby="participantes-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <h4 class="mr-auto pl-3">Participantes</h4>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addParticipante">Agregar</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table_participante" class="display">
                                <thead>
                                    <tr>
                                        <th>NoPersonal</th>
                                        <th>Nombre del Academico</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evento->academico_evento as $ae)
                                        <tr>
                                            <td>{{$ae->academico->NoPersonalAcademico }}</td>
                                            <td>{{$ae->academico->usuario->name }}</td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#deleteParticipante"
                                                   data-participante="{{ $ae->Id_Academico_Evento }}">Eliminar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                    @foreach($evento->documento as $documento)
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
    @include('eventos.modals.edit')
    @include('eventos.modals.fecha')
    @include('eventos.modals.documento')
    @include('eventos.modals.tipoorganizador')
    @include('eventos.modals.participante')
@endsection

@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap3/css/bootstrap-mod.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/jquery.blockUI.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
    <script type="text/javascript" src="{{asset('lib/moment/min/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script>
        $(document).on('click', '#agregarDocumentoCargando', function() {
            $('#addDocument').modal('hide');
            $.blockUI({
                message: 'Espere un momento...',
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }
            });
        });

        $(document).ready( function () {
            $('#table_eventos').DataTable();
            $('#table_documentos').DataTable();
            $('#table_responsable').DataTable();
            $('#table_participante').DataTable();

        } );


        $('#evento-list a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        })

        /*Eliminar Fechas*/
        $('#deletefecha').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('fecha');
            var modal = $(this);
            modal.find('.modal-body input[name=fechaEvento]').val(recipient);
        })

        //Modal Fechas
        $('#addfecha').on('show.bs.modal', function (event) {
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

        $('#editEvento').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
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

        $('#addTipoOrganizador').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        })

        /*Eliminar tipoorganizador*/
        $('#deleteTipoOrganizador').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('tipoorganizador');
            var modal = $(this);
            var action = $("#form-eliminar-organizador").attr('action') + '/' + id;
            modal.find('.modal-body form').attr('action', action);
        })

        $('#addParticipante').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        })

        /*Eliminar tipoorganizador*/
        $('#deleteParticipante').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('participante');
            var modal = $(this);
            var action = $("#form-eliminar-participante").attr('action') + '/' + id;
            modal.find('.modal-body form').attr('action', action);
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
