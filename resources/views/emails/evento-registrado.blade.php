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
    {{-- al parecer bootstrap no carga en el correo, por lo que se usa css puro --}}
    <div style="width: 100%; max-width: 1140px; margin: 0 auto;">
        <div style="padding: 3rem 0; text-align: center;">
            <img 
                class="d-block mx-auto mb-4" 
                src="{{ asset('img/FlorconUV.png') }}" 
                alt="UV" 
                width="100" 
                height="72"
            >
            <h2>Nueva solicitud de Evento.</h2>
            <p class="lead">Se solicita aprobación para el evento: {{ $input['nombre'] }}.</p>
        </div>
    
        <div style="display: flex; flex-wrap: wrap;">
            <div style="flex: 1 0 100%; padding: 10px;">
                <h4 style="margin-bottom: 1rem;">{{ $input['descripcion'] }}</h4>
    
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="flex: 1 0 50%; padding: 10px;">
                        <label><strong>Fecha del Evento:</strong> {{ $input['fechaInicio'] }}</label>
                    </div>

                    <div style="flex: 1 0 50%; padding: 10px;">
                        <label><strong>Sede:</strong> {{ $input['sede'] }}</label>
                    </div>

                    @if ($input['horaInicio'] !== null)
                        <div style="flex: 1 0 50%; padding: 10px;">
                            <label><strong>Hora de inicio:</strong> {{ $input['horaInicio'] }}</label>
                        </div>
                    @endif
                    
                    <div style="flex: 1 0 50%; padding: 10px;">
                        <label><strong>Hora de terminación:</strong> {{ $input['horaFin'] }}</label>
                    </div>
                 </div>
    
                <hr class="mb-12">
                <a href="{{ route('eventos.show', $input['evento']) }}" style="display: flex; align-items: center; justify-content: center; display: block; width: 100%; padding: 0.5rem 1rem; font-size: 1.25rem; line-height: 1.5; background-color: #007bff; color: #fff; border-radius: 0.25rem; text-align: center;">
                    Ir a evento
                </a>
            </div>
            <div class="col-md-4 order-md-2 mb-4 solicitud">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    Solicitud
                </h4>
                <ul style="list-style-type: none; margin-bottom: 1rem;">
                    <li style="display: flex; justify-content: space-between; align-items: center; line-height: 1.5; padding: 10px; border: 1px solid #dee2e6; border-radius: 0.25rem;">
                        <div>
                            <p style="margin: 0;">Organizador:</p>
                            <small style="color: #6c757d;">{{ $input['organizador'] }}</small>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© {{ getYear() }} Universidad Veracruzana.</p>
        </footer>
    </div>
    </div>
</body>
</html>
