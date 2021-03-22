<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('grupos.store') }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input type="hidden" name="IdFacultad" value={{ $idFCA }}>
                    <div class="form-group">
                        <label name="NombreGrupo">Nombre del Grupo:</label>
                        <input name="NombreGrupo" type="text"
                            class="form-control @error('NombreGrupo') is-invalid @enderror"
                            value="{{old('NombreGrupo')}}" placeholder="Ej. LIS 701">
                    </div>
                    <div class="form-group">
                        <label name="DescripcionGrupo">Descripción del Grupo:</label>
                        <textarea name="DescripcionGrupo" type="text"
                            class="form-control @error('DescripcionGrupo') is-invalid @enderror"
                            value="{{old('DescripcionGrupo')}}" placeholder="Ej. Grupo de LIS en 7mo semestre."
                            rows="2">{{old('DescripcionGrupo')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label name="IdProgramaEducativo">Programa de pertenencia:</label>
                        <select name="IdProgramaEducativo"
                            class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
                            @foreach ($programas as $programa)
                            <option value="{{ $programa->IdProgramaEducativo }}">
                                {{ $programa->NombreProgramaEducativo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label name="IdCohorte">Cohorte de pertenencia:</label>
                        <select name="IdCohorte" class="form-control @error('IdCohorte') is-invalid @enderror">
                            @foreach ($cohortes as $cohorte)
                            <option value="{{ $cohorte->IdCohorte }}"> {{ $cohorte->NombreCohorte }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label name="IdPeriodoInicio">Periodo de inicio:</label>
                                <select name="IdPeriodoInicio"
                                    class="form-control @error('IdPeriodoInicio') is-invalid @enderror">
                                    @foreach ($periodos as $periodo)
                                    <option value="{{$periodo->IdPeriodo }}">{{ $periodo->NombrePeriodo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label name="IdPeriodoActivo">Último periodo activo:</label>
                                <select name="IdPeriodoActivo"
                                    class="form-control @error('IdPeriodoActivo') is-invalid @enderror">
                                    @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->IdPeriodo }}">{{ $periodo->NombrePeriodo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Crear Grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>