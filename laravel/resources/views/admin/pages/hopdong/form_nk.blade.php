@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass     = Config::get('custom.template.formLabel.class');
    $formInputClass     = Config::get('custom.template.formInput.class');

    $congDanId          = $id ? $data['cong_dan_id'] : '';
    $hiddenCongDanId    = Form::hidden('cong_dan_id_current', $congDanId);

    $status             = $id ? $data['status'] : '';
    $statusEnum         = Config::get('custom.enum.selectStatus');
    $mqhEnum            = Config::get('custom.enum.mqh');

    $hiddenID           = Form::hidden('hop_dong_id', $id);
    $hiddenMqhID        = Form::hidden('mqh_id', '');
    $hiddenCdID         = Form::hidden('cd_id', '');

    $rsInitNkSelected       = Template::buildNhanKhauInHopDong($id, $nkInHopDong);
    $initNkSelected         = $rsInitNkSelected['initNkSelected'];
    $nkIdOptionSelected     = $rsInitNkSelected['nkIdOptionSelected'];
    $nkNameOptionSelected   = $rsInitNkSelected['nkNameOptionSelected'];
    $mqhIdOptionSelected    = $rsInitNkSelected['mqhIdOptionSelected'];
    $mqhNameOptionSelected  = $rsInitNkSelected['mqhNameOptionSelected'];

    $initJscongDanSelectedId    = Form::hidden('congDanSelectedId',     json_encode($nkIdOptionSelected),       ['id' => 'congDanSelectedId']);
    $initJscongDanSelectedName  = Form::hidden('congDanSelectedName',   json_encode($nkNameOptionSelected),     ['id' => 'congDanSelectedName']);
    $initJsmqhSelectedId        = Form::hidden('mqhSelectedId',         json_encode($mqhIdOptionSelected),      ['id' => 'mqhSelectedId']);
    $initJsmqhSelectedName      = Form::hidden('mqhSelectedName',       json_encode($mqhNameOptionSelected),    ['id' => 'mqhSelectedName']);

    $selectCongDanList  = Template::buildSelectCongDanList($dataCongDan, $nkIdOptionSelected);

    $element = [
        [
            'label'     => Form::label('cong_dan_list', 'Công Dân', ['class' => $formLabelClass]),
            'el'        => $selectCongDanList,
            'elClass'   => 'col-9'
        ],
        [
            'label'     => Form::label('mqh_list', 'MQH', ['class' => $formLabelClass]),
            'el'        => '<div class="row"><div class="col-10">'.Form::select('mqh_list', $mqhEnum, 0, ['class' => $formInputClass, 'placeholder' => 'Select an item...' ]).'</div><div class="col-2">'.Form::button('Thêm', ['class' => 'btn btn-primary', 'id' => 'add-cong-dan']).'</div></div>',
            'elClass'   => 'col-9'
        ],
        [
            'label'     => Form::label('nk_list', 'Nhân khẩu', ['class' => $formLabelClass]),
            'el'        => '<div id="listNK">'. $initNkSelected.'</div>',
            'elClass'   => 'col-9'
        ],
        [
            'el'        =>  $initJscongDanSelectedId . $initJscongDanSelectedName . $initJsmqhSelectedId . $initJsmqhSelectedName .
                            $hiddenID . $hiddenMqhID . $hiddenCdID . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'      => 'btn-submit',
        ],
    ];
@endphp

<div class="row">
    <div class="card overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Điều chỉnh Nhân khẩu</h5>
            <div class="row">
                <div class="col">
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
