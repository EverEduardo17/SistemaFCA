{{-- Modal Aprobar --}}
<div class="modal fade" id="aprobarConstancia{{ $constancia->IdConstancia }}" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="fechaModalLabel">Aprobar constancia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por aprobar una constancia.</p>
                <h5>¿Desea continuar?</h5>
                <form id="form{{ $constancia->IdConstancia }}" method="GET" action="{{route('constancias.aprobar.aceptar', $constancia->IdConstancia)}}">
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" form="form{{ $constancia->IdConstancia }}">Aprobar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Rechazar --}}
<div class="modal fade" id="rechazarConstancia{{ $constancia->IdConstancia }}" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="fechaModalLabel">Rechazar constancia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="{{ route('constancias.aprobar.rechazar', $constancia->IdConstancia) }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <p>Usted está por rechazar la constancia.</p>
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