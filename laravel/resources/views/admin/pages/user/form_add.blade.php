@php
    use App\Helpers\Template;
    use App\Helpers\FormTemplate;

    $formLabelClass = Config::get('custom.template.formLabel.class');
    $formInputClass = Config::get('custom.template.formInput.class');

    $username       = $id ? $data['username'] : '';
    $fullname       = $id ? $data['fullname'] : '';
    $email          = $id ? $data['email'] : '';
    $status         = $id ? $data['status'] : '';
    $level          = $id ? $data['level'] : '';
    $avatar         = $id ? $data['avatar'] : '';

    $hiddenID       = Form::hidden('id', $id);
    $hiddenAvatar   = Form::hidden('avatar', $avatar);

    $hiddenTask     = Form::hidden('task', 'add');

    $statusEnum     = Config::get('custom.enum.selectStatus');
    $levelEnum      = Config::get('custom.enum.selectLevel');

    $element = [
        [
            'label' => Form::label('username', 'Username', ['class' => $formLabelClass]),
            'el'    => Form::text('username', $username, ['class' => $formInputClass, 'required' => 'required'])
        ],[
            'label' => Form::label('fullname', 'Fullname', ['class' => $formLabelClass]),
            'el'    => Form::text('fullname', $fullname, ['class' => $formInputClass, 'required' => 'required'])
        ],[
            'label' => Form::label('password', 'Password', ['class' => $formLabelClass]),
            'el'    => Form::password('password', ['class' => $formInputClass, 'required' => 'required'])
        ],[
            'label' => Form::label('password_confirmation', 'Password confirmation', ['class' => $formLabelClass]),
            'el'    => Form::password('password_confirmation', ['class' => $formInputClass, 'required' => 'required'])
        ],[
            'label' => Form::label('email', 'Email', ['class' => $formLabelClass]),
            'el'    => Form::text('email', $email, ['class' => $formInputClass, 'required' => 'required'])
        ],[
            'label' => Form::label('status', 'Status', ['class' => $formLabelClass]),
            'el'    => Form::select('status', $statusEnum, $status, ['class' => $formInputClass, 'placeholder' => 'Select a status...'])
        ],[
            'label' => Form::label('level', 'Level', ['class' => $formLabelClass]),
            'el'    => Form::select('level', $levelEnum, $level, ['class' => $formInputClass, 'placeholder' => 'Select a level...'])
        ],[
            'label' => Form::label('avatar', 'Avatar', ['class' => $formLabelClass]),
            'el'    => Form::file('avatar', ['class' => $formInputClass]),
            'avatar' => ($avatar) ? Template::showItemAvatar($ctrl, $avatar, $fullname) : null,
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
