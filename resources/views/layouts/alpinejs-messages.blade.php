<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@if (session('success'))
<div x-data="{ open: true }"
    x-show="open" xtransition
    x-transition:enter.duration.500ms
    x-transition:leave.duration.400ms
    x-init="setTimeout(() => open = false, 1200)"
    class="alert alert-success position-fixed top-2" role="alert"
>
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div x-data="{ open: true }"
    x-show="open" xtransition
    x-transition:enter.duration.500ms
    x-transition:leave.duration.400ms
    x-init="setTimeout(() => open = false, 6000)"
    class="alert alert-danger position-fixed top-2" role="alert"
>
    {{ session('error') }}
</div>
@endif