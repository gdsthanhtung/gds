@extends('admin.main')

@section('content')
    <div class="right_col" role="main">
        @include($pathViewTemplate . 'page_header',
            [
                'title' => $pageTitle,
                'button' => '<a href="'.route($ctrl).'" class="btn btn-info"><i class="fa fa-arrow-left"></i> Quay lại</a>'
            ])

        @if (session('notify'))
            @include($pathViewTemplate . 'notify')
        @endif

        <div class="row">
            @include($pathViewTemplate . 'error')

            @include($pathView.'form_hd')
            @if($id) @include($pathView.'form_nk') @endif
        </div>
    </div>
@endsection
