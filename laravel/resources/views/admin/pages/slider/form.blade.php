@extends('admin.main')

@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;

    $formLabelClass = Config::get('custom.template.formLabel.class');
    $formInputClass = Config::get('custom.template.formInput.class');

    $name           = $id ? $data['name'] : '';
    $description    = $id ? $data['description'] : '';
    $link           = $id ? $data['link'] : '';
    $status         = $id ? $data['status'] : '';
    $thumb          = $id ? $data['thumb'] : '';

    $hiddenID       = Form::hidden('id', $id);
    $hiddenThumb    = Form::hidden('thumb', $thumb);

    $statusEnum     = Config::get('custom.enum.selectStatus');

    $element = [
        [
            'label' => Form::label('name', 'Name', ['class' => $formLabelClass]),
            'el'    => Form::text('name', $name, ['class' => $formInputClass, 'required' => 'required'])
        ],
        [
            'label' => Form::label('description', 'Description', ['class' => $formLabelClass]),
            'el'    => Form::text('description', $description, ['class' => $formInputClass, 'required' => 'required'])
        ],
        [
            'label' => Form::label('status', 'Status', ['class' => $formLabelClass]),
            'el'    => Form::select('status', $statusEnum, $status, ['class' => $formInputClass, 'required' => 'required', 'placeholder' => 'Select a status...'])
        ],
        [
            'label' => Form::label('link', 'Link', ['class' => $formLabelClass]),
            'el'    => Form::text('link', $link, ['class' => $formInputClass, 'required' => 'required'])
        ],
        [
            'label' => Form::label('thumb', 'Thumb', ['class' => $formLabelClass]),
            'el'    => Form::file('thumb', ['class' => $formInputClass, 'required' => 'required']),
            'thumb' => ($thumb) ? Template::showItemThumb($ctrl, $thumb, $name) : null,
            'type'  => 'thumb'
        ],
        [
            'el' => $hiddenID . $hiddenThumb . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
        ]
    ];
@endphp

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

        <!--box-form-->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    @include($pathViewTemplate . 'x_title', ['title' => (1) ? 'Điều chỉnh' : 'Thêm mới'])

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
