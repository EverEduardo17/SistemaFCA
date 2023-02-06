@extends('layouts.plantilla')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.mostrarCohorte') }}">Gestión de Estudiantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cohortes.show', $cohorte->NombreCohorte) }}">Cohorte
                {{$cohorte->NombreCohorte}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Estado</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <h4 class="card-title col-12 contenedor-botones texto-primario"><strong>
                    Cohorte {{$cohorte->NombreCohorte}}</strong></h4>
        </div>

    </div>
    <div class="card-body">
        <h5 class="pt-0 mt-0 mb-3 contenedor-botones text-muted">Estado</h5>
        <h6 class="pt-0 mt-0 mb-3 contenedor-botones text-muted">Último periodo registrado: {{ $ultimoPeriodo }}</h6>
        <div class="row justify-content-center  mt-3">
            <a class="btn btn-outline-info px-6 mb-3" href="{{ route('cohortes.mostrarResumen', [$cohorte->NombreCohorte]) }}"
                role="button">Ver Resumen</a>
            <a class="btn btn-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEstadoCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Estado</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarEgresadosCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Egresados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarTrasladosCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Traslados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarReprobadosCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Reprobados</a>
            <a class="btn btn-outline-info px-6 mb-3 ml-2"
                href="{{ route('cohortes.mostrarBajasCohorte', [$cohorte->NombreCohorte]) }}" role="button">Ver
                Bajas</a>
        </div>
        <a class="btn btn-outline-success float-right mb-3"
        href="{{ route('cohortes.imprimirEstadoCohorte', [$cohorte->NombreCohorte]) }}"
        target="_blank" role="button"><em class="fas fa-save"></em> Guardar PDF</a>
        
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered" id="table_sede">
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
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Hombres: &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["activoHombre"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Mujeres: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["activoMujer"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td><strong>Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["totalActivos"]}}</strong></td>
                        @endfor
                    </tr>
                    
                    <tr>
                        <th rowspan="3">Egresados</th>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Hombres: &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadoHombre"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Mujeres: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["egresadoMujer"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td><strong>Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["totalEgresados"]}}</strong></td>
                        @endfor
                    </tr>
                    <tr>
                        <th rowspan="3">Bajas</th>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Hombres: &nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["bajaHombre"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td>Mujeres: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["bajaMujer"]}}</td>
                        @endfor
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $tamanioProgramas; $i++)
                            <td><strong>Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$informacionPorPrograma[$i]["totalBajas"]}}</strong></td>
                        @endfor
                    </tr>
                    
                </tbody>
            </table>
        </div>
        {{-- <div class="row col-12">
            <canvas id="myChart" width="200" height="200"></canvas>
        </div> --}}
    </div>
</div>


@endsection

@section('head')

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.0/dist/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
    integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
</script>
{{-- <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Activos H.', 'Activos M.', 'Egresados H.', 'Egresados M.', 'Traslados E. H.', 'Traslados E. M.', 'Traslados S. H.', 'Traslados S. M', 'Bajas H.', 'Bajas M.'],
            datasets: [{
                label: 'Resumen {{$grupos[0]->NombreGrupo}} - {{$grupos[0]->cohorte->NombreCohorte}}',
data:
[{{ $activoHombre}},{{ $activoMujer }},{{ $egresadoHombre }},{{ $egresadoMujer }},{{ $entranteHombre }},{{ $entranteMujer }},{{ $salienteHombre }},
{{ $salienteMujer }},{{ $bajaHombre }},{{ $bajaMujer }}],
backgroundColor: [
'rgba(54, 162, 235, 0.2)',
'rgba(255, 99, 132, 0.2)'

],
borderColor: [
'rgba(54, 162, 235, 1)',
'rgba(255, 99, 132, 1)'
],
borderWidth: 1
}]
},
options: {
scales: {
y: {
beginAtZero: true
}
}
}
});
</script> --}}

@endsection