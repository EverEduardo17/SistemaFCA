<div class="modal fade" id="modificar" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">Editar Estudiante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('editarEstudiantes',[$nombreCohorte, 'Matricula']) }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <div class="form-group">
                        <label name="Matricula">Matrícula del Estudiante:</label>
                        <input name="Matricula" type="text" class="form-control @error('Matricula') is-invalid @enderror" value="{{old('Empresa')}}" placeholder="Ej. S17016281">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">Editar Estudiante</button>
                </div>
            </form>
        </div>
    </div>
</div>