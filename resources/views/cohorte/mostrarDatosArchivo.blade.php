@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarCohorte') }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Carga Masiva</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h4 class="card-title col-12 contenedor-botones texto-primario"><strong>Carga Masiva de Estudiantes</strong>
            </h4>
        </div>

    </div>
    <div class="card-body">
        <h5 class="pt-0 mt-0 contenedor-botones text-muted">Información contenida en el archivo seleccionado</h5>
        <hr class="mx-5">
        <h5 class="pt-0 mt-0 mb-3">Cohorte ingresado:&nbsp;<strong>{{ $nombreCohorte }}</strong> - 
            Grupo ingresado:&nbsp;<strong>{{ $nombreGrupo }}</strong></h5>

        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_Estudiantes">
                <caption>Información contenida en el archivo {{ $nombreOriginal }}.</caption>
                <thead class="bg-table">
                    <tr class="text-white">
                        <th scope="col">Matrícula</th>
                        <th scope="col">Apellido Paterno</th>
                        <th scope="col">Apellido Materno</th>
                        <th scope="col">Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($arreglos as $arreglo)
                    @if ($loop->index > 0)
                    <tr>
                        <td>{{ $arreglo[0] }}</td>
                        <td>{{ $arreglo[1] }}</td>
                        <td>{{ $arreglo[2] }}</td>
                        <td>{{ $arreglo[3] }}</td>
                    </tr>
                    @endif
                    @endforeach

                </tbody>
            </table>
        </div>
        <hr class="mx-5">
        <div class="form-group">
            <p>¿La Información es correcta?</p>
            <a class="btn btn-outline-secondary px-6 mb-3 ml-2"
            href="{{ route('cohortes.cancelarImporte', $nombreArchivo) }}"
            role="button">Cancelar</a>
            <a class="btn btn-primary px-6 mb-3 ml-2"
            href="{{ route('cohortes.guardarImporte') }}"
            role="button">Continuar</a>
            
        </div>
    </div>
</div>


@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endsection

@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script>
    $(document).ready(function() {
$('#table_Estudiantes').DataTable({
"language": {
"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
}

});
});
</script>
@endsection