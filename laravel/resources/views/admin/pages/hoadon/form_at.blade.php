@php

@endphp

<div class="col-md-3 col-sm-3 col-xs-3">
    <div class="x_panel">
        @include($pathViewTemplate . 'x_title', [
            'title' => 'Chức năng',
        ])

        <div class="x_content">
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p><a href="{{route($ctrl.'/export', ['id' => $id])}}" target="_blank" class="btn btn-warning">In hóa đơn</a></p>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                </div>
            </div>
        </div>
    </div>
</div>
