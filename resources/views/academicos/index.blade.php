@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <table id="table_data" class="display">
                    <thead>
                    <tr>
                        <th>No. Personal</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($academicos as $academico)
                        <tr>
                            <td>{{$academico->NoPersonalAcademico ?? ""}}</td>
                            <td>
                                {{$academico->usuario->datosPersonales->ApellidoPaternoDatosPersonales ?? ""}}
                                {{$academico->usuario->datosPersonales->ApellidoMaternoDatosPersonales ?? "-"}}
                                {{$academico->usuario->datosPersonales->NombreDatosPersonales ?? ""}}
                            </td>
                            <td>{{$academico->usuario->email ?? ""}}</td>
                            <td>
                                <a href="#" class="btn">Detalles</a> |
                                <a href="#" class="btn">Editar</a> |
                                <a href="#" class="btn">Eliminar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>No. Personal</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/css/jquery.dataTables.min.css')}}"/>
    {{--<link rel="stylesheet" href="lib/datatables/css/dataTables.bootstrap4.css">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('lib/datatables/extentions/buttons/buttons.dataTables.min.css')}}"/>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('lib/jquery/jquery-3.5.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/datatables/js/jquery.dataTables.min.js')}}" defer></script>
    {{--<script type="text/javascript" src="lib/datatables/js/dataTables.bootstrap4.min.js" defer></script>--}}
    <script type="text/javascript" src="{{asset('lib/datatables/extentions/buttons/dataTables.buttons.min.js')}}" defer></script>
    <script>
        $(document).ready( function () {
            $('#table_data').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Nuevo',
                        action: function ( e, dt, node, config ) {
                            alert( 'Acciones Nuevo Evento' );
                        }
                    }
                ]
            } );
        } );
    </script>
@endsection
