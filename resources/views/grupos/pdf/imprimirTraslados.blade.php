<html>

<head>
    <title>Traslados {{$grupos[0]->NombreGrupo}} - Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</title>
    <style>
        .titulo {
            text-align: center;
            font-size: 1.5rem;
        }

        .subtitulo {
            text-align: center;
            font-size: 1.2rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .bg-table {
            background: grey;
            color: white;
        }

        .table,
        th,
        td {
            border: 1px solid black;
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            padding: 0.5em;
        }

        .texto-izquierda {
            text-align: left;
        }
        
        .texto-centrado{
            text-align: center
        }

        .mx-5 {
            margin-left: 5rem;
            margin-right: 5rem;
        }
    </style>
</head>

<body>

    <h4 class="titulo">
        <strong>{{$grupos[0]->NombreGrupo}}</strong> - Cohorte {{$grupos[0]->cohorte->NombreCohorte}}
    </h4>
    <hr class="mx-5">
    <h6 class="subtitulo">Traslados Salientes</h6>

    <table class="table">
        <caption>Estudiantes trasladados registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte
            {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
        <thead class="bg-table">
            <tr class="text-white">
                <th scope="col">Matrícula</th>
                <th scope="col">Nombre</th>
                <th scope="col">Facultad de destino</th>
                <th scope="col">Campus de destino</th>
                <th scope="col">Periodo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantesSalientes as $estudiante)
            <tr>
                <td>{{$estudiante->trayectoria->estudiante->MatriculaEstudiante}}</td>
                <td>{{$estudiante->trayectoria->datosPersonales->NombreDatosPersonales}}
                    {{$estudiante->trayectoria->datosPersonales->ApellidoPaternoDatosPersonales}}
                    {{$estudiante->trayectoria->datosPersonales->ApellidoMaternoDatosPersonales}}</td>
                <td>{{$estudiante->FacultadDestino}}</td>
                <td>{{$estudiante->CampusDestino}}</td>
                <td>{{$estudiante->periodo->NombrePeriodo}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <br>
    <hr class="mx-5">
    <h6 class="subtitulo">Traslados Entrantes</h6>
    <table class="table">
        <caption>Estudiantes trasladados registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte
            {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
        <thead class="bg-table">
            <tr class="text-white">
                <th scope="col">Matrícula</th>
                <th scope="col">Nombre</th>
                <th scope="col">Facultad de procedencia</th>
                <th scope="col">Campus de procedencia</th>
                <th scope="col">Periodo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantesEntrantes as $estudiante)
            <tr>
                <td>{{$estudiante->trayectoria->estudiante->MatriculaEstudiante}}</td>
                <td>{{$estudiante->trayectoria->datosPersonales->NombreDatosPersonales}}
                    {{$estudiante->trayectoria->datosPersonales->ApellidoPaternoDatosPersonales}}
                    {{$estudiante->trayectoria->datosPersonales->ApellidoMaternoDatosPersonales}}</td>
                <td>{{$estudiante->FacultadDestino}}</td>
                <td>{{$estudiante->CampusDestino}}</td>
                <td>{{$estudiante->periodo->NombrePeriodo}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p class="texto-centrado">Información impresa el día {{ $fecha }} a las {{ $hora }}</p>
</body>

</html>