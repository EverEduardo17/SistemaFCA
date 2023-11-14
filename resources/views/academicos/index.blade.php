@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Académicos</li>
    </ol>
</nav>
<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Académicos</h5>

            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ route('home') }}" role="button">Regresar</a>

            @can('havepermiso', 'academicos-listar')
                <a class="btn btn-success col-4" href="{{ route('academicos.create') }}" role="button">Agregar Académico</a>
            @endcan

        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped border-bottom" id="table-jquery">
            <thead>
                <tr>
                    <th>No. Personal</th>
                    <th>Nombre Completo</th>
                    <th>Correo electrónico</th>
                    <th class="actions-col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($academicos as $academico)
                <tr>
                    <td>{{ $academico->NoPersonalAcademico ?? "" }}</td>
                    <td>
                        {{ $academico->usuario->datosPersonales->ApellidoPaternoDatosPersonales ?? "-" }}
                        {{ $academico->usuario->datosPersonales->ApellidoMaternoDatosPersonales ?? "-" }}
                        {{ $academico->usuario->datosPersonales->NombreDatosPersonales ?? "" }}
                    </td>
                    <td>{{ $academico->usuario->email ?? "" }}</td>


                    <td class="btn-group">
                        @can('havepermiso', 'academico-detalles')
                            <a class="btn btn-outline-primary btn-sm mr-1" href="{{ route('academicos.show', $academico) }}">Detalles</a>
                        @endcan
                        @can('havepermiso', 'academico-detalles')
                            <a class="btn btn-primary btn-sm mr-1" href="{{ route('academicos.edit', $academico) }}">Editar</a>
                        @endcan
                        @can('havepermiso', 'academicos-eliminar')
                                <a class="btn btn-danger btn-sm" href="#"
                                   data-toggle="modal" data-target="#deleteAcademico"
                                   data-academico="{{ $academico->IdAcademico }}"
                                >
                                    Eliminar
                                </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="deleteAcademico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Eliminar Academico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Usted está por eliminar un academico.</p>
                <h5>¿Desea continuar?</h5>
                <small class="text-danger"><-- Esta acción no se puede deshacer --></small>
                <form id="form-eliminar-academico" method="post" action="{{ route('academicos.destroy', '') }}">
                    @csrf
                    @method('delete')
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                @can('havepermiso', 'academicos-eliminar')
                    <button type="submit" class="btn btn-danger" form="form-eliminar-academico">Eliminar</button>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script src="{{ asset('js/table-script.js') }}"></script>
<script>
    $('#deleteAcademico').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('academico');
        var modal = $(this);
        var actionStart = '{{ route('academicos.destroy', '') }}';
        modal.find('.modal-body form').attr('action', actionStart);
        var action = $("#form-eliminar-academico").attr('action') + '/' + id;
        modal.find('.modal-body form').attr('action', action);
    });
</script>
@endsection
