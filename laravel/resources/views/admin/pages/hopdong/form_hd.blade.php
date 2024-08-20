@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass             = Config::get('custom.template.formLabel.class');
    $formInputClass             = Config::get('custom.template.formInput.class');

    $maHopDong      = $id ? $data['ma_hop_dong'] : '';
    $phongId        = $id ? $data['phong_id'] : '';
    $congDanId      = $id ? $data['cong_dan_id'] : '';

    $fromDate       = $id ? $data['thue_tu_ngay']  : Carbon::now()->format('d-m-Y');                                $fromDate   = Carbon::parse($fromDate)->format('d-m-Y');
    $toDate         = $id ? $data['thue_den_ngay'] : Carbon::create(Carbon::now()->format('d-m-Y'))->addYear(1);    $toDate     = Carbon::parse($toDate)->format('d-m-Y');

    $price          = $id ? $data['gia_phong'] : '';
    $numberE        = $id ? $data['chi_so_dien'] : '';
    $numberW        = $id ? $data['chi_so_nuoc'] : '';

    $approveE       = $id ? $data['huong_dinh_muc_dien'] : 0;
    $approveW       = $id ? $data['huong_dinh_muc_nuoc'] : 0;

    $status         = $id ? $data['status'] : '';
    $note           = $id ? $data['ghi_chu'] : '';

    $hiddenID       = Form::hidden('id', $id);
    $hiddenTask     = Form::hidden('task', ($id) ? 'edit' : 'add');
    $statusEnum     = Config::get('custom.enum.selectStatus');
    $yesnoEnum      = Config::get('custom.enum.selectYesNo');

    $element = [
        [
            'label' => Form::label('ma_hop_dong', 'Hợp đồng số', ['class' => $formLabelClass]),
            'el'    => Form::number('ma_hop_dong', $maHopDong, ['class' => $formInputClass, 'required' => true, 'disabled' => true])
        ],
        [
            'label' => Form::label('cong_dan_id', 'Đại diện thuê phòng', ['class' => $formLabelClass]),
            'el'    => Form::select('cong_dan_id', $dataCongDan, $congDanId, ['class' => $formInputClass, 'placeholder' => 'Select an item...'])
        ],
        [
            'label' => Form::label('phong_id', 'Phòng', ['class' => $formLabelClass]),
            'el'    => Form::select('phong_id', $dataPhongTro, $phongId, ['class' => $formInputClass, 'placeholder' => 'Select an item...'])
        ],
        [
            'label' => Form::label('thue_tu_ngay', 'Thuê từ ngày', ['class' => $formLabelClass]),
            'el'    => '<div class="input-group input-daterange">'.
                            Form::text('thue_tu_ngay', $fromDate, ['class' => 'form-control', 'required' => true]).'
                            <div class="input-group-addon">đến</div>'.
                            Form::text('thue_den_ngay', $toDate, ['class' => 'form-control', 'required' => true]).'
                        </div>'
        ],
        [
            'label' => Form::label('gia_phong', 'Giá phòng', ['class' => $formLabelClass]),
            'el'    => Form::number('gia_phong', $price, ['class' => $formInputClass, 'required' => true])
        ],
        [
            'label' => Form::label('chi_so_dien', 'Chỉ số điện', ['class' => $formLabelClass]),
            'el'    => Form::number('chi_so_dien', $numberE, ['class' => $formInputClass, 'required' => true])
        ],
        [
            'label' => Form::label('chi_so_nuoc', 'Chỉ số nước', ['class' => $formLabelClass]),
            'el'    => Form::number('chi_so_nuoc', $numberW, ['class' => $formInputClass, 'required' => true])
        ],
        [
            'label' => Form::label('huong_dinh_muc_dien', 'Hưởng định mức Điện', ['class' => $formLabelClass]),
            'el'    => Template::radioSelect($yesnoEnum, $elName = 'huong_dinh_muc_dien', $approveE)
        ],
        [
            'label' => Form::label('huong_dinh_muc_nuoc', 'Hưởng định mức Nước', ['class' => $formLabelClass]),
            'el'    => Template::radioSelect($yesnoEnum, $elName = 'huong_dinh_muc_nuoc', $approveW)
        ],
        [
            'label' => Form::label('status', 'Trạng thái', ['class' => $formLabelClass]),
            'el'    => Form::select('status', $statusEnum, $status, ['class' => $formInputClass, 'placeholder' => 'Select an item...' ])
        ],
        [
            'label' => Form::label('ghi_chu', 'Ghi chú', ['class' => $formLabelClass]),
            'el'    => Form::textarea('ghi_chu', $note, ['class' => $formInputClass, 'required' => true, 'rows' => 3])
        ],
        [
            'el' => $hiddenID . $hiddenTask . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
        ]
    ];
@endphp

@if($id) <div class="col-md-5 col-sm-5 col-xs-5"> @else <div class="col-md-12 col-sm-12 col-xs-12"> @endif
    <div class="x_panel">
        @include($pathViewTemplate . 'x_title', ['title' => ($id) ? 'Điều chỉnh Hợp đồng' : 'Thêm mới Hợp đồng'])

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
