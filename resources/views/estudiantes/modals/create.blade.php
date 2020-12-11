<div class="modal fade" id="createEstudiante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Estudiante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('estudiantes.store') }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <div class="form-group">
                        <label name="NombreDatosPersonales">Nombre(s):</label>
                        <input name="NombreDatosPersonales" type="text" class="form-control @error('NombreDatosPersonales') is-invalid @enderror" value="{{old('NombreDatosPersonales')}}" placeholder="Ej. Javier">
                    </div>
                    <div class="form-group">
                        <label name="ApellidoPaternoDatosPersonales">Apellido Paterno:</label>
                        <input name="ApellidoPaternoDatosPersonales" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" value="{{old('ApellidoPaternoDatosPersonales')}}" placeholder="Ej. Pino">
                    </div>
                    <div class="form-group">
                        <label name="ApellidoMaternoDatosPersonales">Apellido Materno:</label>
                        <input name="ApellidoMaternoDatosPersonales" type="text" class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror" value="{{old('ApellidoMaternoDatosPersonales')}}" placeholder="Ej. Herrera">
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label name="IdCohorte">Cohorte de pertenencia:</label>
                                <input name="NombreCohorte" type="text" class="form-control @error('NombreCohorte') is-invalid @enderror" value="{{$nombreCohorte}}" placeholder="Ej. S170" disabled></input>
                                <input name="IdCohorte" type="hidden" class="form-control @error('IdCohorte') is-invalid @enderror" value="{{$idCohorte}}"></input>
                            </div>
                            <div class="col">
                                <label name="MatriculaEstudiante">Matricula:</label>
                                <input name="MatriculaEstudiante" type="text" class="form-control @error('MatriculaEstudiante') is-invalid @enderror" value="{{old('MatriculaEstudiante')}}" placeholder="Ej. S17016281">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label name="IdProgramaEducativo">Programa Educativo:</label>
                                <select name="IdProgramaEducativo" class="form-control @error('IdProgramaEducativo') is-invalid @enderror">
                                    @foreach ($programas as $programa)
                                    <option value="{{ $programa->IdProgramaEducativo }}">{{ $programa->AcronimoProgramaEducativo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label name="IdGrupo">Grupo de pertenencia:</label>
                                <select name="IdGrupo" class="form-control @error('IdGrupo') is-invalid @enderror">
                                    @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->IdGrupo }}"> {{ $grupo->NombreGrupo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label name="IdModalidad">Modalidad de entrada:</label>
                                <select name="IdModalidad" class="form-control @error('IdModalidad') is-invalid @enderror">
                                    @foreach ($modalidades as $modalidad)
                                    @if($modalidad->TipoModalidad == "Entrada")
                                    <option value="{{ $modalidad->IdModalidad }}">{{ $modalidad->NombreModalidad }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label name="Genero">Género:</label>
                                <select name="Genero" class="form-control @error('Genero') is-invalid @enderror">
                                    <option value="Mujer">Mujer</option>
                                    <option value="Hombre">Hombre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Agregar Estudiante</button>
                </div>
            </form>
        </div>
    </div>
</div>