<div class="modal fade" id="editEvento" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="fechaModalLabel">Editar Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form-editar-evento" action="{{ route('eventos.update', $evento->IdEvento) }}" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" id="id">
                    @include('layouts.validaciones')
                    <div class="form-group">
                        <label name="NombreEvento">Nombre del Evento:</label>
                        <input name="NombreEvento" value="{{ old('NombreEvento', $evento->NombreEvento) }}" type="text" class="form-control @error('NombreEvento') is-invalid @enderror" placeholder="Ej. Nuevo Evento Creado">
                    </div>
                    <div class="form-group">
                        <label name="DescripcionEvento">Descripción del Evento:</label>
                        <textarea name="DescripcionEvento" class="form-control @error('DescripcionEvento') is-invalid @enderror" rows="3" placeholder="Ej. Descripción del evento creado.">{{ old('DescripcionEvento', $evento->DescripcionEvento) }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="form-editar-evento">Actualizar</button>
            </div>
        </div>
    </div>
</div>
