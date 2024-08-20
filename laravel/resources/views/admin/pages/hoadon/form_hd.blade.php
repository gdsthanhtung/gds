@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass = Config::get('custom.template.formLabel.class');
    $formInputClass = Config::get('custom.template.formInput.class');

    $defaultHoaDon  = Config::get('custom.enum.hoaDon');

    $hopDongId      = $id ? $data['hop_dong_id'] : '';
    $congDanId      = $id ? $data['cong_dan_id'] : '';
    $phongId        = $id ? $data['phong_id'] : '';

    $fromDate       = $id ? $data['tu_ngay']  : Carbon::now()->format('d-m-Y');                                $fromDate   = Carbon::parse($fromDate)->format('d-m-Y');
    $toDate         = $id ? $data['den_ngay'] : Carbon::create(Carbon::now()->format('d-m-Y'))->addYear(1);    $toDate     = Carbon::parse($toDate)->format('d-m-Y');

    $numberEOld     = $id ? $data['chi_so_dien_ky_truoc'] : 0;
    $numberWOld     = $id ? $data['chi_so_nuoc_ky_truoc'] : 0;
    $numberE        = $id ? $data['chi_so_dien'] : 0;
    $numberW        = $id ? $data['chi_so_nuoc'] : 0;

    $approveE       = $id ? $data['huong_dinh_muc_dien'] : 0;
    $approveW       = $id ? $data['huong_dinh_muc_nuoc'] : 0;

    $rangeE         = $id ? $data['range_dien'] : json_encode(Config::get('custom.enum.eRange'));
    $rangeW         = $id ? $data['range_nuoc'] : json_encode(Config::get('custom.enum.wkhung_Range'));
    $tienPhong      = $id ? $data['tien_phong'] : 0;
    $tienDien       = $id ? $data['tien_dien'] : 0;
    $tienNuoc       = $id ? $data['tien_nuoc'] : 0;
    $tienNet        = $id ? $data['tien_net'] : $defaultHoaDon['tienNet'];
    $tienRac        = $id ? $data['tien_rac'] : $defaultHoaDon['tienRac'];
    $tienKhac       = $id ? $data['tien_khac'] : 0;

    $status         = $id ? $data['status'] : 'inactive';
    $note           = $id ? $data['ghi_chu'] : '';

    $hiddenHopDongList = Form::text('hop-dong-list', json_encode($dataHopDong));
    $hiddenID       = Form::hidden('id', $id);
    $hiddenTask     = Form::hidden('task', ($id) ? 'edit' : 'add');
    $statusEnum     = Config::get('custom.enum.selectStatusHoaDon');
    $yesnoEnum      = Config::get('custom.enum.selectYesNo');


    dump($dataHopDong);

    $element = [
        [
            'label' => Form::label('hop_dong_id', 'Hợp đồng số', ['class' => $formLabelClass]),
            'el'    => Form::select('hop_dong_id', $selectHopDong, $hopDongId, ['class' => $formInputClass, 'required' => true, 'placeholder' => 'Select an item...'])
        ],
        [
            'label' => Form::label('cong_dan_id', 'Đại diện thuê phòng', ['class' => $formLabelClass]),
            'el'    => Form::text('cong_dan_id', '', ['class' => $formInputClass, 'disabled' => true])
        ],
        [
            'label' => Form::label('phong_id', 'Phòng', ['class' => $formLabelClass]),
            'el'    => Form::text('phong_id', '', ['class' => $formInputClass, 'disabled' => true])
        ],
        [
            'label' => Form::label('tu_ngay', 'Từ ngày', ['class' => $formLabelClass]),
            'el'    => '<div class="input-group input-daterange">'.
                            Form::text('tu_ngay', $fromDate, ['class' => 'form-control', 'required' => true]).'
                            <div class="input-group-addon">đến</div>'.
                            Form::text('den_ngay', $toDate, ['class' => 'form-control', 'required' => true]).'
                        </div>'
        ],
        [
            'label' => Form::label('chi_so_dien', 'Chỉ số Điện kỳ trước', ['class' => $formLabelClass]),
            'el'    =>  '<div class="input-group">'.
                            Form::text('chi_so_dien_ky_truoc', $numberEOld, ['class' => 'form-control text-center', 'required' => true]).'
                            <div class="input-group-addon">Chỉ số Điện mới</div>'.
                            Form::text('chi_so_dien', $numberE, ['class' => 'form-control text-center', 'required' => true]).'
                            <div class="input-group-addon">Đã sử dụng trong kỳ</div>'.
                            Form::text('chi_so_dien', $numberE, ['class' => 'form-control text-center', 'disabled' => true]).'
                        </div>'
        ],
        [
            'label' => Form::label('chi_so_nuoc', 'Chỉ số Nước kỳ trước', ['class' => $formLabelClass]),
            'el'    => '<div class="input-group">'.
                            Form::text('chi_so_nuoc_ky_truoc', $numberWOld, ['class' => 'form-control text-center', 'required' => true]).'
                            <div class="input-group-addon">Chỉ số Nước mới</div>'.
                            Form::text('chi_so_nuoc', $numberW, ['class' => 'form-control text-center', 'required' => true]).'
                            <div class="input-group-addon">Đã sử dụng trong kỳ</div>'.
                            Form::text('chi_so_dien', $numberE, ['class' => 'form-control text-center', 'disabled' => true]).'
                        </div>'
        ],
        [
            'label' => Form::label('huong_dinh_muc_dien', 'Hưởng định mức Điện', ['class' => $formLabelClass]),
            'el'    => Form::label('huong_dinh_muc_dien', $yesnoEnum[$approveE], ['class' => $formLabelClass. ' text-left']),
        ],
        [
            'label' => Form::label('huong_dinh_muc_nuoc', 'Hưởng định mức Nước', ['class' => $formLabelClass]),
            'el'    => Form::label('huong_dinh_muc_nuoc', $yesnoEnum[$approveW], ['class' => $formLabelClass. ' text-left']),
        ],
        [
            'label' => Form::label('tien_phong', 'Tiền phòng', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_phong', $tienPhong, ['class' => $formInputClass, 'required' => true])
        ],
        [
            'label' => Form::label('tien_dien', 'Tiền điện', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_dien', $tienDien, ['class' => $formInputClass, 'required' => true])
        ],
        [
            'label' => Form::label('tien_nuoc', 'Tiền nước', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_nuoc', $tienNuoc, ['class' => $formInputClass, 'required' => true])
        ],
        [
            'label' => Form::label('tien_net', 'Tiền internet', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_net', $tienNet, ['class' => $formInputClass, 'required' => true])
        ],
        [
            'label' => Form::label('tien_rac', 'Tiền rác', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_rac', $tienRac, ['class' => $formInputClass, 'required' => true])
        ],
        [
            'label' => Form::label('tien_khac', 'Chi phí khác', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_khac', $tienKhac, ['class' => $formInputClass, 'required' => true])
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
            'el' => $hiddenHopDongList . $hiddenID . $hiddenTask . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
        ]
    ];
@endphp

@if($id) <div class="col-md-5 col-sm-5 col-xs-5"> @else <div class="col-md-12 col-sm-12 col-xs-12"> @endif
    <div class="x_panel">
        @include($pathViewTemplate . 'x_title', ['title' => ($id) ? 'Điều chỉnh Hóa đơn' : 'Thêm mới Hóa đơn'])

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
