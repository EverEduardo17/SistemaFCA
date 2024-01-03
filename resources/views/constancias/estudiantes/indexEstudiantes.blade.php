@extends('layouts.app')

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
{{-- CCS de toastr --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection


@section('content')
{{-- {{ dd($usuarios) }} --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.index') }}">Constancias</a></li>
        <li class="breadcrumb-item"><a href="{{ route('constancias.show', $constancia->IdConstancia) }}">{{ $constancia->NombreConstancia }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">

            <h5 class="card-title">
                <strong>Usuarios</strong>
            </h5>

            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ route('constancias.show', $constancia->IdConstancia) }}" role="button">Regresar</a>

        </div>
    </div>

    <div class="card-body">
        @csrf @method('PATCH')
        @include('layouts.validaciones')

        <hr>

        <div class="table-responsive-xl">

        <table class="table table-striped table-hover border-bottom border-right" id="table-jquery">
            <caption>Usuarios registrados en el sistema.</caption>

            <thead class="bg-table">
            <tr class="text-white">
                <th scope="col" class="border">Usuario</th>
                <th scope="col" class="border">Nombre</th>
                <th scope="col" class="border">Rol</th>
                <th scope="col" class="border actions-col">Acciones</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($usuarios as $usuario)

                <tr>
                    <th scope="row" class="border-right border-left">{{ $usuario->name }}</th>
                    <td class="border-right">
                        {{ optional($usuario->datosPersonales)->ApellidoPaternoDatosPersonales }}
                        {{ optional($usuario->datosPersonales)->ApellidoMaternoDatosPersonales }}
                        {{ optional($usuario->datosPersonales)->NombreDatosPersonales }} 
                    </td>
                    <td class="border-right">{{ $usuario->roles[0]->ClaveRole ?? "" }}</td>

                    <td class="btn-group btn-group-sm">
                        <a href="#" data-usuario="{{ $usuario->IdUsuario }}" class="btn btn-constancia btn-sm
                            @if ($usuario->constancias()->where('Constancia.IdConstancia', $constancia->IdConstancia)->exists())
                                btn-danger">
                                    Eliminar
                            @else
                                btn-success">
                                    Agregar
                            @endif
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<script src="{{ asset('js/table-script.js') }}"></script>
{{-- Librerias de toastr --}} 
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- botones reactivos en Acciones --}}
<script>
    $(function() {
        $('.btn-constancia').on('click', function(e) {
            e.preventDefault();
            var idUsuario = $(this).data('usuario');
            var url = '{{ route("constancias.addEstudiante") }}';
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    idUsuario: idUsuario,
                    idConstancia: '{{ $constancia->IdConstancia }}'
                },
                success: function(data) {
                    if (data.success) {
                        $('.btn-constancia[data-usuario="' + idUsuario + '"]')
                            .removeClass('btn-success')
                            .addClass('btn-danger')
                            .text('Eliminar');
                            toastr.success('Usuario agregado a la constancia correctamente.', 'Accion realizada con éxito'); // Mostrar notificación de éxito
                    } else {
                        $('.btn-constancia[data-usuario="' + idUsuario + '"]')
                            .removeClass('btn-danger')
                            .addClass('btn-success')
                            .text('Agregar');
                            toastr.warning('Usuario eliminado de la constancia correctamente.', 'Accion realizada con éxito'); // Mostrar notificación de éxito
                    }
                }
            });
        });
    });
</script>
    
@endsection