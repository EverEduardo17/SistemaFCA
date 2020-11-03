<div class="modal fade" id="deleteAcademicoAcademia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Academico de la Academia de: {{ $academia->NombreAcademia }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar un academico de esta academia.</p>
                <h4>¿Desea continuar?</h4>
                <form id="form-eliminar-academico" method="post" action="{{ route('deleteAcademicoAcademia', '') }}">
                    @csrf
                    @method('delete')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger" form="form-eliminar-academico">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addAcademicoAcademia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Academico a la Academia de: {{ $academia->NombreAcademia }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form-add-academico" action="" autocomplete="off">
                    @csrf
                    @include('layouts.validaciones')
                    <div class="form-group">
                        <label name="Coordinador">Docente:</label>
                        <select name="Coordinador" class="form-control @error('Coordinador') is-invalid @enderror">
                            @foreach ($academicos as $academico)
                                <option value="{{ $academico->academico->IdAcademico }}">{{ $academico->academico->usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="form-ad-academico">Agregar</button>
            </div>
        </div>
    </div>
</div>
