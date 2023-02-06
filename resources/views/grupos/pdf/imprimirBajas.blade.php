<html>

<head>
    <title>Bajas {{$grupos[0]->NombreGrupo}} - Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</title>
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

    <h6 class="subtitulo">Bajas totales</h6>
    <table class="table " id="table_bajas">
        <thead class="bg-table">
            <tr>
                <th scope="col"></th>
                <th scope="col">Hombres</th>
                <th scope="col">Mujeres</th>
                <th scope="col">Total</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="texto-izquierda">Temporal</th>
                <td>{{$hombreTemporal}}</td>
                <td>{{$mujerTemporal}}</td>
                <td>{{$hombreTemporal + $mujerTemporal}}</td>
            </tr>
            <tr>
                <th class="texto-izquierda">Definitiva</th>
                <td>{{$hombreDefinitivo}}</td>
                <td>{{$mujerDefinitivo}}</td>
                <td>{{$hombreDefinitivo + $mujerDefinitivo}}</td>
            </tr>
            <tr>
                <th scope="col" colspan="3" class="texto-izquierda"><strong>Total de bajas de Estudiantes</strong></th>
                <td><strong>{{$hombreTemporal + $mujerTemporal + $hombreDefinitivo + $mujerDefinitivo}}</strong>
                </td>
            </tr>
        </tbody>
        <caption>Estudiantes dados de baja registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}}
            del cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
    </table>

    <br>
    <hr class="mx-5">
    <h6 class="subtitulo">Bajas por motivo</h6>

    <table class="table">

        <thead class="bg-table">
            <tr class="text-white">
                <th scope="col">Motivo</th>
                <th scope="col">Hombres</th>
                <th scope="col">Mujeres</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($motivos as $motivo)
            @if(!empty($resultados))
            @if(isset($resultados[$motivo->IdMotivo]))
            <tr>
                <th scope="row" class="texto-izquierda">{{$motivo->NombreMotivo}}</th>
                <td>{{$resultados[$motivo->IdMotivo - 1 ]["hombre"]}}</td>
                <td>{{$resultados[$motivo->IdMotivo - 1 ]["mujer"]}}</td>
                <td>
                    <strong>{{$resultados[$motivo->IdMotivo - 1 ]["hombre"] + $resultados[$motivo->IdMotivo]["mujer"]}}</strong>
                </td>
            </tr>
            @else
            <tr>
                <th scope="row" class="texto-izquierda">{{$motivo->NombreMotivo}}</th>
                <td>0</td>
                <td>0</td>
                <td><strong>0</strong></td>
            </tr>
            @endif
            @else
            <tr>
                <th scope="row" class="texto-izquierda">{{$motivo->NombreMotivo}}</th>
                <td>0</td>
                <td>0</td>
                <td><strong>0</strong></td>
            </tr>
            @endif
            @endforeach
            <tr>
                <th scope="col" colspan="3" class="texto-izquierda"><strong>Total de bajas de Estudiantes</strong></th>
                <td><strong>{{$hombreTemporal + $mujerTemporal + $hombreDefinitivo + $mujerDefinitivo}}</strong>
                </td>
            </tr>
        </tbody>
        <caption>Estudiantes dados de baja por motivo registrados en el sistema para el grupo
            {{$grupos[0]->NombreGrupo}}
            del cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
    </table>
    <p class="texto-centrado">Información impresa el día {{ $fecha }} a las {{ $hora }}</p>
</body>

</html>