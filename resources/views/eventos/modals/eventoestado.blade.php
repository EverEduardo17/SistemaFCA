<div class="modal fade" id="aprobarEvento" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="fechaModalLabel">Aprobar evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por aprobar evento.</p>
                <h5>¿Desea continuar?</h5>
                <form id="form-estado-crear" method="post" action="{{route('eventos.estado.store', $evento)}}">
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" form="form-estado-crear">Aprobar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rechazarEvento" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="fechaModalLabel">NO aprobar evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('eventos.estado.rechazo', $evento) }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <p>Usted está por NO aprovar el evento.</p>
                    @include('layouts.validaciones')
                    <div class="form-group">
                        <label name="Motivo">Motivo del rechazo:</label>
                        <textarea name="Motivo" class="form-control @error('Motivo') is-invalid @enderror"rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Rechazar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="solicitarEvento" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="fechaModalLabel">Solicitar aprobacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por solicitar la aprobacion de este evento.</p>
                <h5>¿Desea continuar?</h5>
                <form method="POST" id="form-editar-estado" action="{{ route('estado.update', ['estado'=>$evento]) }}" autocomplete="off">
                    @csrf
                    @method('PATCH')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="form-editar-estado">Solicitar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelarEvento" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="fechaModalLabel">Cancelar evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('eventos.estado.cancelar', $evento) }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <p>Usted está por cancelar este evento.</p>
                    @include('layouts.validaciones')
                    <div class="form-group">
                        <label name="Motivo">Motivo de la cancelación:</label>
                        <textarea name="Motivo" class="form-control @error('Motivo') is-invalid @enderror"rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
