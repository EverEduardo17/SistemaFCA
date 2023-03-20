<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Eliminar Constancia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar una Constancia.</p>
                <h5>¿Desea continuar?</h5>
                <small class="text-danger"><-- Esta acción no se puede deshacer --></small>
                <form id="form-eliminar-programa" method="post" action="{{ route('constancias.destroy', '') }}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger" form="form-eliminar-programa">Eliminar</button>
            </div>
        </div>
    </div>
</div>