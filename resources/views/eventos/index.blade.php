@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Eventos</li>
    </ol>
</nav>
<div class="container" style="max-width: 100%">
    <div class="row justify-content-center" style="margin: 0; max-width: 100%">
        <div style="width: 100%">
            <div style="display: inline-flex; width: 100%; justify-content: space-between; margin-bottom: 1rem;">
                <h4>Fechas de Eventos</h4>
                @can('havepermiso', 'eventos-crear')
                    <a class="btn btn-primary btn-lg" href="{{route('eventos.create')}}">Registrar un evento</a>
                @endcan
            </div>
            <form action="{{ route('eventos.index') }}" method="GET" style="display: flex">
                <div class="form-group" style="display: flex; align-items: center; gap: 1rem">
                    <label for="lista-filtrar" style="white-space: nowrap; margin: 0%">Filtrar por estado:</label>

                    <select name="estado" id="lista-filtrar" class="form-control" onchange="this.form.submit()">
                        <option value="" @if($estado === '') selected @endif>Todos</option>
                        <option value="APROBADO" @if($estado === 'APROBADO') selected @endif>Aprobado</option>
                        <option value="NO APROBADO" @if($estado === 'NO APROBADO') selected @endif>No aprobado</option>
                        <option value="POR APROBAR" @if($estado === 'POR APROBAR') selected @endif>Pendiente</option>
                    </select>

                    <label style="white-space: nowrap; margin: 0%">Filtrar por fecha:</label>

                    <div class="d-inline-flex bg-light btn">
                        <input class="ml-2" type="radio" name="filtro_fecha" value="ANTERIORES" @if($filtro_fecha === 'ANTERIORES') checked @endif onchange="this.form.submit()">
                        <label class="mx-2">Anteriores</label>
    
                        <input class="ml-3" type="radio" name="filtro_fecha" value="PROXIMOS" 
                        @if($filtro_fecha === 'PROXIMOS') checked @endif onchange="this.form.submit()">
    
                        <label class="mx-2">Proximos</label>
                        <input class="ml-3" type="radio" name="filtro_fecha" value="TODOS" @if($filtro_fecha === 'TODOS' || $filtro_fecha === null) checked @endif onchange="this.form.submit()">
                        <label class="mx-2">Todos</label>
                    </div>
                </div>
            </form>
            <div>
                <div id="calendario">
                    <input id="buscadorCalendario" placeholder="Buscar evento..." style="display: none"></input>
                    <div id="calendar"></div>
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

    #buscadorCalendario {
        width: 95%;
        margin: 1rem;
        margin-top: 0;
        padding-left: 0.5rem;
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
    });
</script>

<!-- Full Calendar -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
    const searchBar = document.getElementById("buscadorCalendario")
    let calendar;

    function showBar() {
        searchBar.style = "display: inline"
    }
    function hiddeBar() {
        searchBar.style = "display: none"
    }

    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        const toolbar = {
            left: "prev,next today",
            center: "title",
            right: "listYear,dayGridMonth,timeGridWeek"
        }
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: '{{ $filtro_fecha === 'PROXIMOS' ? 'listYear' : 'dayGridMonth' }}',
            locale: "es",
            headerToolbar: toolbar,
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Dia',
                list: 'Lista'
            },
            noEventsContent: "No se encontraron eventos",
            dateClick: function(info) {
                let day = 0
                let month = 0
                let year = 0
                const partes = info.dateStr.split("-")
                day = partes[2]
                month = partes[1]
                year = partes[0]
                @can('havepermiso','eventos-crear')
                    window.location.href = "{{ route('eventos.create') }}?day=" + day + "&month=" + month + "&year=" + year;
                @endcan
            },
            viewDidMount: function(info) {
                if (info.view.type.match("list")) {
                    showBar()
                }
            },
            viewWillUnmount: function(info) {
                hiddeBar()
            },
            eventDidMount: function(info) {
                tippy(info.el, {
                    content: info.event.title,
                })
            },
            events: function (fetchInfo, successCallback, failureCallback) {
                let eventos = @json($calendar_events);
                let filtro = searchBar.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f-]/g,"")
                const keys = filtro.split(/ {1,}/g)
                let filtrados = eventos.filter(ev => {
                    return keys.every(key => {
                        return ev.title.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f-]/g,"").includes(key)
                    })
                })
                successCallback(filtrados);
            }
        });
        calendar.render();
        const headerToolbar = document.querySelector('.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr')
        headerToolbar.parentNode.insertBefore(searchBar, headerToolbar.nextSibling)
    });

    searchBar.addEventListener("input", () => {
        calendar.refetchEvents()
    })
</script>
@endsection
