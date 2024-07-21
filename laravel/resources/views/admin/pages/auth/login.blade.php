@php
    use App\Helpers\Template;
@endphp

@extends('admin.auth')

@section('content')
    {{-- <div class="brand">
        <img src="img/logo.jpg">
    </div> --}}
    <div style="height: 200px"></div>
    <div class="card fat">
        <div class="card-body">
            <h4 class="card-title">Login</h4>

            {!!
                Form::open([
                    'url' => route($ctrl.'/do-login'),
                    'method' => 'POST',
                    'id' => 'main-form'
                ])
            !!}
                @include($pathViewTemplate . 'error')
                @include($pathViewTemplate.'notify')

                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required' => true, 'data-eye' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::hidden('task', 'do-login') !!}
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>

                <div class="form-group no-margin">
                    <a href="forgot.html" class="float-right">
                        Forgot Password?
                    </a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="footer">
        Copyright &copy; GDS Company 2024
    </div>
@endsection
