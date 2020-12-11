<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="fechaModalLabel">Baja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('bajas.store') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input type="hidden" name="IdTrayectoria" value="{{$estudiante->IdTrayectoria}}">
                    <div class="form-group">
                        <label name="NombreDatosPersonales">Nombre(s):</label>
                        <input name="NombreDatosPersonales" type="text" class="form-control @error('NombreDatosPersonales') is-invalid @enderror" value="{{$estudiante->datosPersonales->NombreDatosPersonales}} {{$estudiante->datosPersonales->ApellidoPaternoDatosPersonales}} {{$estudiante->datosPersonales->ApellidoMaternoDatosPersonales}}" placeholder="Ej. Javier" disabled>
                    </div>

                    <div class="form-group">
                        <label name="MatriculaEstudiante">Matricula:</label>
                        <input name="MatriculaEstudiante" type="text" class="form-control @error('MatriculaEstudiante') is-invalid @enderror" value="{{$estudiante->estudiante->MatriculaEstudiante}}" placeholder="Ej. S17016281" maxlength="9" disabled>
                    </div>
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