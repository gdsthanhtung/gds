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

        <div class="row">
            @if($id) <div class="col-6"> @else <div class="col-6 offset-3"> @endif
                @include($pathView.'form_hd')
            </div>

            @if($id)
                <div class="col-6">
                    @include($pathView.'form_nk')
                    @include($pathView.'form_at')
                </div>
            @endif
        </div>

    </section>
@endsection
