<div class="modal fade" id="deleteAcademicoAcademia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Eliminar Académico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar un académico de la academia: <br> <strong> {{ $academia->NombreAcademia }}</strong></p>
                <h5>¿Desea continuar?</h5>
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
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Integrante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form-add-academico" action="{{ route('academiaacademico.store') }}" autocomplete="off">
                    @csrf
                    @include('layouts.validaciones')
                    <input type="hidden" name="academia" value="{{ $academia->IdAcademia }}">
                    <div class="form-group">
                        <label>Agrega un académico a la academia:<br> <strong> {{ $academia->NombreAcademia }}</strong></label>
                        <br>
                        <label name="docente">Docente:</label>
                        <select name="docente" class="form-control @error('docente') is-invalid @enderror">
                            @foreach ($academicos as $academico)
                                <option value="{{ $academico->IdAcademico }}">{{ $academico->usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" form="form-add-academico">Agregar</button>
            </div>
        </div>
    </div>
</div>
