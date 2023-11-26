@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach($opciones as $item)
            @can('havepermiso', $item['permiso'])
                <div class="col-sm-4">
                    <br />
                    <div class="card ">
                        <div class="card-header card text-center border-light  text-white" style="background: {{ $item['background'] }}">{{ $item['titulo'] }}</div>
                        <ul class="list-group list-group-flush">
                            @foreach ( $item['operaciones'] as $operacion)
                                <li class="list-group-item shadow-sm"><a href="{{ route($item['enlace']. '.' .$operacion['enlace']) }}">{{ $operacion['titulo'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endcan
        @endforeach

        @include('layouts.alpinejs-messages')
    </div>
</div>
@endsection
