<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="exampleModalLabel">Descargando Constancias</h5>
            </div>

            <div class="modal-body">
                <p>Por favor no cierre la pagina hasta que termine la descarga</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" data-increment="{{ $estudiantes->count() }}" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div>