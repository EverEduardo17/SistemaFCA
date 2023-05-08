@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gestión de Programas Educativos</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">
        <div class="row">
            <h5 class="card-title col-8"><strong> Gestión de Programas Educativos</strong></h5>
            <a class="btn btn-success col-4" href="{{ route('programaEducativo.create') }}" role="button">Agregar Programa Educativo</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover border-bottom" id="table-jquery">
                <caption>Programas Educativos registrados en el sistema.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col" class="border">Nombre</th>
                        <th scope="col" class="border">Acrónimo</th>
                        <th scope="col" class="border">Facultad</th>
                        <th scope="col" class="border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($programas as $programa)
                    <tr>
                        <th scope="row" class="border-right border-left">{{ $programa->NombreProgramaEducativo }}</th>
                        <td class="border-right">{{ $programa->AcronimoProgramaEducativo }}</td>
                        <td class="border-right">{{ $programa->facultad->NombreFacultad }}</td>
                        <td class="py-2 border-right">
                            <a class="btn btn-sm btn-outline-primary mx-2" href="{{ route('programaEducativo.edit', $programa->AcronimoProgramaEducativo) }}" data-toggle="tooltip" data-placement="bottom" title="Editar"><em class="fas fa-pencil-alt"></em></a>
                            <a class="btn btn-sm btn-outline-danger" href="#" data-toggle="modal" data-target="#delete" data-documento="{{ $programa->IdProgramaEducativo }}" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><em class="fas fa-trash-alt"></em></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('programaEducativo.modals.delete')
@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script src="{{ asset('js/table-script.js') }}"> </script>
<script>
    /*Eliminar PE*/
    $('#delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('documento');
        var modal = $(this);
        var action = $("#form-eliminar-programa").attr('action') + '/' + id;
        modal.find('.modal-body form').attr('action', action);
    })
</script>
@endsection