@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass             = Config::get('custom.template.formLabel.class');
    $formInputClass             = Config::get('custom.template.formInput.class');


    $status         = $id ? $data['status'] : '';
    $statusEnum     = Config::get('custom.enum.selectStatus');

    $element = [
        [
            'label' => Form::label('cong_dan', 'Công Dân', ['class' => $formLabelClass]),
            'el'    => Form::select('cong_dan', $dataCongDan, $status, ['class' => $formInputClass.' multiple-checkboxes', 'multiple' => 'multiple'])
        ]
    ];
@endphp

<div class="col-md-5 col-sm-5 col-xs-5">
    <div class="x_panel">
        @include($pathViewTemplate . 'x_title', ['title' => ($id) ? 'Điều chỉnh Nhân khẩu' : 'Thêm mới Nhân khẩu'])

        <div class="x_content">
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
