<div class="modal fade" id="confirmarModificarModal" tabindex="-1" role="document" aria-labelledby="confirmarModificarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="confirmarModificarModalLabel">Confirmar Actualización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas actualizar la constancia?
                @if ($constancia->EstadoConstancia != 'PENDIENTE')
                    <p>Esta Constancia ya fue <b>{{ $constancia->EstadoConstancia }}</b>. 
                        Modificarlo volverá a ponerlo como <b>PENDIENTE</b> y volvera a requerir aprobación.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarActualizar">Actualizar</button>
            </div>
        </div>
    </div>
</div>
