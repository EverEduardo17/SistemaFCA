
<div class="modal fade" id="editEvento" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fechaModalLabel">Editar Evento</h5>
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
                        <input name="NombreEvento" value="{{ old('NombreEvento', $evento->NombreEvento) }}" type="text" class="form-control @error('NombreEvento') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label name="DescripcionEvento">Descripcion del Evento:</label>
                        <textarea name="DescripcionEvento" class="form-control @error('DescripcionEvento') is-invalid @enderror" rows="3">{{ old('DescripcionEvento', $evento->DescripcionEvento) }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" form="form-editar-evento">Editar</button>
            </div>

        </div>
    </div>
</div>
