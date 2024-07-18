@extends('admin.main')

@section('content')
    <div class="right_col" role="main">
        @include($pathViewTemplate . 'page_header',
            [
                'title' => ucfirst($ctrl),
                'button' => '<a href="'.route($ctrl).'" class="btn btn-info"><i class="fa fa-arrow-left"></i> Quay lại</a>'
            ])

        @if (session('notify'))
            @include($pathViewTemplate . 'notify')
        @endif

        @if ($id)
            <div class="row">
                @include($pathViewTemplate . 'error')

                @include($pathView.'form_edit')
                @include($pathView.'form_change_password')
            </div>
        @else
            @include($pathView.'form_add')
        @endif
    </div>
@endsection
