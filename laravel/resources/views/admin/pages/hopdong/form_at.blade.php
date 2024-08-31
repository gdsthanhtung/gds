@php
    use App\Helpers\Template;
@endphp

<div class="col-md-7 col-sm-7 col-xs-7">
    <div class="x_panel">
        @include($pathViewTemplate . 'x_title', [
            'title' => 'Chức năng',
        ])

        <div class="x_content">
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p>
                        {!! Template::ct01($data['cong_dan_id'], 'NEW', true) . Template::ct01($data['cong_dan_id'], 'GH', true) !!}
                    </p>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                </div>
            </div>
        </div>
    </div>
</div>
