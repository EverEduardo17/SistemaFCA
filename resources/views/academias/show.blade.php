@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <h5 class="card-title col-8">{{ $academia->NombreAcademia }}</h5>
                <a class="btn btn-primary col-4" href="{{ route('academias.edit', $academia) }}" role="button">Editar Academia</a>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">Coordinador: {{ $academia->coordinador->usuario->name }}</h5>
            <p class="card-text">{{ $academia->DescripcionAcademia }}</p>
            <a href="#" data-toggle="modal" data-target="#addAcademicoAcademia" class="btn btn-primary">Agregar Academico</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No de Personal</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($academia->academico_academia as $item)
                        <tr>
                            <th>{{ $item->academico->NoPersonalAcademico }}</th>
                            <td>{{ $item->academico->usuario->name }}</td>
                            <td>{{ $item->academico->usuario->email }}</td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#deleteAcademicoAcademia"
                                   data-academico="{{ $item->Id_Academico_Academia }}">Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('academias.models.delete-academico-academia')
@endsection

@section('head')

@endsection

@section('script')
    <script>
        /*Eliminar Acedemico*/
        $('#deleteAcademicoAcademia').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('academico');
            var modal = $(this);
            modal.find('.modal-body form').attr('action', '{{ route('deleteAcademicoAcademia', '') }}');
            var action = $("#form-eliminar-academico").attr('action') + '/' + id;
            modal.find('.modal-body form').attr('action', action);
        })

        /*Eliminar Acedemico*/
        $('#addAcademicoAcademia').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        })
    </script>
@endsection
