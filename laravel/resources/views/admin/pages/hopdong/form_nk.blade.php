@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass = Config::get('custom.template.formLabel.class');
    $formInputClass = Config::get('custom.template.formInput.class');

    $congDanId = $id ? $data['cong_dan_id'] : '';
    $hiddenCongDanId = Form::hidden('cong_dan_id_current', $congDanId);

    $status = $id ? $data['status'] : '';
    $statusEnum = Config::get('custom.enum.selectStatus');
    $mqhEnum = Config::get('custom.enum.mqh');


    $hiddenID = Form::hidden('hop_dong_id', $id);
    $hiddenMqhID = Form::hidden('mqh_id', '');
    $hiddenCdID = Form::hidden('cong_dan_id', '');

    $initNkSelected = '<div class="alert alert-warning alert-dismissible init-nk-selected">Vui lòng chọn nhân khẩu từ danh sách bên cạnh!</div>';
    $divSix = '<div class="col-md-9 col-sm-9 col-xs-9" style="padding-left: 0; padding-bottom: 10px;">';

    $element = [
        [
            'label'     => Form::label('cong_dan_list', 'Công Dân', ['class' => $formLabelClass. 'multiselect-container']),
            'el'        => Form::select('cong_dan_list', $dataCongDan, 0, ['class' => $formInputClass, 'placeholder' => 'Select an item...' ]),
            'elClass'   => 'col-md-9 col-sm-9 col-xs-9'
        ],
        [
            'label'     => Form::label('mqh_list', 'MQH với Chủ Hộ', ['class' => $formLabelClass. 'multiselect-container']),
            'el'        => $divSix.Form::select('mqh_list', $mqhEnum, 0, ['class' => $formInputClass, 'placeholder' => 'Select an item...' ]).'</div>'.Form::button('Thêm', ['class' => 'btn btn-primary', 'id' => 'add-cong-dan']),
            'elClass'   => 'col-md-9 col-sm-9 col-xs-9'
        ],
        [
            'el'        => $hiddenID . $hiddenMqhID . $hiddenCdID . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'      => 'btn-submit',
        ],
    ];
@endphp

<div class="col-md-7 col-sm-7 col-xs-7">
    <div class="x_panel">
        @include($pathViewTemplate . 'x_title', [
            'title' => $id ? 'Điều chỉnh Nhân khẩu' : 'Thêm mới Nhân khẩu',
        ])

        <div class="x_content">
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div id="listNK">{!! $initNkSelected !!}</div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                    {!! Form::open([
                        'url' => route('nhankhau/save'),
                        'accept-charset' => 'UTF-8',
                        'method' => 'POST',
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal form-label-left',
                        'id' => 'main-form',
                    ]) !!}
                    {!! FormTemplate::export($element) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
