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

        @if (session('success'))
            <div x-data="{ open: true }"
                x-show="open" xtransition
                x-transition:enter.duration.500ms
                x-transition:leave.duration.400ms
                x-init="setTimeout(() => open = false, 1000)"
                class="alert alert-success position-fixed top-2" role="alert"
            >
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>
@endsection



@section('script')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
