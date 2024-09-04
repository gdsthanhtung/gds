@if(session('notify'))
    @php
        $type = session('notify')['type'];
        $message = session('notify')['message'];
        $icon = ($type == 'success') ? 'bi-check-circle' : 'bi-exclamation-octagon';
    @endphp

    <div class="col-12">
        <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
            <i class="bi {{ $icon }} me-1"></i>
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    </div>
@endif
