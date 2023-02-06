<html>

<head>
    <title>Resumen {{$grupos[0]->NombreGrupo}} - Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</title>
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
    <h6 class="subtitulo">Resumen</h6>

    <table class="table" id="table_sede">
        <caption>Estudiantes registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del cohorte
            {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
        <thead class="bg-table">
            <tr class="text-white">
                <th scope="col"></th>
                <th scope="col">Hombres</th>
                <th scope="col">Mujeres</th>
                <th scope="col">Total</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="texto-izquierda">Activos</th>
                <td>{{$activoHombre}}</td>
                <td>{{$activoMujer}}</td>
                <td>{{$totalActivos}}</td>
            </tr>
            <tr>
                <th class="texto-izquierda">Egresados</th>
                <td>{{$egresadoHombre}}</td>
                <td>{{$egresadoMujer}}</td>
                <td>{{$totalEgresados}}</td>
            <tr>
                <th class="texto-izquierda">Traslados Entrantes</th>
                <td>{{$entranteHombre}}</td>
                <td>{{$entranteMujer}}</td>
                <td>{{$totalEntrantes}}</td>
            </tr>
            </tr>
            <tr>
                <th class="texto-izquierda">Traslados Salientes</th>
                <td>{{$salienteHombre}}</td>
                <td>{{$salienteMujer}}</td>
                <td>{{$totalSalientes}}</td>
            </tr>
            <tr>
                <th class="texto-izquierda">Bajas</th>
                <td>{{$bajaHombre}}</td>
                <td>{{$bajaMujer}}</td>
                <td>{{$totalBajas}}</td>
            </tr>
            <tr>
                <th scope="col" colspan="3" class="texto-izquierda"><strong>Total de Estudiantes</strong></th>
                <td><strong>{{$totalActivos + $totalEgresados + $totalEntrantes + $totalSalientes + $totalBajas}}</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <p class="texto-centrado">Información impresa el día {{ $fecha }} a las {{ $hora }}</p>
</body>

</html>