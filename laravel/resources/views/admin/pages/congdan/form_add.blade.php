@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;
    use Carbon\Carbon;

    $formLabelClass = Config::get('custom.template.formLabel.class');
    $formInputClass = Config::get('custom.template.formInput.class');

    $fullname       = $id ? $data['fullname'] : '';
    $cccdNumber     = $id ? $data['cccd_number'] : '';
    $cccdDos        = $id ? $data['cccd_dos'] : '2000-12-31'; $cccdDos = Carbon::parse($cccdDos)->format('Y-m-d');

    $gender         = $id ? $data['gender'] : '';
    $dob            = $id ? $data['dob'] : '2000-12-31'; $dob = Carbon::parse($dob)->format('Y-m-d');
    $address        = $id ? $data['address'] : '';
    $phone          = $id ? $data['phone'] : '';
    $status         = $id ? $data['status'] : '';

    $avatar         = $id ? $data['avatar'] : '';
    $cccdImageFront = $id ? $data['cccd_image_front'] : '';
    $cccdImageRear  = $id ? $data['cccd_image_rear'] : '';

    $hiddenID               = Form::hidden('id', $id);
    $hiddenAvatar           = Form::hidden('avatar', $avatar);
    $hiddenCccdImageFront   = Form::hidden('cccdImageFront', $cccdImageFront);
    $hiddenCccdImageRear    = Form::hidden('cccdImageRear', $cccdImageRear);
    $hiddenTask             = Form::hidden('task', 'add');

    $statusEnum     = Config::get('custom.enum.selectStatus');
    $genderEnum     = Config::get('custom.enum.gender');

    $element = [
        [
            'label' => Form::label('fullname', 'Fullname', ['class' => $formLabelClass]),
            'el'    => Form::text('fullname', $fullname, ['class' => $formInputClass, 'required' => true])
        ],[
            'label' => Form::label('cccd_number', 'Số CCCD', ['class' => $formLabelClass]),
            'el'    => Form::text('cccd_number', $cccdNumber, ['class' => $formInputClass, 'required' => true])
        ],[
            'label' => Form::label('cccd_dos', 'Ngày cấp CCCD', ['class' => $formLabelClass]),
            'el'    => Form::date('cccd_dos', $cccdDos, ['class' => $formInputClass, 'required' => true])
        ],[
            'label' => Form::label('gender', 'Giới tính', ['class' => $formLabelClass]),
            'el'    => Form::select('gender', $genderEnum, $gender, ['class' => $formInputClass, 'placeholder' => 'Select a status...'])
        ],[
            'label' => Form::label('dob', 'Ngày sinh', ['class' => $formLabelClass]),
            'el'    => Form::date('dob', $dob, ['class' => $formInputClass, 'required' => true])
        ],[
            'label' => Form::label('address', 'Địa chỉ thường trú', ['class' => $formLabelClass]),
            'el'    => Form::textarea('address', $address, ['class' => $formInputClass, 'required' => true, 'rows' => 3])
        ],[
            'label' => Form::label('phone', 'Số điện thoại', ['class' => $formLabelClass]),
            'el'    => Form::text('phone', $phone, ['class' => $formInputClass, 'required' => true])
        ],[
            'label' => Form::label('status', 'Status', ['class' => $formLabelClass]),
            'el'    => Form::select('status', $statusEnum, $status, ['class' => $formInputClass, 'placeholder' => 'Select a status...'])
        ],[
            'label' => Form::label('avatar', 'Avatar', ['class' => $formLabelClass]),
            'el'    => Form::file('avatar', ['class' => $formInputClass]),
            'avatar' => ($avatar) ? Template::showItemAvatar($ctrl, $avatar, $fullname) : null,
            'type'  => 'avatar'
        ],[
            'label' => Form::label('cccd_image_front', 'Ảnh mặt trước CCCD', ['class' => $formLabelClass]),
            'el'    => Form::file('cccd_image_front', ['class' => $formInputClass]),
            'avatar' => ($cccdImageFront) ? Template::showItemAvatar($ctrl, $cccdImageFront, $fullname) : null,
            'type'  => 'avatar'
        ],[
            'label' => Form::label('cccd_image_rear', 'Ảnh mặt sau CCCD', ['class' => $formLabelClass]),
            'el'    => Form::file('cccd_image_rear', ['class' => $formInputClass]),
            'avatar' => ($cccdImageRear) ? Template::showItemAvatar($ctrl, $cccdImageRear, $fullname) : null,
            'type'  => 'avatar'
        ],[
            'el' => $hiddenID . $hiddenAvatar . $hiddenTask . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
        ]
    ];
@endphp

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
