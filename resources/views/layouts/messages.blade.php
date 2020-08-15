@if( Session::has('flash') )
    @foreach( Session::get('flash') as $flash )
        <div class="alert alert-{{$flash['type'] ?? 'success'}} alert-dismissible ml-3 mr-3" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!! $flash['message'] ?? '' !!}
        </div>
    @endforeach
@endif
{{--success, info, warning, danger--}}
