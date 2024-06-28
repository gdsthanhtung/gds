@php
    $type = session('notify')['type'];
    $message = session('notify')['message'];
@endphp

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="alert alert-{{ $type }} alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            {{ $message }}
        </div>
    </div>
</div>
