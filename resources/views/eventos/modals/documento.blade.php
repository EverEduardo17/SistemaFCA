<div class="modal fade" id="addDocument" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fechaModalLabel">Agregar documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST"  action="{{ route('documento.store') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input type="hidden" name="evento" value="{{$evento->IdEvento}}">
                    <div class="form-group">
                        <label name="NombreDocumento">Nombre del Documento:</label>
                        <input name="NombreDocumento" type="text" class="form-control @error('NombreDocumento') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label name="DescripcionDocumento">Descripcion del Documento:</label>
                        <input name="DescripcionDocumento" type="text" class="form-control @error('DescripcionDocumento') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label name="FormatoDocumento">Documento:</label>
                        <input name="FormatoDocumento" type="file" class="form-control @error('FormatoDocumento') is-invalid @enderror">
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

<div class="modal fade" id="deleteDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar un documento.</p>
                <h4>¿Desea continuar?</h4>
                <form id="form-eliminar-documento" method="post" action="{{ route('documento.destroy', '') }}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger" form="form-eliminar-documento">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editDocumento" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fechaModalLabel">Editar documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form-editar-documento" action="{{ route('documento.update', '') }}" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" id="id">
                    @include('layouts.validaciones')
                    <div class="form-group">
                        <label name="NombreDocumento">Nombre del Documento:</label>
                        <input name="NombreDocumento" value="{{ old('NombreDocumento') }}" type="text" class="form-control @error('NombreDocumento') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label name="DescripcionDocumento">Descripcion del Documento:</label>
                        <input name="DescripcionDocumento" value="{{ old('DescripcionDocumento') }}" type="text" class="form-control @error('DescripcionDocumento') is-invalid @enderror">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" form="form-editar-documento">Editar</button>
            </div>
        </div>
    </div>
</div>
