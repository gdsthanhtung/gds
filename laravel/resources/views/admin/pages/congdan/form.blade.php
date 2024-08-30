@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass = Config::get('custom.template.formLabel.class');
    $formInputClass = Config::get('custom.template.formInput.class');

    $fullname       = $id ? $data['fullname'] : '';
    $cccdNumber     = $id ? $data['cccd_number'] : '';
    $cccdDos        = $id ? $data['cccd_dos'] : Carbon::now()->format('d-m-Y'); $cccdDos = Carbon::parse($cccdDos)->format('d-m-Y');

    $gender         = $id ? $data['gender'] : '';
    $dob            = $id ? $data['dob'] : Carbon::now()->format('d-m-Y');      $dob = Carbon::parse($dob)->format('d-m-Y');
    $address        = $id ? $data['address'] : '';
    $phone          = $id ? $data['phone'] : '';
    $status         = $id ? $data['status'] : '';
    $isCity         = $id ? $data['is_city'] : '';

    $statusDKTT     = $id ? $data['dktt_status'] : '';
    $fromDateDKTT   = $id ? $data['dktt_tu_ngay']  : Carbon::now()->format('d-m-Y');                                $fromDateDKTT   = Carbon::parse($fromDateDKTT)->format('d-m-Y');
    $toDateDKTT     = $id ? $data['dktt_den_ngay'] : Carbon::create(Carbon::now()->format('d-m-Y'))->addYear(1);    $toDateDKTT     = Carbon::parse($toDateDKTT)->format('d-m-Y');


    $avatar         = $id ? $data['avatar'] : '';
    $cccdImageFront = $id ? $data['cccd_image_front'] : '';
    $cccdImageRear  = $id ? $data['cccd_image_rear'] : '';

    $hiddenID               = Form::hidden('id', $id);
    $hiddenAvatar           = Form::hidden('avatar_current', $avatar);
    $hiddenCccdImageFront   = Form::hidden('cccd_image_front_current', $cccdImageFront);
    $hiddenCccdImageRear    = Form::hidden('cccd_image_rear_current', $cccdImageRear);
    $hiddenTask             = Form::hidden('task', ($id) ? 'edit' : 'add');

    $statusEnum     = Config::get('custom.enum.selectStatus');
    $statusEnumDKTT = Config::get('custom.enum.selectStatusDKTT');
    $genderEnum     = Config::get('custom.enum.gender');
    $isCityEnum     = Config::get('custom.enum.isCity');
    $pathImage      = Config::get("custom.enum.path.$ctrl");

    $element = [
        [
            'label' => Form::label('cccd_number', 'Số CCCD', ['class' => $formLabelClass]),
            'el'    => Form::text('cccd_number', $cccdNumber, ['class' => $formInputClass, 'required' => true])
        ],[
            'label' => Form::label('fullname', 'Họ Tên', ['class' => $formLabelClass]),
            'el'    => Form::text('fullname', $fullname, ['class' => $formInputClass, 'required' => true])
        ],[
            'label' => Form::label('gender', 'Giới Tính', ['class' => $formLabelClass]),
            'el'    => Form::select('gender', $genderEnum, $gender, ['class' => $formInputClass, 'placeholder' => 'Select an item...'])
        ],[
            'label' => Form::label('dob', 'Ngày Sinh', ['class' => $formLabelClass]),
            'el'    => Form::text('dob', $dob, ['class' => $formInputClass.' datepicker', 'required' => true])
        ],[
            'label' => Form::label('address', 'Địa Chỉ Thường Trú', ['class' => $formLabelClass]),
            'el'    => Form::textarea('address', $address, ['class' => $formInputClass, 'required' => true, 'rows' => 3])
        ],[
            'label' => Form::label('cccd_dos', 'Ngày Cấp CCCD', ['class' => $formLabelClass]),
            'el'    => Form::text('cccd_dos', $cccdDos, ['class' => $formInputClass.' datepicker', 'required' => true])
        ],[
            'label' => Form::label('phone', 'Số Điện Thoại', ['class' => $formLabelClass]),
            'el'    => Form::text('phone', $phone, ['class' => $formInputClass])
        ],[
            'label' => Form::label('is_city', 'Hộ Khẩu', ['class' => $formLabelClass]),
            'el'    => Template::radioSelect($isCityEnum, $elName = 'is_city', $isCity)
        ],[
            'label' => Form::label('dktt_status', 'Trạng Thái ĐK Tạm trú', ['class' => $formLabelClass]),
            'el'    => Form::select('dktt_status', $statusEnumDKTT, $statusDKTT, ['class' => $formInputClass, 'placeholder' => 'Select an item...'])
        ],[
            'label' => Form::label('dktt_tu_ngay', 'Đăng ký tạm trú', ['class' => $formLabelClass]),
            'el'    => '<div class="input-group input-daterange">'.
                            Form::text('dktt_tu_ngay', $fromDateDKTT, ['class' => 'form-control']).'
                            <div class="input-group-addon">đến</div>'.
                            Form::text('dktt_den_ngay', $toDateDKTT, ['class' => 'form-control']).'
                        </div>'
        ],[
            'label' => Form::label('status', 'Trạng Thái', ['class' => $formLabelClass]),
            'el'    => Form::select('status', $statusEnum, $status, ['class' => $formInputClass, 'placeholder' => 'Select an item...'])
        ],[
            'label' => Form::label('avatar', 'Ảnh Đại Diện', ['class' => $formLabelClass]),
            'el'    => Form::file('avatar', ['class' => $formInputClass]),
            'avatar' => ($avatar) ? Template::showItemAvatar('', $pathImage['avatar'].'/'.$avatar, $fullname) : null,
            'type'  => 'avatar'
        ],[
            'label' => Form::label('cccd_image_front', 'Ảnh Mặt Trước CCCD', ['class' => $formLabelClass]),
            'el'    => Form::file('cccd_image_front', ['class' => $formInputClass]),
            'avatar' => ($cccdImageFront) ? Template::showItemCCCD('', $pathImage['cccd_image_front'].'/'.$cccdImageFront, $fullname) : null,
            'type'  => 'avatar'
        ],[
            'label' => Form::label('cccd_image_rear', 'Ảnh Mặt Sau CCCD', ['class' => $formLabelClass]),
            'el'    => Form::file('cccd_image_rear', ['class' => $formInputClass]),
            'avatar' => ($cccdImageRear) ? Template::showItemCCCD('', $pathImage['cccd_image_rear'].'/'.$cccdImageRear, $fullname) : null,
            'type'  => 'avatar'
        ],[
            'el' => $hiddenID . $hiddenAvatar . $hiddenCccdImageFront . $hiddenCccdImageRear . $hiddenTask . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
        ]
    ];
@endphp

@extends('admin.main')

@section('content')
    <div class="right_col" role="main">
        @include($pathViewTemplate . 'page_header',
            [
                'title' => $pageTitle,
                'button' => '
                    <button class="btn btn-warning" id="cong-dan-quick-add" data-toggle="modal" data-target="#modalCongDanQuickAdd">Quick add</button>
                    <a href="'.route($ctrl).'" class="btn btn-info"><i class="fa fa-arrow-left"></i> Quay lại</a>'
            ])

        @if (session('notify'))
            @include($pathViewTemplate . 'notify')
        @endif

        <!--box-form-->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    @include($pathViewTemplate . 'x_title', ['title' => 'Thêm mới'])

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

    <!-- Modal -->
    <div id="modalCongDanQuickAdd" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nhập thông tin Công Dân tự động</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                      <label for="cccd-content" class="col-form-label">Thông tin CCCD:</label>
                      <textarea class="form-control" id="cccd-content" rows="8"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="process-cccd-content">Xử lý</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

        </div>
    </div>

@endsection
