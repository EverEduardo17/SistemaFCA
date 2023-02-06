<html>

<head>
    <title>Egresados {{$grupos[0]->NombreGrupo}} - Cohorte {{$grupos[0]->cohorte->NombreCohorte}}</title>
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
        <strong>{{$grupos[0]->NombreGrupo}}</strong> - Cohorte {{$grupos[0]->cohorte->NombreCohorte}}
    </h4>
    <hr class="mx-5">
    <h6 class="subtitulo">Egresados</h6>

    <table class="table table-striped table-hover table-bordered" id="table_sede">
        <caption>Estudiantes egresados registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del
            cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
        <thead class="bg-table">
            <tr class="text-white">
                <th scope="col" class="border-right"></th>
                <th scope="col" class="border-right">Hombres</th>
                <th scope="col" class="border-right">Mujeres</th>
                <th scope="col" class="border-right">Total</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="texto-izquierda">Egresados</th>
                <td>{{$hombre}}</td>
                <td>{{$mujer}}</td>
                <td><strong>{{$totalEgresados}}</strong></td>
            </tr>
        </tbody>
    </table>

    <br>
    <hr class="mx-5">
    <h6 class="subtitulo">Egresados por periodo</h6>
    <table class="table" >
        <caption>Estudiantes egresados por periodo registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}}
            del cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
        <thead class="bg-table">
            <tr class="text-white">
                <th scope="col" >Periodo</th>
                <th scope="col" >Hombres</th>
                <th scope="col" >Mujeres</th>
                <th scope="col" >Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periodos as $periodo)
                @if(!empty($egresadosPeriodo))
                    @if ($loop->index <= $totalPeriodos ) <tr>
                        <th scope="row" class="texto-izquierda">{{$periodo->NombrePeriodo}}</th>
                        <td>{{$egresadosPeriodo[$loop->index]["hombre"]}}</td>
                        <td>{{$egresadosPeriodo[$loop->index]["mujer"]}}</td>
                        <td>
                            <strong>{{$egresadosPeriodo[$loop->index]["hombre"] + $egresadosPeriodo[$loop->index]["mujer"]}}</strong>
                        </td>
                        </tr>
                    @endif
                @else
                    <tr>
                        <th scope="row" class="texto-izquierda">{{$periodo->NombrePeriodo}}</th>
                        <td>0</td>
                        <td>0</td>
                        <td><strong>0</strong></td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <th scope="col" colspan="3" class="texto-izquierda"><strong>Total de Estudiantes Egresados</strong></th>
                <td><strong>{{$totalEgresados}}</strong></td>
            </tr>
        </tbody>
    </table>
    
    <div style="page-break-after:always;"></div>
    <br>
    <hr class="mx-5">
    <h6 class="subtitulo">Egresados por modalidad</h6>
    <table class="table " >
        <caption>Estudiantes egresados por modalidad registrados en el sistema para el grupo {{$grupos[0]->NombreGrupo}} del
            cohorte {{$grupos[0]->cohorte->NombreCohorte}}.</caption>
        <thead class="bg-table">
            <tr class="text-white">
                <th scope="col">Modalidad</th>
                <th scope="col">Hombres</th>
                <th scope="col">Mujeres</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modalidades as $modalidad)
                @if(!empty($egresadosModalidad))
                    @if ($loop->index <= $totalModalidades ) <tr>
                        <th scope="row" class="texto-izquierda">{{$modalidad->NombreModalidad}}</th>
                        <td>{{$egresadosModalidad[$loop->index]["hombre"]}}</td>
                        <td>{{$egresadosModalidad[$loop->index]["mujer"]}}</td>
                        <td>
                            <strong>{{$egresadosModalidad[$loop->index]["hombre"] + $egresadosModalidad[$loop->index]["mujer"]}}</strong>
                        </td>
                        </tr>
                    @endif
                @else
                <tr>
                    <th scope="row" class="border-right">{{$modalidad->NombreModalidad}}</th>
                    <td class="border-right">0</td>
                    <td class="border-right">0</td>
                    <td class="border-right"><strong>0</strong></td>
                </tr>
                @endif
            @endforeach
            <tr>
                <th scope="col" colspan="3" class="texto-izquierda"><strong>Total de Estudiantes Egresados</strong></th>
                <td><strong>{{$totalEgresados}}</strong></td>
            </tr>
        </tbody>
    </table>
    <p class="texto-centrado">Información impresa el día {{ $fecha }} a las {{ $hora }}</p>
</body>

</html>