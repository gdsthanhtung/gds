@extends('admin.main')

@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;

    $formLabelClass = Config::get('custom.template.formLabel.class');
    $formInputClass = Config::get('custom.template.formInput.class');

    $name           = $id ? $data['name'] : '';
    $status         = $id ? $data['status'] : '';

    $hiddenID       = Form::hidden('id', $id);

    $statusEnum     = Config::get('custom.enum.selectStatus');

    $element = [
        [
            'label' => Form::label('name', 'Name', ['class' => $formLabelClass]),
            'el'    => Form::text('name', $name, ['class' => $formInputClass, 'required' => 'required'])
        ],
        [
            'label' => Form::label('status', 'Status', ['class' => $formLabelClass]),
            'el'    => Form::select('status', $statusEnum, $status, ['class' => $formInputClass, 'placeholder' => 'Select a status...'])
        ],
        [
            'el' => $hiddenID . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
        ]
    ];
@endphp

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

        <!--box-form-->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    @include($pathViewTemplate . 'x_title', ['title' => (1) ? 'Điều chỉnh' : 'Thêm mới'])

                    @include($pathViewTemplate . 'error')

                    <div class="x_content">
                        {!!
                            Form::open([
                                'url' => route($ctrl.'/save'),
                                'accept-charset' => 'UTF-8',
                                'method' => 'POST',
                                'enctype' => 'multipart/form-data',
                                'class' => 'form-horizontal form-label-left',
                                'id' => 'main-form'
                            ])
                        !!}

                            {!! FormTemplate::export($element) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--end-box-form-->
    </div>
@endsection
