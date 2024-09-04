@extends('admin.main')

@section('content')
    @php
        $exportHD = ($id) ? '<a href="'.route($ctrl.'/export', ['id' => $id]).'" target="_blank" class="btn btn-sm btn-primary mr-5"><i class="bi bi-download"></i> Xuất hóa đơn</a>' : '';
    @endphp

    @include($pathViewTemplate . 'page_header',
    [
        'title' => $pageTitle,
        'button' => $exportHD.'<a href="'.route($ctrl).'" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Quay lại</a>'
    ])

    @if (session('notify'))
        @include($pathViewTemplate . 'notify')
    @endif

    <section class="section">
        @include($pathViewTemplate . 'error')

        @if($id)
            @include($pathView.'form_hd_view')
        @else
            @include($pathView.'form_hd')
        @endif

    </section>
@endsection
