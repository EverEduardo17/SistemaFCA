<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Solicitud de evento</title>

    <!-- Favicons -->
    <link rel="icon" href="">
    <meta name="theme-color" content="#563d7c">

    <link href="form-validation.css" rel="stylesheet">
</head>
<body>
<div >
    <div >
        <h2>Nueva solicitud de Evento.</h2>
        <p class="lead">{{ $input['nombre'] }}.</p>
    </div>

    <div>
        <div>
            <p >{{ $input['nombre'] }}</p>

            <div>
                <div>
                    <label>Fecha principal del Evento:</label>
                    <input type="tel" value="{{ $input['fechaInicio'] }}" readonly="readonly"/>
                </div>

                <div class="form-group col-lg-6">
                    <label>Sede:</label>
                    <input type="tel" class="form-control" value="{{ $input['sede'] }}" readonly="readonly"/>
                </div>

                <div class="form-group col-lg-6">
                    <label>Hora Inicio:</label>
                    <input type="text" class="form-control" value="{{ $input['horaInicio'] }}" readonly="readonly"/>
                </div>

                <div class="form-group col-lg-6">
                    <label>Hora Fin:</label>
                    <input type="email" class="form-control" value="{{ $input['horaFin'] }}" readonly="readonly"/>
                </div>

            </div>

            <hr class="mb-4">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-block">Aprobar</a>
        </div>
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Solicitud</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Docente:</h6>
                        <small class="text-muted">Javier Pino</small>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2020 Uv</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacidad</a></li>
            <li class="list-inline-item"><a href="#">Contacto</a></li>
            <li class="list-inline-item"><a href="#">Soporte</a></li>
        </ul>
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
<script src="form-validation.js"></script></body>
</html>
