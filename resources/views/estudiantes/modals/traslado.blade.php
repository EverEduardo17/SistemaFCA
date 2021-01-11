<div class="modal fade" id="traslado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Traslado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('traslado.store') }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input name="IdTrayectoria" value="{{$trayectoria->IdTrayectoria}}" type="hidden">
                    <input name="IdGrupo" value="{{$trayectoria->IdGrupo}}" type="hidden">
                    <input name="TipoTraslado" value="Saliente" type="hidden">
                    <div class="form-group">
                        <label name="FacultadDestino">Facultad de destino:</label>
                        <input name="FacultadDestino" type="text" class="form-control @error('FacultadDestino') is-invalid @enderror" @if (!empty($movilidad[0])) value="{{old('FacultadDestino'),$movilidad->last()->FacultadDestino}}" @endif placeholder="Ej. Facultad de Contaduría y Administración">
                    </div>
                    <div class="form-group">
                        <label name="CampusDestino">Campus de destino:</label>
                        <input name="CampusDestino" type="text" class="form-control @error('CampusDestino') is-invalid @enderror" @if (!empty($movilidad[0])) value="{{old('FacultadDestino'),$movilidad->last()->CampusDestino}}" @endif placeholder="Ej. Coatzacoalcos">
                    </div>
                    <div class="form-group">
                        <label name="IdPeriodo">Periodo del traslado:</label>
                        <select name="IdPeriodo" class="form-control @error('IdPeriodo') is-invalid @enderror">
                            @foreach ($periodos as $periodo)
                            <option value="{{ $periodo->IdPeriodo }}"> {{ $periodo->NombrePeriodo }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>