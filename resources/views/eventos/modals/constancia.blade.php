<div class="modal fade" id="addConstanciaEvento" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="fechaModalLabel">Agregar Constancia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST"  action="{{ route('eventos.constancias.añadir', $evento->IdEvento) }}" autocomplete="off" >
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input type="hidden" name="evento" value="{{$evento->IdEvento}}">

                    <div class="form-group">
                        <label name="constancia">Constancia:</label>
                        <select name="constancia" class="form-control @error('constancia') is-invalid @enderror">
                            <option value="" disabled selected></option>
                            @foreach ($constancias as $constancia)
                                <option value="{{ $constancia->IdConstancia }}">{{ $constancia->NombreConstancia }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConstanciaEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Eliminar Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar un documento del evento.</p>
                <h5>¿Desea continuar?</h5>
                <small class="text-danger"><-- Esta acción no se puede deshacer --></small>
                <form id="form-eliminar-constancia" method="post" action="{{ route('eventos.constancias.eliminar', $evento->IdEvento) }}">
                    @csrf
                    <input type="hidden" name="evento" value="{{ $evento->IdEvento }}">
                    <input type="hidden" name="constancia">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger" form="form-eliminar-constancia">Eliminar</button>
            </div>
        </div>
    </div>
</div>
