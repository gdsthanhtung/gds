@extends('admin.main')

@section('content')
    @include($pathViewTemplate . 'page_header',
    [
        'title' => $pageTitle,
        'button' => '<a href="'.route($ctrl).'" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Quay lại</a>'
    ])

    @if (session('notify'))
        @include($pathViewTemplate . 'notify')
    @endif

    <section class="section">
        @include($pathViewTemplate . 'error')
        @if ($id)
            <div class="row">
                @include($pathView.'form_edit')
                @include($pathView.'form_change_password')
            </div>
        @else
            @include($pathView.'form_add')
        @endif
    </section>
@endsection
