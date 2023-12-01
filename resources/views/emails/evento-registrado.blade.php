<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Solicitud de evento</title>

</head>
<body>
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

                <div>
                    <label>Hora Inicio:</label>
                    <input type="text" value="{{ $input['horaInicio'] }}" readonly="readonly"/>
                </div>

                <div>
                    <label>Hora Fin:</label>
                    <input type="email" value="{{ $input['horaFin'] }}" readonly="readonly"/>
                </div>

            </div>

            <hr>
            <a href="{{ route('login') }}">Aprobar</a>
        </div>
        <div>
            <h4>
                <span>Solicitud</span>
            </h4>
            <ul>
                <li>
                    <div>
                        <h6>Organizador:</h6>
                        <small class="text-muted">{{ $input['organizador'] }}</small>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <footer>
        <p>© {{ getYear() }} Universidad Veracruzana.</p>
    </footer>
</body>
</html>
