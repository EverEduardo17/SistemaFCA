@extends('layouts.app')

@section('content')
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
                <a class="btn btn-primary btn-lg" href="{{route('eventos_create')}}">Registrar un evento</a>
            </div>
            <div class="col-lg-9 col-md-8">
                <table id="table_eventos" class="display">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Sede</th>
                            <th>Estado</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($evento_fecha_sede_s as $efs)
                        <tr>
                            <td>{{$efs->fechaEvento->InicioFechaEvento ?? ""}}</td>
                            <td>{{$efs->evento->NombreEvento ?? ""}}</td>
                            <td>{{$efs->sedeEvento->NombreSedeEvento ?? ""}}</td>
                            <td>{{$efs->evento->EstadoEvento ?? ""}}</td>
                            <td><a href="{{route('eventos_show', [$efs->IdEvento])}}" /> Detalles </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Sede</th>
                            <th>Estado</th>
                            <th>Estado</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}"/>
    <!-- Datepicker Files -->
    <link rel="stylesheet" href="{{asset('lib/datePicker/css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('lib/datePicker/css/bootstrap-datepicker3.standalone.min.css')}}">
    <style>
        .ui-datepicker-div{
            width:220px;
            margin-left:auto;
            margin-right:auto;
        }
    </style>
@endsection

@section('script')

    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
    <!-- DatePicker -->
    <script src="{{asset('lib/datePicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('lib/datePicker/locales/bootstrap-datepicker.es.min.js')}}"></script>

    <script>
        $(document).ready( function () {
            $('#table_eventos').DataTable();
        } );
    </script>

    <script>
        $('#dateStart').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: 2,
            language: "es"
        }).on('changeDate', function(e) {
            window.location.href = "{{route('eventos')}}"
                + "/" + e.date.getFullYear()
                + "/" + (e.date.getMonth()+1)
                + "/" + e.date.getDate();
            //console.log(e.date.toISOString().slice(0,10) );
        });
    </script>
@endsection
