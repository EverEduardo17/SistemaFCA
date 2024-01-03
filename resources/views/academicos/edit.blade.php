@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('academicos.index') }}">Académicos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('academicos.index') }}">{{$academico->usuario->datospersonales->ApellidoPaternoDatosPersonales}} {{$academico->usuario->datospersonales->ApellidoMaternoDatosPersonales}} {{$academico->usuario->datospersonales->NombreDatosPersonales}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar académico</li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Editar Académico</h5>

            <a class="btn btn-outline-info col-2 ml-auto mr-4 " href="{{ route('academicos.index') }}" role="button">Regresar</a>

            @can('havepermiso', 'academicos-listar')
                <a class="btn btn-primary col-4" href="{{ route('academicos.index') }}" role="button">Ver Académicos</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('academicos.update', $academico) }}" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('layouts.validaciones')

            <div class="form-group">
                <label name="NombreDatosPersonales">Nombre del Académico:</label>
                <input name="NombreDatosPersonales" type="text" class="form-control @error('NombreDatosPersonales') is-invalid @enderror" value="{{ old('NombreDatosPersonales', $academico->usuario->datospersonales->NombreDatosPersonales) }}" placeholder="Ej. Javier">
            </div>

            <div class="form-group">
                <label name="ApellidoPaternoDatosPersonales">
                    {{ 
                    $academico->usuario->datosPersonales->ApellidoMaternoDatosPersonales === "" ? 
                        "Apellidos del Académico" : "Apellido Paterno del Académico:" 
                    }}
                </label>                
                <input name="ApellidoPaternoDatosPersonales" type="text" class="form-control @error('ApellidoPaternoDatosPersonales') is-invalid @enderror" value="{{ old('ApellidoPaternoDatosPersonales', $academico->usuario->datospersonales->ApellidoPaternoDatosPersonales) }}" placeholder="Ej. Pino">
            </div>

            @unless ($academico->usuario->datosPersonales->ApellidoMaternoDatosPersonales === "")
                <div class="form-group">
                    <label name="ApellidoMaternoDatosPersonales">Apellido Materno del Académico:</label>
                    <input name="ApellidoMaternoDatosPersonales" type="text" class="form-control @error('ApellidoMaternoDatosPersonales') is-invalid @enderror" value="{{ old('ApellidoMaternoDatosPersonales', $academico->usuario->datospersonales->ApellidoMaternoDatosPersonales) }}" placeholder="Ej. Herrera">
                </div>
            @endunless

            <hr>

            <div class="form-group">
                <label name="NoPersonalAcademico">Número de Personal:</label>
                <input name="NoPersonalAcademico" type="text" class="form-control @error('NoPersonalAcademico') is-invalid @enderror" maxlength="10" value="{{ old('NoPersonalAcademico', $academico->NoPersonalAcademico) }}" placeholder="Ej. 0000000000">
            </div>

            <div class="form-group">
                <label name="RfcAcademico">RFC:</label>
                <input name="RfcAcademico" class="form-control @error('RfcAcademico') is-invalid @enderror" maxlength="13" value="{{ old('RfcAcademico', $academico->RfcAcademico) }}" placeholder="Ej. 000000000000">
            </div>

            <hr>

            <div class="form-group">
                <label name="name">Nombre de Usuario:</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $academico->usuario->name) }}" placeholder="Ej. Javier Pino">
            </div>

            <div class="form-group">
                <label for="IdRole">{{ sizeof($academico->usuario->roles)>1 ? "Roles:" : "Rol:" }}</label>
                <input type="text" class="form-control" disabled 
                    value = "@foreach ($academico->usuario->roles as $rol) {{ $rol->ClaveRole }} @endforeach"
                >
                @can('havepermiso', 'roles-listar')
                    <a href="{{ route('usuario.index.roles', ["usuario" => $academico->usuario, "roles" => $academico->usuario->roles]) }}" 
                        class="btn btn-info btn-sm mt-2"
                    >
                        Modificar Roles
                    </a>
                @endcan
            </div>

            <div class="form-group">
                <label name="email">Correo electrónico:</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $academico->usuario->email) }}" placeholder="Ej. correo@correo.com">
            </div>

            @if($esDirectivo)

            <hr>
                <div class="form-group">
                    <label for="Firma">Imagen firma:</label> <br>
                    <input id="Firma" name="Firma" type="file">
                </div>
                @if ($academico->Firma)
                    <img src="{{ asset('storage/uploads/'.$academico->Firma) }}" height="100px" class="mb-3" alt="Firma de dirección">
                @endif
            @endif

            @can('havepermiso', 'academicos-detalles')
                <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
            @endcan
            @can('havepermiso', 'academicos-listar')
                <a href="{{ route('academicos.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
            @endcan
        </form>
    </div>
</div>
@endsection

