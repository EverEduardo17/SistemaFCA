<div class="modal fade" id="addConstanciaEvento" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="fechaModalLabel">Agregar Constancia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST"  action="{{ route('eventos.constancias.añadir', $evento->IdEvento) }}" autocomplete="off" >
                @csrf
                <div class="modal-body">
                    @include('layouts.validaciones')
                    <input type="hidden" name="evento" value="{{$evento->IdEvento}}">

                    <table class="table table-striped table-hover border-bottom" id="table-agregar-constancias">
                        <caption>Constancias ya aprobadas.</caption>
                        <thead class="bg-table">
                            <tr class="text-white">
                                <th scope="col" class="border">Nombre</th>
                                <th scope="col" class="border">Descripción</th>
                                <th scope="col" class="border">Autor</th>
                                <th scope="col" class="border">Vigente Hasta</th>
                                
                                {{-- @can('havepermiso', 'constancias-editar-propio') --}}
                                    <th scope="col" class="border">Seleccionar</th>
                                {{-- @endcan --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($constancias as $constancia)
                            <tr>
                                <th scope="row" class="border-right border-left">
                                    <a href="{{ route('constancias.show', $constancia->IdConstancia) }}">
                                        {{ $constancia->NombreConstancia }}
                                    </a>
                                </th>
        
                                <td class="border-right">{{ $constancia->DescripcionConstancia }}</td>
        
                                <td class="border-right">
                                    {{ $constancia->usuario->datosPersonales->ApellidoPaternoDatosPersonales }}
                                    {{ $constancia->usuario->datosPersonales->ApellidoMaternoDatosPersonales }}
                                    {{ $constancia->usuario->datosPersonales->NombreDatosPersonales }}
                                </td>
        
                                <td class="border-right">{{ printDate(($constancia->VigenteHasta)) }}</td>
        
                                <td>
                                    <input type="checkbox" name="constancias[]" value="{{ $constancia->IdConstancia }}" style="width: 2rem; height: 2rem;">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConstanciaEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Eliminar Constancia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar una constancia del evento.</p>
                <h5>¿Desea continuar?</h5>
                <small class="text-danger"><-- Esta acción no se puede deshacer --></small>
                <form id="form-eliminar-constancia" method="post" action="{{ route('eventos.constancias.eliminar', $evento->IdEvento) }}">
                    @csrf
                    <input type="hidden" name="evento" value="{{ $evento->IdEvento }}">
                    <input type="hidden" name="constancia">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger" form="form-eliminar-constancia">Eliminar</button>
            </div>
        </div>
    </div>
</div>
