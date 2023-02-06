<html>

<head>
    <title>Reprobados {{$grupos[0]->NombreGrupo}} - Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</title>
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
    <h6 class="subtitulo">Reprobados</h6>
    <table class="table">
        <caption>Estudiantes reprobados registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del
            cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
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
                <th>Reprobados</th>
                <td>{{$hombre}}</td>
                <td>{{$mujer}}</td>
                <td><strong>{{$totalReprobados}}</strong></td>
            </tr>
        </tbody>
    </table>
    
    <br>
    <hr class="mx-5">
    <h6 class="subtitulo">Reprobados por Periodo</h6>
    <table class="table">
        <caption>Estudiantes reprobados por periodo registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del 
            cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
        <thead class="bg-table">
            <tr>
                <th scope="col">Periodo</th>
                <th scope="col">Hombres</th>
                <th scope="col">Mujeres</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periodos as $periodo)
                @if(!empty($reprobadosPeriodo))
                    @if ($loop->index <= $totalPeriodos ) 
                        <tr>
                            <th scope="row" class="texto-izquierda">{{$periodo->NombrePeriodo}}</th>
                            <td>{{$reprobadosPeriodo[$loop->index]["hombre"]}}</td>
                            <td>{{$reprobadosPeriodo[$loop->index]["mujer"]}}</td>
                            <td><strong>{{$reprobadosPeriodo[$loop->index]["hombre"] + $reprobadosPeriodo[$loop->index]["mujer"]}}</strong></td>
                        </tr>
                    @endif
                @else
                    <tr>
                        <th scope="row" class="texto-izquierda">{{$periodo->NombrePeriodo}}
                        </th>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                    </tr>
                @endif
            @endforeach
                <tr>
                    <th scope="col" colspan="3" class="texto-izquierda"><strong>Total de Estudiantes Reprobados</strong></th>
                    <td><strong>{{$totalReprobados}}</strong></td>
                </tr>
        </tbody>
    </table>
    <p class="texto-centrado">Información impresa el día {{ $fecha }} a las {{ $hora }}</p>
</body>

</html>