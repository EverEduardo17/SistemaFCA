@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach($opciones as $item)
            <div class="col-sm-4">
                <br />
                <div class="card ">
                    <div class="card-header card text-center border-light  text-white" style="background: {{$item['background']}}">{{$item['titulo']}}</div>
                    <ul class="list-group list-group-flush">
                        @foreach ( $item['operaciones'] as $operacion)
                            <li class="list-group-item"><a href="{{ url($item['enlace'].'/'.$operacion['enlace'])}}">{{$operacion['titulo']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
        
            <div class="col-sm-4">
                <br />
                <div class="card ">
                    <div class="card-header card text-center border-light  text-white" style="background: #00A639">Academias</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('academias.index') }}">Ver Academias</a></li>
                        <li class="list-group-item"><a href="{{ route('academias.create') }}">Nueva Academia</a></li>
                    </ul>
                </div>
            </div>
    </div>
</div>
@endsection
