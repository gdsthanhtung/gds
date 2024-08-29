@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass = Config::get('custom.template.formLabel.class');
    $formInputClass = Config::get('custom.template.formInput.class');
    $formLabelRightClass = Config::get('custom.template.formLabelRight.class');

    $hopDongId      = '';
    $isCity         = 0;

    $fromDate       = Carbon::now()->startOfMonth()->format('d-m-Y');                 $fromDate   = Carbon::parse($fromDate)->format('d-m-Y');
    $toDate         = Carbon::create(Carbon::now()->endOfMonth()->format('d-m-Y'));   $toDate     = Carbon::parse($toDate)->format('d-m-Y');

    $numberEOld     = 0;
    $numberWOld     = 0;
    $numberE        = 0;
    $numberW        = 0;

    $approveE       = 0;
    $approveW       = 0;

    $rangeE         = json_encode(Config::get('custom.enum.eRange'));
    $rangeW         = json_encode(Config::get('custom.enum.wRange'));
    $tienPhong      = 0;
    $tienDien       = 0;
    $tienNuoc       = 0;
    $tienNet        = 0;
    $tienRac        = 0;
    $tienKhac       = 0;
    $tongCong       = 0;

    $status         = 'inactive';
    $note           = '';

    $statusEnum     = Config::get('custom.enum.selectStatusHoaDon');
    $yesnoEnum      = Config::get('custom.enum.selectYesNo');
    $eRangeEnum     = Config::get('custom.enum.eRange');
    $wRangeEnum     = Config::get('custom.enum.wRange');
    $hoaDonEnum     = Config::get('custom.enum.hoaDon');
    $isCityEnum     = Config::get('custom.enum.isCity');

    $hiddenHopDongList  = Form::hidden('hop-dong-list', json_encode($dataHopDong), ['id' => 'hop-dong-list']);
    $hiddenHoaDonEnum   = Form::hidden('hoa-don-enum', json_encode($hoaDonEnum), ['id' => 'hoa-don-enum']);
    $hiddenYesNoEnum    = Form::hidden('yes-no-enum', json_encode($yesnoEnum), ['id' => 'yes-no-enum']);
    $hiddenIsCityEnum   = Form::hidden('is-city-enum', json_encode($isCityEnum), ['id' => 'is-city-enum']);
    $hiddenERange       = Form::hidden('range_dien', json_encode($eRangeEnum[0]), ['id' => 'e-range']);
    $hiddenWRange       = Form::hidden('range_nuoc', json_encode($wRangeEnum[0]), ['id' => 'w-range']);

    $hiddenID           = Form::hidden('id', $id);
    $hiddenTask         = Form::hidden('task', ($id) ? 'edit' : 'add');

    $element = [
        [
            'label' => Form::label('hop_dong_id', 'Hợp đồng số', ['class' => $formLabelClass]),
            'el'    => Form::select('hop_dong_id', $selectHopDong, $hopDongId, ['class' => $formInputClass, 'required' => true, 'placeholder' => 'Select an item...'])
        ],
        [
            'label' => Form::label('prev_invoice', 'Hóa đơn gần nhất', ['class' => $formLabelClass]),
            'el'    => Form::label('prev_invoice', '-', ['class' => $formLabelRightClass. ' text-left input-like-text', 'id' => 'prev-invoice'])

        ],
        [
            'label' => Form::label('is_city', 'Hộ khẩu', ['class' => $formLabelClass]),
            'el'    => Form::label('is_city', $isCityEnum[$isCity], ['class' => $formLabelRightClass. ' text-left input-like-text', 'id' => 'is-city', 'disabled' => true]).
                       Form::hidden('is_city', $isCity, ['id' => 'is-city-input']),
        ],
        [
            'label' => Form::label('huong_dinh_muc_dien', 'Hưởng định mức Điện', ['class' => $formLabelClass]),
            'el'    => Form::label('huong_dinh_muc_dien', $yesnoEnum[$approveE], ['class' => $formLabelRightClass. ' text-left input-like-text', 'id' => 'approve-e', 'disabled' => true]).
                       Form::hidden('huong_dinh_muc_dien', $approveE, ['id' => 'approve-e-input']),
        ],
        [
            'label' => Form::label('huong_dinh_muc_nuoc', 'Hưởng định mức Nước', ['class' => $formLabelClass]),
            'el'    => Form::label('huong_dinh_muc_nuoc', $yesnoEnum[$approveW], ['class' => $formLabelRightClass. ' text-left input-like-text', 'id' => 'approve-w', 'disabled' => true]).
                       Form::hidden('huong_dinh_muc_nuoc', $approveW, ['id' => 'approve-w-input']),
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
            'label' => Form::label('chi_so_dien', 'Chỉ số Điện mới', ['class' => $formLabelClass]),
            'el'    =>  '<div class="input-group">'.
                            Form::text('chi_so_dien', $numberE, ['class' => 'form-control text-center chi_so_dien zero', 'required' => true, 'id' => 'chi_so_dien']).'
                            <div class="input-group-addon">Kỳ trước</div>'.
                            Form::text('chi_so_dien_ky_truoc', $numberEOld, ['class' => 'form-control text-center chi_so_dien zero', 'required' => true, 'id' => 'chi_so_dien_ky_truoc']).'
                            <div class="input-group-addon">Sử dụng trong kỳ</div>'.
                            Form::text('su_dung_dien', $numberE, ['class' => 'form-control text-center zero', 'disabled' => true, 'id' => 'su_dung_dien']).'
                        </div>'
        ],
        [
            'label' => Form::label('tien_dien', 'Tiền điện', ['class' => $formLabelClass]),
            'el'    => '<div class="input-group">'.
                            Form::number('tien_dien', $tienDien, ['class' => $formInputClass . ' zero', 'required' => true]).'
                            <div class="input-group-addon n-a" id="chi-tiet-dien"></div>
                        </div>'.Form::hidden('tien_dien_detail', $isCity, ['id' => 'tien-dien-detail-input'])
        ],
        [
            'label' => Form::label('chi_so_nuoc', 'Chỉ số Nước mới', ['class' => $formLabelClass]),
            'el'    => '<div class="input-group">'.
                            Form::text('chi_so_nuoc', $numberW, ['class' => 'form-control text-center chi_so_nuoc zero', 'required' => true, 'id' => 'chi_so_nuoc']).'
                            <div class="input-group-addon">Kỳ trước</div>'.
                            Form::text('chi_so_nuoc_ky_truoc', $numberWOld, ['class' => 'form-control text-center chi_so_nuoc zero', 'required' => true, 'id' => 'chi_so_nuoc_ky_truoc']).'
                            <div class="input-group-addon">Sử dụng trong kỳ</div>'.
                            Form::text('su_dung_nuoc', $numberE, ['class' => 'form-control text-center zero', 'disabled' => true, 'id' => 'su_dung_nuoc']).'
                        </div>'
        ],
        [
            'label' => Form::label('tien_nuoc', 'Tiền nước', ['class' => $formLabelClass]),
            'el'    => '<div class="input-group">'.
                            Form::number('tien_nuoc', $tienNuoc, ['class' => $formInputClass . ' zero', 'required' => true]).'
                            <div class="input-group-addon n-a" id="chi-tiet-nuoc"></div>
                        </div>'.Form::hidden('tien_nuoc_detail', $isCity, ['id' => 'tien-nuoc-detail-input'])
        ],
        [
            'label' => Form::label('tien_phong', 'Tiền phòng', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_phong', $tienPhong, ['class' => $formInputClass . ' zero', 'required' => true])
        ],
        [
            'label' => Form::label('tien_rac', 'Tiền rác', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_rac', $tienRac, ['class' => $formInputClass . ' zero', 'required' => true])
        ],
        [
            'label' => Form::label('tien_net', 'Tiền internet', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_net', $tienNet, ['class' => $formInputClass . ' zero', 'required' => true])
        ],
        [
            'label' => Form::label('tien_khac', 'Chi phí khác', ['class' => $formLabelClass]),
            'el'    => Form::number('tien_khac', $tienKhac, ['class' => $formInputClass . ' zero', 'required' => true])
        ],
        [
            'label' => Form::label('tong_cong', 'TỔNG CỘNG', ['class' => $formLabelClass]),
            'el'    => Form::text('tc', $tongCong, ['class' => $formInputClass . ' zero', 'id' => 'tc','required' => true, 'disabled' => true]).
                        Form::hidden('tong_cong', $tongCong, ['class' => $formInputClass . ' zero', 'id' => 'tong-cong','required' => true])
        ],
        [
            'label' => Form::label('status', 'Trạng thái', ['class' => $formLabelClass]),
            'el'    => Form::select('status', $statusEnum, $status, ['class' => $formInputClass, 'placeholder' => 'Select an item...' ])
        ],
        [
            'label' => Form::label('ghi_chu', 'Ghi chú', ['class' => $formLabelClass]),
            'el'    => Form::textarea('ghi_chu', $note, ['class' => $formInputClass, 'rows' => 3])
        ],
        [
            'el' => $hiddenIsCityEnum . $hiddenHoaDonEnum . $hiddenERange . $hiddenWRange . $hiddenYesNoEnum . $hiddenHopDongList . $hiddenID . $hiddenTask .
                    Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
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

