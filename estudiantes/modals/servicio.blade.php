<div class="modal fade" id="servicio" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="fechaModalLabel">Agregar Servicio Social</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('servicio.store') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input name="IdTrayectoria" value="{{$trayectoria->IdTrayectoria}}" type="hidden">
                    <div class="form-group">
                        <label name="NombreEmpresa">Ingresa el nombre de la empresa:</label>
                        <input name="NombreEmpresa" type="text" class="form-control @error('NombreEmpresa') is-invalid @enderror" value="{{old('Empresa')}}" placeholder="Ej. Coordinación de desarrollo">
                        <small class="text-danger">Nota: La empresa ingresada debe de estar registrada en el sistema.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>