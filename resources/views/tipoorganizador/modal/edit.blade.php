<div class="modal fade" id="editTipo" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fechaModalLabel">Editar Tipo de Organizador</h5>
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
                        <label name="NombreTipoOrganizador">Nombre del Documento:</label>
                        <input name="NombreTipoOrganizador" value="{{ old('NombreTipoOrganizador') }}" type="text" class="form-control @error('NombreTipoOrganizador') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label name="DescripcionTipoOrganizador">Descripcion del Documento:</label>
                        <input name="DescripcionTipoOrganizador" value="{{ old('DescripcionTipoOrganizador') }}" type="text" class="form-control @error('DescripcionTipoOrganizador') is-invalid @enderror">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" form="form-editar-tipo">Guardar</button>
            </div>

        </div>
    </div>
</div>
