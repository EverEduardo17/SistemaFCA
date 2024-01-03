<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Solicitud de evento</title>
    <link rel="stylesheet" href="{{ asset('css/correo.css') }}">

</head>

<body>
    <div style="width: 100%; max-width: 1140px; margin: 0 auto;">
        <div style="padding: 3rem 0; text-align: center;">
            <h2>Nueva solicitud de Constancia.</h2>
            <p>Se solicita aprobación para la constancia: {{ $input['NombreConstancia'] }}.</p>
        </div>
    
        <div style="display: flex; flex-wrap: wrap;">
            <div style="flex: 1 0 100%; padding: 10px;">
                <h4 style="margin-bottom: 1rem;">{{ $input['DescripcionConstancia'] }}</h4>
    
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="flex: 1 0 50%; padding: 10px;">
                        <label><strong>Vigencia:</strong> {{ $input['VigenteHasta'] }}</label>
                    </div>
                </div>
    
                <hr class="mb-12">
                <a href="{{ route('login') }}" style="display: flex; align-items: center; justify-content: center; display: block; width: 100%; padding: 0.5rem 1rem; font-size: 1.25rem; line-height: 1.5; background-color: #007bff; color: #fff; border-radius: 0.25rem; text-align: center;">
                    Ir a la plataforma
                </a>
            </div>
            <div class="col-md-4 order-md-2 mb-4 solicitud">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    Solicitud
                </h4>
                <ul style="list-style-type: none; margin-bottom: 1rem;">
                    <li style="display: flex; justify-content: space-between; align-items: center; line-height: 1.5; padding: 10px; border: 1px solid #dee2e6; border-radius: 0.25rem;">
                        <div>
                            <p style="margin: 0;">Autor:</p>
                            <small style="color: #6c757d;">{{ $input['autor'] }}</small>
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
