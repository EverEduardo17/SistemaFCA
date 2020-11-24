<div class="modal fade" id="editTipo" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="fechaModalLabel">Editar Tipo de Organizador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" id="form-editar-tipo" action="" autocomplete="off">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" id="id">
                    @include('layouts.validaciones')

                    <div class="form-group">
                        <label name="NombreTipoOrganizador">Nombre del Tipo de Organizador:</label>
                        <input name="NombreTipoOrganizador" value="{{ old('NombreTipoOrganizador') }}" type="text" class="form-control @error('NombreTipoOrganizador') is-invalid @enderror" placeholder="Ej. Responsable.">
                    </div>
                    <div class="form-group">
                        <label name="DescripcionTipoOrganizador">Descripción del Tipo de Organizador:</label>
                        <input name="DescripcionTipoOrganizador" value="{{ old('DescripcionTipoOrganizador') }}" type="text" class="form-control @error('DescripcionTipoOrganizador') is-invalid @enderror" placeholder="Ej. Representante ante la facultad del evento">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="form-editar-tipo">Actualizar</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="deleteTipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Eliminar Tipo de Organizador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar un tipo de organizador.</p>
                <h5>¿Desea continuar?</h5>
                <small class="text-danger"><-- Esta acción no se puede deshacer --></small>
                <form id="form-eliminar-tipo" method="post" action="{{ route('tipoorganizador.destroy', '') }}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id" id="id">
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger" form="form-eliminar-tipo">Eliminar</button>
            </div>
        </div>
    </div>
</div>
