@extends('layouts.app')

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection


@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
        <li class="breadcrumb-item active" aria-current="page">Aprobando Constancias</li>
    </ol>
</nav>


<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title"><strong> Aprobando Constancias</strong></h5>
            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ route('constancias.index') }}" role="button">Regresar</a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover border-bottom" id="table-jquery">
                <caption>Constancias esperando a ser aprobadas.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border">Nombre</th>
                        <th scope="col" class="border">Descripción</th>
                        <th scope="col" class="border">Autor</th>
                        <th scope="col" class="border">Vigente Hasta</th>
                        <th scope="col" class="border">Estado de Aprobación</th>
                        
                        {{-- TODO: Reemplazar con el permiso necesario correcto --}}
                        {{-- @can('havepermiso', 'constacias-editar-cualquiera') --}}
                            <th scope="col" class="border actions-col">Acciones</th>
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

                        <td class="border-right">{{ $constancia->EstadoConstancia }}</td>

                        {{-- TODO: Reemplazar con el permiso necesario correcto --}}
                        {{-- @can('havepermiso', 'constancias-aprobar-rechazar') --}}
                            <td class="btn-group py-2 border-right">
                                <a class="btn btn-sm btn-outline-success mx-1" data-toggle="modal" data-target="#aprobarConstancia{{ $constancia->IdConstancia }}" href="#" data-placement="bottom" title="Aprobar">
                                    <em><b>Aprobar</b></em>
                                </a>

                                {{-- No mover el include de aqui --}}
                                @include('constancias.modals.estadoconstancia', ['constancia' => $constancia])
                                
                                <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#rechazarConstancia{{ $constancia->IdConstancia }}" href="#" data-placement="bottom" title="Rechazar">
                                    <em><b>Rechazar</b></em>
                                </a>
                            </td>
                        {{-- @endcan --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('constancias.modals.delete')
@endsection


@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script src="{{ asset('js/table-script.js') }}"></script>

<script>
    /*Eliminar Constancia*/
    $('#delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('documento');
        var modal = $(this);
        var action = $("#form-eliminar-constancia").attr('action') + '/' + id;
        modal.find('.modal-body form').attr('action', action);
    })
</script>
@endsection
