<div class="modal fade" id="addTipoOrganizador" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="fechaModalLabel">Agregar organizador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST"  action="{{ route('organizador.store') }}" autocomplete="off" >
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input type="hidden" name="evento" value="{{$evento->IdEvento}}">

                    <div class="form-group">
                        <label name="academico">Nombre del Docente:</label>
                        <select name="academico" class="form-control @error('academico') is-invalid @enderror">
                            <option value=""></option>
                            @foreach ($academicos as $academico)
                                <option value="{{ $academico->IdAcademico }}">{{ $academico->usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label name="organizador">Tipo de Organizador:</label>
                        <select name="organizador" class="form-control @error('organizador') is-invalid @enderror">
                            <option value=""></option>
                            @foreach ($tipoorganizadores as $tipoorganizador)
                                <option value="{{ $tipoorganizador->IdTipoOrganizador }}">{{ $tipoorganizador->NombreTipoOrganizador }}</option>
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

<div class="modal fade" id="deleteTipoOrganizador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Eliminar Responsable</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar un responsable del evento.</p>
                <h5>¿Desea continuar?</h5>
                <small class="text-danger"><-- Esta acción no se puede deshacer --></small>
                <form id="form-eliminar-organizador" method="post" action="{{ route('organizador.destroy', '') }}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger" form="form-eliminar-organizador">Eliminar</button>
            </div>
        </div>
    </div>
</div>
