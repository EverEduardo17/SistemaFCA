<div class="modal fade" id="reprobado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Reprobado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('reprobado.store') }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input name="IdTrayectoria" value="{{$trayectoria->IdTrayectoria}}" type="hidden">
                    <input name="IdGrupo" value="{{$trayectoria->IdGrupo}}" type="hidden">
                    <div class="form-group">
                        <label name="IdPeriodo">Periodo en el que reprobó el estudiante:</label>
                        <select name="IdPeriodo" class="form-control @error('IdPeriodo') is-invalid @enderror">
                            @foreach ($periodos as $periodo)
                            <option value="{{ $periodo->IdPeriodo }}"> {{ $periodo->NombrePeriodo }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>