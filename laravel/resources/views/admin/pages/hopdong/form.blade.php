@extends('admin.main')

@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass             = Config::get('custom.template.formLabel.class');
    $formInputClass             = Config::get('custom.template.formInput.class');
    $formInputDateRangeClass    = Config::get('custom.template.formInputDateRange.class');

    $maHopDong      = $id ? $data['ma_hop_dong'] : '';
    $phongId        = $id ? $data['phong_id'] : '';
    $congDanId      = $id ? $data['cong_dan_id'] : '';

    $fromDate       = $id ? $data['thue_tu_ngay']  : Carbon::now()->format('d-m-Y');    $fromDate   = Carbon::parse($fromDate)->format('d-m-Y');
    $toDate         = $id ? $data['thue_den_ngay'] : Carbon::now()->format('d-m-Y');    $toDate     = Carbon::parse($toDate)->format('d-m-Y');

    $price          = $id ? $data['gia_phong'] : '';
    $numberE        = $id ? $data['chi_so_dien'] : '';
    $numberW        = $id ? $data['chi_so_nuoc'] : '';

    $approveE       = $id ? $data['huong_dinh_muc_dien'] : '';
    $approveW       = $id ? $data['huong_dinh_muc_nuoc'] : '';

    $status         = $id ? $data['status'] : '';
    $note           = $id ? $data['ghi_chu'] : '';

    $hiddenID       = Form::hidden('id', $id);
    $statusEnum     = Config::get('custom.enum.selectStatus');
    $yesnoEnum     = Config::get('custom.enum.selectYesNo');

    $element = [
        [
            'label' => Form::label('ma_hop_dong', 'Hợp đồng số', ['class' => $formLabelClass]),
            'el'    => Form::text('ma_hop_dong', $maHopDong, ['class' => $formInputClass, 'required' => 'required'])
        ],
        [
            'label' => Form::label('cong_dan_id', 'Đại diện thuê phòng', ['class' => $formLabelClass]),
            'el'    => Form::select('cong_dan_id', $dataCongDan, $congDanId, ['class' => $formInputClass, 'placeholder' => 'Select a item...'])
        ],
        [
            'label' => Form::label('phong_id', 'Phòng trọ', ['class' => $formLabelClass]),
            'el'    => Form::select('phong_id', $dataPhongTro, $phongId, ['class' => $formInputClass, 'placeholder' => 'Select a item...'])
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
            'el'    => Form::number('gia_phong', $price, ['class' => $formInputClass, 'required' => 'required'])
        ],
        [
            'label' => Form::label('chi_so_dien', 'Chỉ số điện', ['class' => $formLabelClass]),
            'el'    => Form::number('chi_so_dien', $numberE, ['class' => $formInputClass, 'required' => 'required'])
        ],
        [
            'label' => Form::label('chi_so_nuoc', 'Chỉ số nước', ['class' => $formLabelClass]),
            'el'    => Form::number('chi_so_nuoc', $numberW, ['class' => $formInputClass, 'required' => 'required'])
        ],
        [
            'label' => Form::label('huong_dinh_muc_dien', 'Hưởng định mức Điện', ['class' => $formLabelClass]),
            'el'    => Form::select('huong_dinh_muc_dien', $yesnoEnum, $approveE, ['class' => $formInputClass, 'placeholder' => 'Select a item...' ])
        ],
        [
            'label' => Form::label('huong_dinh_muc_nuoc', 'Hưởng định mức Nước', ['class' => $formLabelClass]),
            'el'    => Form::select('huong_dinh_muc_nuoc', $yesnoEnum, $approveW, ['class' => $formInputClass, 'placeholder' => 'Select a item...' ])
        ],
        [
            'label' => Form::label('status', 'Trạng thái', ['class' => $formLabelClass]),
            'el'    => Form::select('status', $statusEnum, $status, ['class' => $formInputClass, 'placeholder' => 'Select a item...' ])
        ],
        [
            'label' => Form::label('ghi_chu', 'Ghi chú', ['class' => $formLabelClass]),
            'el'    => Form::textarea('ghi_chu', $note, ['class' => $formInputClass, 'required' => true, 'rows' => 3])
        ],
        [
            'el' => $hiddenID . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
        ]
        // [
        //     'label' => Form::label('thue_den_ngay', 'Thuê đến ngày', ['class' => $formLabelClass]),
        //     'el'    => Form::text('thue_den_ngay', $toDate, ['class' => $formInputDateRangeClass.' datepicker', 'required' => true, 'data-provide' => 'datepicker'])
        // ],
    ];
@endphp

@section('content')
    <div class="right_col" role="main">
        @include($pathViewTemplate . 'page_header',
            [
                'title' => $pageTitle,
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

                    @include($pathViewTemplate . 'error')

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
