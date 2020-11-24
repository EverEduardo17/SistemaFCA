@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('academias.index') }}">Academias</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $academia->NombreAcademia }}</li>
    </ol>
</nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <h5 class="card-title col-8">{{ $academia->NombreAcademia }}</h5>
                <a class="btn btn-primary col-4" href="{{ route('academias.edit', $academia) }}" role="button">Editar Academia</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <h6 class="card-title">Coordinador: {{ $academia->coordinador->usuario->name }}</h6>
                    <p class="card-text">{{ $academia->DescripcionAcademia }}</p>
                </div>
                <div class="col">
                    <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addAcademicoAcademia" >Agregar integrate</a>
                </div>
            </div>
            <br>
            <br>
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>No. de Personal</th>
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
                                <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#deleteAcademicoAcademia" data-academico="{{ $item->Id_Academico_Academia }}">Eliminar</a>
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
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}"/>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
    <script>
        $(document).ready( function () {
            $('#table').DataTable();
        } );

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
