<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="importModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title text-white" id="tituloModal">Importar Archivo de Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cohortes.importarCohorte') }}" method="post" enctype="multipart/form-data"
                    id="form-importar">
                    @csrf
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label for="NombreCohorte">Cohorte destino:</label>
                                <input name="NombreCohorte" type="text"
                                    class="form-control @error('NombreCohorte') is-invalid @enderror"
                                    value="{{old('NombreCohorte')}}" placeholder="Ej. S170">
                            </div>

                            <div class="col">
                                <label for="NombreGrupo">Grupo destino:</label>
                                <input name="NombreGrupo" type="text"
                                    class="form-control @error('NombreGrupo') is-invalid @enderror"
                                    value="{{old('NombreGrupo')}}" placeholder="Ej. LIS 801">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Documento">Seleccione el archivo a importar:</label>
                        <input type="file" name="Documento" id="Documento"value="{{old('Documento')}}">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-secondary" form="form-importar">Continuar</button>
            </div>
        </div>
    </div>
</div>