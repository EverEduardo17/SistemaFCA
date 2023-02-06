<html>

<head>
    <title>Reprobados Cohorte {{$cohorte->NombreCohorte}}</title>
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

<body>
    <script type="text/php">
        if (isset($pdf)) {
            $x = 270;
            $y = 800;
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $font = null;
            $size = 10;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
    <h4 class="titulo">
        <strong>Cohorte {{$cohorte->NombreCohorte}}
    </h4>
    <h5 class="titulo-tercero">Último periodo actualizado: {{ $ultimoPeriodo }}</h5>
    <hr class="mx-5">
    <h6 class="subtitulo">Reprobados</h6>
    <table class="table table-striped table-hover table-bordered" id="table_egresados">
        <caption>Estudiantes reprobados registrados en el sistema para el cohorte {{$cohorte->NombreCohorte}}
            clasificados
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
                <th rowspan="3">Reprobados</th>
                @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Hombres:
                    &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["reprobadoHombre"]}}</td>
                    @endfor
            </tr>
            <tr>
                @for ($i = 0; $i < $tamanioProgramas; $i++) <td>Mujeres:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["reprobadoMujer"]}}</td>
                    @endfor
            </tr>
            <tr>
                @for ($i = 0; $i < $tamanioProgramas; $i++) <td><strong>Total:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["totalReprobados"]}}</strong>
                    </td>
                    @endfor
            </tr>
        </tbody>
    </table>
    <br>
    <div style="page-break-after:always;"></div>
    <hr class="mx-5">
    <h6 class="subtitulo">Reprobados por periodo</h6>
    <table class="table table-striped table-hover table-bordered" id="table_periodos">
        <caption>Estudiantes reprobados clasificados por periodo registrados en el sistema para el cohorte
            {{$cohorte->NombreCohorte}}.</caption>
        <thead class="bg-table">
            <tr class="text-white">
                <th scope="col" class="border-right">Periodo</th>
                @foreach ($programas as $programa)
                <th scope="col" class="border-right">{{ $programa->AcronimoProgramaEducativo }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($periodos as $periodo)
            @if ($loop->index <= $totalPeriodos ) <tr>
                <th class="border-right border-left" rowspan="3">{{$periodo->NombrePeriodo}}</th>
                @for ($i = 0; $i < $tamanioProgramas; $i++)
                    @if(!empty($informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["hombre"]))
                    <td class="border-right">
                        Hombres:&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["hombre"]}}
                    </td>
                    @else
                    <td class="border-right">Hombres:&nbsp;&nbsp;&nbsp;&nbsp;0</td>
                    @endif
                    @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            @if(!empty($informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["mujer"]))
                            <td>Mujeres:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["mujer"]}}
                            </td>
                            @else
                            <td>Mujeres:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0</td>
                            @endif
                            @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            @if(!empty($informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["total"]))
                            <td><strong>Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadosPorPeriodo"][$loop->index]["total"]}}</strong>
                            </td>
                            @else
                            <td><strong>Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0</strong>
                            </td>
                            @endif
                            @endfor
                    </tr>
                    @endif
                    @endforeach
        </tbody>
    </table>
    <p class="texto-centrado">Información impresa el día {{ $fecha }} a las {{ $hora }}</p>

</body>

</html>