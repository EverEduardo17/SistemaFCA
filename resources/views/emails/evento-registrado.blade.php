<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Solicitud de evento</title>
    <link rel="stylesheet" href="{{ asset('css/correo.css') }}">

</head>

<body class="bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <img 
                class="d-block mx-auto mb-4" 
                src="{{ asset('img/FlorconUV.png') }}" 
                alt="Logo uv" 
                width="100" 
                height="72"
            >
            <h2>Nueva solicitud de Evento.</h2>
            <p class="lead">Se ha solicitado una aprobación para el eveto: {{ $input['nombre'] }}.</p>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                {{-- Vi que quitaste la descripción y la sede, las deje por si acaso --}}
                <h4 class="mb-3">{{ $input['descripcion'] }}</h4>
    
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label>Fecha principal del Evento:</label>
                        <input type="text" class="form-control" value="{{ $input['fechaInicio'] }}" readonly="readonly"/>
                    </div>
    
                    <div class="form-group col-lg-6">
                        <label>Sede:</label>
                        <input type="text" class="form-control" value="{{ $input['sede'] }}" readonly="readonly"/>
                    </div>
    
                    <div class="form-group col-lg-6">
                        <label>Hora Inicio:</label>
                        <input type="text" class="form-control" value="{{ $input['horaInicio'] }}" readonly="readonly"/>
                    </div>
    
                    <div class="form-group col-lg-6">
                        <label>Hora Fin:</label>
                        <input type="text" class="form-control" value="{{ $input['horaFin'] }}" readonly="readonly"/>
                    </div>
    
                </div>
    
                <hr class="mb-12">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-block">Aprobar</a>
            </div>
            <div class="col-md-4 order-md-2 mb-4 solicitud">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    Solicitud
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Organizador:</h6>
                            <small class="text-muted">{{ $input['organizador'] }}</small>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© {{ getYear() }} Universidad Veracruzana.</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacidad</a></li>
                <li class="list-inline-item"><a href="#">Contacto</a></li>
                <li class="list-inline-item"><a href="#">Soporte</a></li>
            </ul>
        </footer>
    </div>
    </div>
</body>
</html>
