@extends('layouts.app')

@section('head')
    {{-- CCS de toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/datatables/css/jquery.dataTables.min.css') }}" />
    <script src="{{ asset('js/table-script.js') }}"></script>
@endsection


@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active">{{ $usuario->IdUsuario }}</li>
        <li class="breadcrumb-item active" aria-current="page">Roles</li>
    </ol>
</nav>


<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">

            <h5 class="card-title">
                <strong> Roles</strong>
            </h5>

            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ url()->previous() }}" role="button">Regresar</a>

        </div>
    </div>

    <div class="card-body">
        @csrf @method('PATCH')

        <hr>

        <div class="table-responsive-xl">

        <table class="table table-striped table-hover border-bottom border-right" id="table-jquery">
            <caption>Roles disponibles del sistema.</caption>

            <thead class="bg-table">
            <tr class="text-white">
                <th scope="col" class="border">Rol</th>
                <th scope="col" class="border actions-col">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $rol)
                {{-- Los roles Academico, Estudiante, Egresado no deben cambiarse --}}
                @unless ($rol->IdRole === 2 || $rol->IdRole === 3 || $rol->IdRole === 4 || 
                        ($direccionCount>0 && $rol->IdRole === 5 && !$usuario->roles()->where('Role.IdRole', 5)->exists()) || //solo puede haber un director
                        (($rol->IdRole === 5 || $rol->IdRole === 6) && ($usuario->roles()->where('Role.IdRole', 3)->exists() || $usuario->roles()->where('Role.IdRole', 4)->exists())) ) {{-- un estudiante/egresado no puede ser ni director ni secretaria academica --}}
                    <tr>
                        <td scope="row" class="border-right border-left">{{ $rol->ClaveRole }}</td>
                        <td class="btn-group btn-group-sm">
                            <a href="#" data-role="{{ $rol->IdRole }}" class="btn btn-role btn-sm
                                @if ($usuario->roles()->where('Role.IdRole', $rol->IdRole)->exists())
                                    btn-danger">Eliminar
                                @else
                                    btn-success">Agregar
                                @endif
                            </a>
                        </td>
                    </tr>
                @endunless
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection


@section('script')
<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/datatables/js/jquery.dataTables.min.js') }}" defer></script>
{{-- Librerias de toastr --}} 
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- botones reactivos en Acciones --}}
<script>
    $(function() {
        $('.btn-role').on('click', function(e) {
            e.preventDefault();
            var idRole = $(this).data('role');
            var url = '{{ route("usuario.add.role") }}';
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    idRole: idRole,
                    idUsuario: '{{ $usuario->IdUsuario }}'
                },
                success: function(data) {
                    console.log(data);
                    if (data.success) {
                        $('.btn-role[data-role="' + idRole + '"]')
                            .removeClass('btn-success')
                            .addClass('btn-danger')
                            .text('Eliminar');
                            toastr.success('Rol agregado correctamente.', 'Se han guardado los cambios'); // Mostrar notificación de éxito
                    } else {
                        $('.btn-role[data-role="' + idRole + '"]')
                            .removeClass('btn-danger')
                            .addClass('btn-success')
                            .text('Agregar');
                            toastr.warning('Rol eliminado correctamente.', 'Se han guardado los cambios'); // Mostrar notificación de éxito
                    }
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText);
                }
            });
        });
    });
</script>