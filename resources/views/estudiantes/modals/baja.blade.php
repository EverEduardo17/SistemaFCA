<div class="modal fade" id="baja" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="fechaModalLabel">Dar de Baja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('bajas.store') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input name="IdTrayectoria" value="{{$trayectoria->IdTrayectoria}}" type="hidden">
                    <input name="IdGrupo" value="{{$trayectoria->IdGrupo}}" type="hidden">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label name="IdPeriodoBaja">Periodo de Baja:</label>
                                <select name="IdPeriodoBaja" class="form-control @error('IdPeriodoBaja') is-invalid @enderror">
                                    @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->IdPeriodo }}"> {{ $periodo->NombrePeriodo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label name="TipoBaja">Tipo de Baja:</label>
                                <select name="TipoBaja" class="form-control @error('TipoBaja') is-invalid @enderror">
                                    <option value="Temporal">Temporal</option>
                                    <option value="Definitiva">Definitiva</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label name="IdMotivo">Motivo de la baja:</label>
                                <select name="IdMotivo" class="form-control @error('IdMotivo') is-invalid @enderror">
                                    @foreach ($motivos as $motivo)
                                    <option value="{{ $motivo->IdMotivo }}">{{ $motivo->NombreMotivo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label name="IdPeriodoTramite">Periodo del trámite:</label>
                                <select name="IdPeriodoTramite" class="form-control @error('IdPeriodoTramite') is-invalid @enderror">
                                    @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->IdPeriodo }}"> {{ $periodo->NombrePeriodo }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <small class="text-danger">Nota: El motivo seleccionado debe ser válido para el tipo de baja seleccionada.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Dar de Baja</button>
                </div>
            </form>
        </div>
    </div>
</div>