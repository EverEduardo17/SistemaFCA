@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Eventos</li>
    </ol>
</nav>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 text-center">
            <h4>Fechas de Eventos</h4>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-4 mb-3 text-center">
            <hr>
            <div id="dateStart" class="ui-datepicker-div"></div>
            <hr>
            @can('havepermiso', 'eventos-crear')
                <a class="btn btn-primary btn-lg" href="{{route('eventos.create')}}">Registrar un evento</a>
            @endcan
        </div>
        <div class="col-lg-9 col-md-8">
        <!--<button class="btn btn-secondary mb-2" id="filterButton">Filtrar eventos</button>-->

            <form action="{{ route('eventos.index') }}" method="GET" style="display: flex">
                <div class="form-group" style="display: flex; align-items: center; gap: 1rem">
                    <label for="lista-filtrar" style="white-space: nowrap; margin: 0%">Filtrar por estado:</label>
                    <select name="estado" id="lista-filtrar" class="form-control">
                        <option value="">Todos</option>
                        <option value="APROBADO">Aprobado</option>
                        <option value="NO APROBADO">No aprobado</option>
                        <option value="POR APROBAR">Pendiente</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="display: inline-block; margin-left: 2rem; margin-bottom: 10px; height: fit-content">Filtrar</button>
            </form>
            <div class="nav nav-tabs" style="margin-bottom: 1rem">
                <button id="tab-calendario" value="calendario" class="nav-link nav-link-focused">Calendario</button>
                <button id="tab-tabla" value="tabla" class="nav-link">Tabla</button>
            </div>
            <div>
                <div id="calendario">
                    <div id="calendar"></div>
                </div>
                <div id="tabla" style="display: none">
                    <table id="table-jquery" class="display border-bottom" style="">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Sede</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evento_fecha_sede_s as $efs)
                            <tr>
                                <td>{{$efs->fechaEvento->InicioFechaEvento ?? ""}}</td>
                                <td>{{$efs->evento->NombreEvento ?? ""}}</td>
                                <td>{{$efs->sedeEvento->NombreSedeEvento ?? ""}}</td>
                                <td>{{$efs->evento->EstadoEvento ?? ""}}</td>
                                <td>
                                    @can('havepermiso', 'eventos-leer')
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('eventos.show', [$efs->IdEvento]) }}"> Detalles</a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- {{ dd($calendar_events) }} --}}

@endsection

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}" />
<!-- Datepicker Files -->
<link rel="stylesheet" href="{{asset('lib/datePicker/css/bootstrap-datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('lib/datePicker/css/bootstrap-datepicker3.standalone.min.css')}}">
<style>
    .ui-datepicker-div {
        width: 220px;
        margin-left: auto;
        margin-right: auto;
    }

    .nav-link-focused {
        background: #007bff;
        color: aliceblue;
    }
</style>
@endsection

@section('script')
<script src="{{ asset('js/table-script.js') }}"></script>
<script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
<!-- DatePicker -->
<script src="{{asset('lib/datePicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('lib/datePicker/locales/bootstrap-datepicker.es.min.js')}}"></script>

<script>
    $('#dateStart').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: 2,
        language: "es"
    }).on('changeDate', function(e) {
        window.location.href = "{{route('eventos.index')}}" +
            "/" + e.date.getFullYear() +
            "/" + (e.date.getMonth() + 1) +
            "/" + e.date.getDate();
        //console.log(e.date.toISOString().slice(0,10) );
    });
</script>

<!-- Vistas -->
<script defer>
    const tabCalendario = document.getElementById("tab-calendario")
    const tabTabla = document.getElementById("tab-tabla")
    const calendario = document.getElementById("calendario")
    const tabla = document.getElementById("tabla")

    function changeTab(evt) {
        tabCalendario.classList.remove("nav-link-focused")
        tabTabla.classList.remove("nav-link-focused")
        evt.target.classList.add("nav-link-focused")
        calendario.style = "display: none"
        tabla.style = "display: none"
        document.getElementById(evt.target.value).style = "display: block"
    }

    tabCalendario.addEventListener("click", changeTab)
    tabTabla.addEventListener("click", changeTab)
</script>

<!-- Full Calendar -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        const toolbar = {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,listYear"
        }
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: "es",
            headerToolbar: toolbar,
            footerToolbar: toolbar,
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Dia',
                list: 'Lista'
            },
            events: @json($calendar_events)
        });
        calendar.render();
    });
</script>
@endsection
