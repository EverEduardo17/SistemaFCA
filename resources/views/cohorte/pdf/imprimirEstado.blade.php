<html>

<head>
    <title>Estado Cohorte {{$cohorte->NombreCohorte}}</title>
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
        .titulo-tercero {
            text-align: center;
            font-size: 1.0rem;
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

        .texto-centrado {
            text-align: center
        }

        .mx-5 {
            margin-left: 5rem;
            margin-right: 5rem;
        }
    </style>
</head>

<h4 class="titulo">
    <strong>Cohorte {{$cohorte->NombreCohorte}}
</h4>
<h5 class="titulo-tercero">Último periodo actualizado: {{ $ultimoPeriodo }}</h5>
<hr class="mx-5">
<h6 class="subtitulo">Estado</h6>

<table class="table" id="table_sede">
    <caption>Estudiantes registrados en el sistema para el cohorte {{$cohorte->NombreCohorte}} clasificados
        por Programa Educativo.</caption>
    <thead class="bg-table">
        <tr class="text-white">
            <th scope="col"></th>
            @foreach ($programas as $programa)
            <th scope="col">{{ $programa->AcronimoProgramaEducativo }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
        <tr>
            <th rowspan="3">Activos</th>
            @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Hombres:
                &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["activoHombre"]}}</td>
                @endfor
        </tr>
        <tr>
            @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Mujeres:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["activoMujer"]}}</td>
                @endfor
        </tr>
        <tr>
            @for ($i = 0; $i < $tamanioProgramas; $i++) <td><strong>Total:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["totalActivos"]}}</strong>
                </td>
                @endfor
        </tr>

        <tr>
            <th rowspan="3">Egresados</th>
            @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Hombres:
                &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadoHombre"]}}</td>
                @endfor
        </tr>
        <tr>
            @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Mujeres:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadoMujer"]}}</td>
                @endfor
        </tr>
        <tr>
            @for ($i = 0; $i < $tamanioProgramas; $i++) <td><strong>Total:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["totalEgresados"]}}</strong>
                </td>
                @endfor
        </tr>
        <tr>
            <th rowspan="3">Bajas</th>
            @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Hombres:
                &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["bajaHombre"]}}</td>
                @endfor
        </tr>
        <tr>
            @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Mujeres:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["bajaMujer"]}}</td>
                @endfor
        </tr>
        <tr>
            @for ($i = 0; $i < $tamanioProgramas; $i++) <td><strong>Total:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["totalBajas"]}}</strong>
                </td>
                @endfor
        </tr>

    </tbody>
</table>
<p class="texto-centrado">Información impresa el día {{ $fecha }} a las {{ $hora }}</p>

</body>

</html>