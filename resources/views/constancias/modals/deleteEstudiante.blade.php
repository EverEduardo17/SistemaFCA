<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Quitar Estudiante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>Usted está por quitar a un Estudiante.</p>
                <h5>¿Desea continuar?</h5>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>

                @can('havepermiso', 'constancias-eliminar-propio')
                <a  href="#" class="btn btn-constancia btn-danger" 
                    data-dismiss="modal"
                    data-url="" 
                >
                    Quitar
                
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>