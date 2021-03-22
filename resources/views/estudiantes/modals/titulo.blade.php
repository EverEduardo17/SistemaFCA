<div class="modal fade" id="titulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Egreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('titulo.store') }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input name="IdTrayectoria" value="{{$trayectoria->IdTrayectoria}}" type="hidden">
                    <input name="IdGrupo" value="{{$trayectoria->IdGrupo}}" type="hidden">

                    <div class="form-group">
                        <label name="PromedioEgreso">Promedio ponderado:</label>
                        <input name="PromedioEgreso" type="text" class="form-control @error('PromedioEgreso') is-invalid @enderror" value="{{old('PromedioEgreso')}}" placeholder="Ej. 10.0">
                    </div>
                    <div class="form-group">
                        <label name="IdPeriodoEgreso">Periodo de egreso:</label>
                        <select name="IdPeriodoEgreso" class="form-control @error('IdPeriodoEgreso') is-invalid @enderror">
                            @foreach ($periodos as $periodo)
                            <option value="{{ $periodo->IdPeriodo }}"> {{ $periodo->NombrePeriodo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label name="IdModalidad">Modalidad de acreditación de Experiencia Recepcional:</label>
                        <select name="IdModalidad" class="form-control @error('IdModalidad') is-invalid @enderror">
                            @foreach ($modalidades as $modalidad)
                            @if($modalidad->TipoModalidad == "Titulación")
                            <option value="{{ $modalidad->IdModalidad }}"> {{ $modalidad->NombreModalidad }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <a class="btn btn-outline-dark" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Título
                    </a>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <div class="form-group">
                                <label name="FechaInicioTramite">Fecha de inicio del trámite:</label>
                                <input name="FechaInicioTramite" type="date" class="form-control @error('CampusDestino') is-invalid @enderror" value="{{old('FechaInicioTramite')}}">
                            </div>
                            <div class="form-group">
                                <label name="FechaFinTramite">Fecha de conclusión del trámite:</label>
                                <input name="FechaFinTramite" type="date" class="form-control @error('CampusDestino') is-invalid @enderror" value="{{old('FechaFinTramite')}}">
                            </div>

                            <div class="form-group mt-3">
                                <label>Estado del título:</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="EstadoTitulacion" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Entregado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="EstadoTitulacion" id="inlineRadio2" value="0">
                                    <label class="form-check-label" for="inlineRadio2">Pendiente</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label>¿Obtiene mención honorífica?</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="MencionHonorifica" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="MencionHonorifica" id="inlineRadio2" value="0">
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
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