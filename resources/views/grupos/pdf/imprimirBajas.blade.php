@extends('layouts.plantilla')
@section('content')


{{-- TODO: Actualizar el formato de presentación, preguntar --}}

<body>

    <h4 class="card-title col-12 contenedor-botones texto-primario">
        <strong>{{$grupos[0]->NombreGrupo}}</strong> - Cohorte {{$grupos[0]->cohorte->NombreCohorte}}
    </h4>

    <br>
    <hr class="mx-5">
    <h6 class="contenedor-botones pb-3 text-muted">Bajas totales</h6>
    <div class="table-responsive-xl">
        <table class="table " id="table_sede">
            <thead class="bg-table">
                <tr>
                    <th scope="col" class="border-right"></th>
                    <th scope="col" class="border-right">Hombres</th>
                    <th scope="col" class="border-right">Mujeres</th>
                    <th scope="col" class="border-right">Total</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border-right">Temporal</td>
                    <td class="border-right">{{$hombreTemporal}}</td>
                    <td class="border-right">{{$mujerTemporal}}</td>
                    <td class="border-right">{{$hombreTemporal + $mujerTemporal}}</td>
                </tr>
                <tr>
                    <td class="border-right">Definitiva</td>
                    <td class="border-right">{{$hombreDefinitivo}}</td>
                    <td class="border-right">{{$mujerDefinitivo}}</td>
                    <td class="border-right">{{$hombreDefinitivo + $mujerDefinitivo}}</td>
                </tr>
                <tr>
                    <th scope="col" colspan="3" class="text-align-right"><strong>Total de bajas de
                            Estudiantes</strong></th>
                    <td><strong>{{$hombreTemporal + $mujerTemporal + $hombreDefinitivo + $mujerDefinitivo}}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>
    <hr class="mx-5">
    <h6 class="contenedor-botones pb-3 text-muted">Bajas por motivo</h6>
    <div class="table-responsive-xl">
        <table class="table table-striped table-hover">

            <thead class="bg-table">
                <tr class="text-white">
                    <th scope="col" class="border-right">Motivo</th>
                    <th scope="col" class="border-right">Hombres</th>
                    <th scope="col" class="border-right">Mujeres</th>
                    <th scope="col" class="border-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($motivos as $motivo)
                @if(!empty($resultados))
                @if(isset($resultados[$motivo->IdMotivo]))
                <tr>
                    <th scope="row" class="border-right">{{$motivo->NombreMotivo}}</th>
                    <td class="border-right">{{$resultados[$motivo->IdMotivo - 1 ]["hombre"]}}</td>
                    <td class="border-right">{{$resultados[$motivo->IdMotivo - 1 ]["mujer"]}}</td>
                    <td class="border-right">
                        <strong>{{$resultados[$motivo->IdMotivo - 1 ]["hombre"] + $resultados[$motivo->IdMotivo]["mujer"]}}</strong>
                    </td>
                </tr>
                @else
                <tr>
                    <th scope="row" class="border-right">{{$motivo->NombreMotivo}}</th>
                    <td class="border-right">0</td>
                    <td class="border-right">0</td>
                    <td class="border-right"><strong>0</strong></td>
                </tr>
                @endif
                @else
                <tr>
                    <th scope="row" class="border-right">{{$motivo->NombreMotivo}}</th>
                    <td class="border-right">0</td>
                    <td class="border-right">0</td>
                    <td class="border-right"><strong>0</strong></td>
                </tr>
                @endif
                @endforeach
                <tr>
                    <th scope="col" colspan="3" class="text-align-right"><strong>Total de bajas de
                            Estudiantes</strong></th>
                    <td><strong>{{$hombreTemporal + $mujerTemporal + $hombreDefinitivo + $mujerDefinitivo}}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    </div>
    </div>
</body>
@endsection

</html>