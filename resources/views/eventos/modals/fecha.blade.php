<div class="modal fade" id="addfecha" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="fechaModalLabel">Agregar fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($evento->EstadoEvento === 'APROBADO')
                    <div class="alert alert-warning" role="alert">
                        Este evento tendrá que ser aprobado de nuevo.
                    </div>
                @endif
                <form method="POST" id="form-fecha" action="" autocomplete="off">
                    @csrf
                    @include('layouts.validaciones')
                    <input type="hidden" name="_method" value="">
                    <input type="hidden" name="evento" value="{{$evento->IdEvento}}">
                    <input type="hidden" name="fechaEvento" value="">

                    <div class="form-group">
                        <label for="fechaInicio" class="col-form-label">Fecha del evento:</label>
                        <input id="fechaInicio" type="text" class="form-control @error('fechaInicio') is-invalid @enderror" name="fechaInicio" value="{{ old('fechaInicio') }}" placeholder="Día/Mes/Año">
                    </div>

                    <div class="form-group">
                        <label for="horaInicio" class="col-form-label">Hora de inicio:</label>
                        <input id="horaInicio" type="text" class="form-control  datetimepicker-input @error('horaInicio') is-invalid @enderror" name="horaInicio" value="{{ old('horaInicio') }}" placeholder="Hora de Inicio">
                    </div>

                    <div class="form-group">
                        <label for="horaFin" class="col-form-label">Hora de término:</label>
                        <input id="horaFin" type="text" class="form-control datetimepicker-input @error('horaFin') is-invalid @enderror" name="horaFin" value="{{ old('horaFin') }}" placeholder="Hora de Término">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Sede</label>
                        <select class="form-control @error('sede') is-invalid @enderror" id="sede" name="sede">
                            @foreach( $sedes as $sede)
                                <option value="{{$sede->IdSedeEvento}}" {{ old('sede') == $sede->IdSedeEvento ? ' selected' : ''}}>{{$sede->NombreSedeEvento}}</option>
                            @endforeach
                        </select>
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

<div class="modal fade" id="deletefecha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Eliminar Fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar una fecha del evento.</p>
                <h5>¿Desea continuar?</h5>
                <small class="text-danger"><-- Esta acción no se puede deshacer --></small>
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
