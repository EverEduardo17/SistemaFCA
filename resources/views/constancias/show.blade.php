@extends('layouts.app')

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Gestión de Constancias</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $constancia->NombreConstancia }}</li>
            
            @can('havepermiso', 'constancias-editar-propio')
                <li class="descargar-plantilla col-12"> <a href="{{ route('constancias.downloadGenerica') }}"> Descargar Plantilla Génerica </a></li>
            @endcan
        </ol>
    </nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Detalles de la Constancia</h5>

            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ route('constancias.index') }}" role="button">Regresar</a>
            @can('havepermiso', 'constancias-detalles')
                <a class="btn btn-info col-3" href="#" data-toggle="modal" data-target="#help" role="button">Ayuda</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('constancias.store') }}" autocomplete="off">
            @csrf
            @include('layouts.validaciones')

            <div class="form-group">
                <label name="NombreConstancia">Nombre de la Constancia:</label>
                <input name="NombreConstancia" type="text" class="form-control @error('NombreConstancia') is-invalid @enderror" value="{{ old('NombreConstancia', $constancia->NombreConstancia) }}" disabled>
            </div>

            <div class="form-group">
                <label name="DescripcionConstancia">Descripción de la Constancia:</label>
                <input name="DescripcionConstancia" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" value="{{ old('DescripcionConstancia', $constancia->DescripcionConstancia) }}" disabled>
            </div>

            <div class="form-group">
                <label name="VigenteHasta">Vigente Hasta:</label>
                <input name="VigenteHasta" type="text" class="form-control @error('VigenteHasta') is-invalid @enderror" value="{{ old('VigenteHasta', printDate($constancia->VigenteHasta)) }}" disabled>
            </div>

            <div class="form-group">
                <label name="Estado">Estado de Aprobación:</label>
                <div style="display: flex;">
                    <input name="Estado" type="text" class="form-control @error('VigenteHasta') is-invalid @enderror" value="{{ old('Estado', $constancia->EstadoConstancia) }}" disabled>
                    {{-- TODO: Reemplazar con permiso necesario correcto --}}
                    @if ($constancia->EstadoConstancia == 'PENDIENTE')
                        @can('havepermiso', 'constancias-aprobar-rechazar')
                            <a class="btn btn-sm btn-outline-success mx-1" data-toggle="modal" data-target="#aprobarConstancia{{ $constancia->IdConstancia }}" href="#" data-placement="bottom" title="Aprobar">
                                <em><b>Aprobar</b></em>
                            </a>
                            <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#rechazarConstancia{{ $constancia->IdConstancia }}" href="#" data-placement="bottom" title="Rechazar">
                                <em><b>Rechazar</b></em>
                            </a>
                        @endcan
                    @endif
                </div>
            </div>

            @if ($constancia->EstadoConstancia == 'NO APROBADO')
                <div class="form-group">
                    <label name="MotivoRechazo">Motivo del Rechazo:</label>
                    <input name="MotivoRechazo" type="text" class="form-control @error('MotivoRechazo') is-invalid @enderror" value="{{ old('MotivoRechazo', $constancia->Motivo) }}" disabled>
                </div>
            @endif

            @can('havepermiso', 'constancias-editar-propio')

                <a class="mi-plantilla" 
                    href="{{ route('constancias.downloadMiPlantilla', [
                        'IdConstancia' => $constancia->IdConstancia, 
                        'NombreConstancia' => $constancia->NombreConstancia
                        ]) }}">
                        
                        Descargar mi Plantilla
                </a>

                <hr>
                <a href="{{ route('constancias.edit', $constancia) }}" class="btn btn-primary btn-block">Editar </a>

            @endcan
        </form>
    </div>
</div> 

<br> <br>
@can('havepermiso', 'constancias-editar-propio')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Participantes</h5>
                @if ($constancia->EstadoConstancia == 'APROBADO')
                    <a href="#download" data-file-name="{{ $constancia->NombreConstancia }}"data-href="{{ route('constancias.downloadAll', $constancia) }}" class="btn btn-info ml-auto mr-3 download-all"><i class="fas fa-file-archive"></i>
                        Descargar Todo
                    </a>
                @endif
                    <a class="btn btn-success col-3" href="{{ route('constancias.indexEstudiantes', $constancia) }}" role="button">Agregar Participantes</a>
            </div>
        </div>

            <div class="card-body">
                <div class="table-responsive-xl">
                    <table class="table table-striped table-hover border-bottom" id="table-jquery">
                        <caption>Usuarios que agregados a la constancia {{ $constancia->NombreConstancia }}.</caption>
                        <thead class="bg-table">
                            <tr class="text-white">
                                <th scope="col" class="border">Matrícula</th>
                                <th scope="col" class="border">Nombre</th>
                                <th scope="col" class="border">Genero</th>
                                <th scope="col" class="border actions-col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                            <tr id="fila-{{ $usuario->IdUsuario }}">
                                <th scope="row" class="border-right border-left">
                                    <a href="{{ route('constancias.showEstudiante', ['constancia' => $constancia->IdConstancia, 'usuario' => $usuario->IdUsuario]) }}">
                                        {{ $usuario->name }}
                                    </a>
                                </th>

                                <td class="border-right">
                                    {{ optional($usuario->DatosPersonales)->ApellidoPaternoDatosPersonales }}
                                    {{ optional($usuario->DatosPersonales)->ApellidoMaternoDatosPersonales }}
                                    {{ optional($usuario->DatosPersonales)->NombreDatosPersonales }}
                                </td>

                                <td class="border-right">{{ optional($usuario->datosPersonales)->Genero }}</td>

                                <td class="py-2 btn-group border-right">
                                    <a class="btn btn-sm btn-outline-success mr-1" href="{{ route('constancias.showEstudiante', ['constancia' => $constancia->IdConstancia, 'usuario' => $usuario->IdUsuario]) }}" data-toggle="tooltip" data-placement="bottom" title="Detalles">
                                        <em class="fas fa-list"></em>
                                    </a>
                                    @if ($constancia->EstadoConstancia == 'APROBADO')
                                        <a class="btn btn-sm btn-outline-primary mr-1" href="{{ route('constancias.download', ['constancia' => $constancia, 'usuario' => $usuario]) }}" data-toggle="tooltip" data-placement="bottom" title="Descargar Documento">
                                            <em class="fas fa-file-alt"></em>
                                        </a>
                                    @endif
                                    <a class="btn btn-sm btn-outline-danger btn-usuario" href="#" data-toggle="modal" data-target="#delete" data-usuario="{{ $usuario->IdUsuario }}" title="Quitar">
                                        <em class="fas fa-trash-alt"></em>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

    @include('constancias.modals.deleteEstudiante')
    @include('constancias.modals.loading')
    @include('constancias.modals.help')
    @include('constancias.modals.estadoconstancia')
@endcan

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
    <script src="{{ asset('js/table-script.js') }}"></script>
    <script src="{{ asset('js/constancias-scripts/delete-usuario.js') }}"></script>
    <script src="{{ asset('js/constancias-scripts/download-all.js') }}"></script>
    
    <script>
        $(document).on('click', '.btn-usuario', function (e) {
            var IdUsuario = $(this).data('usuario');
            var btnConstancia = $(".btn-constancia");

            btnConstancia.data('usuario', IdUsuario);

            var url = "{{ route('constancias.destroyEstudiante', ['constancia' => $constancia->IdConstancia, 'usuario' => "/"]) }}"

            url += '/' + IdUsuario;
            
            btnConstancia.data('url', url);
        });
    </script>

    
@endsection