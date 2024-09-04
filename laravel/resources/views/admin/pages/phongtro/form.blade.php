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
            'label' => Form::label('status', 'Trạng thái', ['class' => $formLabelClass]),
            'el'    => Form::select('status', $statusEnum, $status, ['class' => $formInputClass.' form-select', 'placeholder' => 'Select an item...'])
        ],
        [
            'el' => $hiddenID . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
        ]
    ];
@endphp

@section('content')
    <section class="section">
        @include($pathViewTemplate . 'page_header',
        [
            'title' => $pageTitle,
            'button' => '<a href="'.route($ctrl).'" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Quay lại</a>'
        ])

        @if (session('notify'))
            @include($pathViewTemplate . 'notify')
        @endif

        @include($pathViewTemplate . 'error')

        <div class="row">
            <div class="col-6 offset-3">
                <div class="card overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">{{ ($id) ? 'Điều chỉnh' : 'Thêm mới' }}</h5>
                        <div class="row">

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
        </div>
    </section>
@endsection
