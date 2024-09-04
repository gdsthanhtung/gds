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
    $hiddenTask     = Form::hidden('task', 'change-password');

    $element = [
        [
            'label' => Form::label('password', 'Password', ['class' => $formLabelClass]),
            'el'    => Form::password('password', ['class' => $formInputClass, 'required' => true])
        ],[
            'label' => Form::label('password_confirmation', 'Re-Password', ['class' => $formLabelClass]),
            'el'    => Form::password('password_confirmation', ['class' => $formInputClass, 'required' => true])

        ],[
            'el' => $hiddenID . $hiddenTask . Form::submit('Lưu', ['class' => 'btn btn-success']),
            'type'  => 'btn-submit'
        ]
    ];
@endphp

<div class="col-6">
    <div class="card overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Change password</h5>
            <div class="row">

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
