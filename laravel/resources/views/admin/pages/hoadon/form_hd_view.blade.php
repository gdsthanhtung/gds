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

    $eDetail = Calc::calcE($rangeE, $data['chi_so_dien'] - $data['chi_so_dien_ky_truoc']);
    $wDetail = Calc::calcW($rangeW, $data['chi_so_nuoc'] - $data['chi_so_nuoc_ky_truoc'], $isCity);
    $elNine = 'col-md-9 col-sm-9 col-xs-9';

    $element = [
        [
            'label' => Form::label('', 'Hợp đồng số', ['class' => $formLabelClass]),
            'el'    => Form::label('', $selectHopDong[$hopDongId], ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('', 'Hộ khẩu', ['class' => $formLabelClass]),
            'el'    => Form::label('', $isCityEnum[$isCity], ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('huong_dinh_muc_dien', 'Hưởng định mức Điện', ['class' => $formLabelClass]),
            'el'    => Form::label('', $yesnoEnum[$approveE], ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('huong_dinh_muc_nuoc', 'Hưởng định mức Nước', ['class' => $formLabelClass]),
            'el'    => Form::label('', $yesnoEnum[$approveW], ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('tu_ngay', 'Từ ngày', ['class' => $formLabelClass]),
            'el'    => Form::label('', $fromDate . ' - ' . $toDate, ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('chi_so_dien', 'Số điện', ['class' => $formLabelClass]),
            'el'    =>  Form::label('', 'Kỳ mới: ' . $numberE . ' | Kỳ trước: ' . $numberEOld . ' | Sử dụng trong kỳ: ' . ($numberE - $numberEOld), ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('chi_so_nuoc', 'Số nước', ['class' => $formLabelClass]),
            'el'    =>  Form::label('', 'Kỳ mới: ' . $numberW . ' | Kỳ trước: ' . $numberWOld . ' | Sử dụng trong kỳ: ' . ($numberW - $numberWOld), ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('tien_dien', 'Tiền điện', ['class' => $formLabelClass]),
            'el'    =>  Form::label('', $tienDien, ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('tien_nuoc', 'Tiền nước', ['class' => $formLabelClass]),
            'el'    =>  Form::label('', $tienNuoc, ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('tien_phong', 'Tiền phòng', ['class' => $formLabelClass]),
            'el'    => Form::label('', $tienPhong, ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('tien_rac', 'Tiền rác', ['class' => $formLabelClass]),
            'el'    => Form::label('', $tienRac, ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('tien_net', 'Tiền internet', ['class' => $formLabelClass]),
            'el'    => Form::label('', $tienNet, ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('tien_khac', 'Chi phí khác', ['class' => $formLabelClass]),
            'el'    => Form::label('', $tienKhac, ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('tong_cong', 'TỔNG CỘNG', ['class' => $formLabelClass]),
            'el'    => Form::text('tc', $tongCong, ['class' => $formInputClass . ' zero', 'id' => 'tc']),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('status', 'Trạng thái', ['class' => $formLabelClass]),
            'el'    => Template::showItemStatusHoaDon($ctrl, $id, $status),
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('ghi_chu', 'Ghi chú', ['class' => $formLabelClass]),
            'el'    => Form::label('', $note, ['class' => $formLabelRightClass]),
            'elClass' => $elNine
        ]
    ];

    $elementDetail = [
        [
            'label' => Form::label('tien_dien', 'Tiền điện chi tiết', ['class' => $formLabelClass]),
            'el'    => $eDetail,
            'elClass' => $elNine
        ],
        [
            'label' => Form::label('tien_nuoc', 'Tiền nước', ['class' => $formLabelClass]),
            'el'    => $wDetail,
            'elClass' => $elNine
        ],
    ];
@endphp

@if($id) <div class="col-md-9 col-sm-9 col-xs-9"> @else <div class="col-md-12 col-sm-12 col-xs-12"> @endif
    <div class="x_panel">
        @include($pathViewTemplate . 'x_title', ['title' => ($id) ? 'Điều chỉnh Hóa đơn' : 'Thêm mới Hóa đơn'])

        <div class="x_content">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    {!! Form::open([ 'class' => 'form-horizontal form-label-left' ]) !!}
                        {!! FormTemplate::export($element) !!}
                    {!! Form::close() !!}
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                    {!! Form::open([ 'class' => 'form-horizontal form-label-left' ]) !!}
                        {!! FormTemplate::export($elementDetail) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
