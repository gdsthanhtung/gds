@php
    use App\Helpers\Template;
    use App\Helpers\Calc;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass = Config::get('custom.template.formLabel.class');
    $formInputClass = Config::get('custom.template.formInput.class');
    $formLabelRightClass = Config::get('custom.template.formLabelRight.class');

    $hopDongId      = $data['hop_dong_id'];
    $isCity         = $data['is_city'];

    $fromDate       = $data['tu_ngay']; $fromDate   = Carbon::parse($fromDate)->format('d-m-Y');
    $toDate         = $data['den_ngay']; $toDate     = Carbon::parse($toDate)->format('d-m-Y');

    $numberEOld     = Template::showNum($data['chi_so_dien_ky_truoc']);
    $numberWOld     = Template::showNum($data['chi_so_nuoc_ky_truoc']);
    $numberE        = Template::showNum($data['chi_so_dien']);
    $numberW        = Template::showNum($data['chi_so_nuoc']);

    $approveE       = $data['huong_dinh_muc_dien'];
    $approveW       = $data['huong_dinh_muc_nuoc'];

    $rangeE         = $data['range_dien'];
    $rangeW         = $data['range_nuoc'];
    $tienPhong      = Template::showNum($data['tien_phong'], true);
    $tienDien       = Template::showNum($data['tien_dien'], true);
    $tienNuoc       = Template::showNum($data['tien_nuoc'], true);
    $tienNet        = Template::showNum($data['tien_net'], true);
    $tienRac        = Template::showNum($data['tien_rac'], true);
    $tienKhac       = Template::showNum($data['tien_khac'], true);
    $tongCong       = Template::showNum($data['tong_cong'], true);

    $status         = $data['status'];
    $note           = ($data['ghi_chu']) ? $data['ghi_chu'] : '-';

    $statusEnum     = Config::get('custom.enum.selectStatusHoaDon');
    $yesnoEnum      = Config::get('custom.enum.selectYesNo');
    $eRangeEnum     = Config::get('custom.enum.eRange');
    $wRangeEnum     = Config::get('custom.enum.wRange');
    $hoaDonEnum     = Config::get('custom.enum.hoaDon');
    $isCityEnum     = Config::get('custom.enum.isCity');

    $hiddenHopDongList  = Form::text('hop-dong-list', json_encode($dataHopDong), ['id' => 'hop-dong-list']);
    $hiddenHoaDonEnum   = Form::text('hoa-don-enum', json_encode($hoaDonEnum), ['id' => 'hoa-don-enum']);
    $hiddenYesNoEnum    = Form::text('yes-no-enum', json_encode($yesnoEnum), ['id' => 'yes-no-enum']);
    $hiddenIsCityEnum   = Form::text('is-city-enum', json_encode($isCityEnum), ['id' => 'is-city-enum']);
    $hiddenERange       = Form::text('range_dien', json_encode($eRangeEnum[0]), ['id' => 'e-range']);
    $hiddenWRange       = Form::text('range_nuoc', json_encode($wRangeEnum[0]), ['id' => 'w-range']);

    $eDetail = Calc::calcE($rangeE, $data['chi_so_dien']);
    $wDetail = Calc::calcW($rangeW, $data['chi_so_nuoc'], $isCity);

    $element = [
        [
            'label' => Form::label('', 'Hợp đồng số', ['class' => $formLabelClass]),
            'el'    => Form::label('', $selectHopDong[$hopDongId], ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('', 'Hộ khẩu', ['class' => $formLabelClass]),
            'el'    => Form::label('', $isCityEnum[$isCity], ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('huong_dinh_muc_dien', 'Hưởng định mức Điện', ['class' => $formLabelClass]),
            'el'    => Form::label('', $yesnoEnum[$approveE], ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('huong_dinh_muc_nuoc', 'Hưởng định mức Nước', ['class' => $formLabelClass]),
            'el'    => Form::label('', $yesnoEnum[$approveW], ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('tu_ngay', 'Từ ngày', ['class' => $formLabelClass]),
            'el'    => Form::label('', $fromDate . ' - ' . $toDate, ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('chi_so_dien', 'Chỉ số Điện', ['class' => $formLabelClass]),
            'el'    =>  Form::label('', $numberE . ' | Kỳ trước: ' . $numberEOld . ' | Sử dụng trong kỳ: ' . ($numberE - $numberEOld) . ' | Tiền điện: ' . $tienDien, ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('tien_dien', 'Tiền điện chi tiết', ['class' => $formLabelClass]),
            'el'    => $eDetail
        ],
        [
            'label' => Form::label('chi_so_nuoc', 'Chỉ số Nước', ['class' => $formLabelClass]),
            'el'    =>  Form::label('', $numberW . ' | Kỳ trước: ' . $numberWOld . ' | Sử dụng trong kỳ: ' . ($numberW - $numberWOld) . ' | Tiền nước: ' . $tienNuoc, ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('tien_nuoc', 'Tiền nước', ['class' => $formLabelClass]),
            'el'    => $wDetail
        ],
        [
            'label' => Form::label('tien_phong', 'Tiền phòng', ['class' => $formLabelClass]),
            'el'    => Form::label('', $tienPhong, ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('tien_rac', 'Tiền rác', ['class' => $formLabelClass]),
            'el'    => Form::label('', $tienRac, ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('tien_net', 'Tiền internet', ['class' => $formLabelClass]),
            'el'    => Form::label('', $tienNet, ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('tien_khac', 'Chi phí khác', ['class' => $formLabelClass]),
            'el'    => Form::label('', $tienKhac, ['class' => $formLabelRightClass])
        ],
        [
            'label' => Form::label('tong_cong', 'TỔNG CỘNG', ['class' => $formLabelClass]),
            'el'    => Form::text('tc', $tongCong, ['class' => $formInputClass . ' zero', 'id' => 'tc'])
        ],
        [
            'label' => Form::label('status', 'Trạng thái', ['class' => $formLabelClass]),
            'el'    => Template::showItemStatusHoaDon($ctrl, $id, $status)
        ],
        [
            'label' => Form::label('ghi_chu', 'Ghi chú', ['class' => $formLabelClass]),
            'el'    => Form::label('', $note, ['class' => $formLabelRightClass])
        ]
    ];
@endphp

@if($id) <div class="col-md-9 col-sm-9 col-xs-9"> @else <div class="col-md-12 col-sm-12 col-xs-12"> @endif
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
