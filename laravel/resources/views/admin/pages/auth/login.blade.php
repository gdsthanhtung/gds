@php
    use App\Helpers\Template;
@endphp

@extends('admin.auth')

@section('content')
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                    <div class="d-flex justify-content-center py-4">
                        <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="{{ asset('admin/asset/nice-admin/img/logo.png') }}" alt="">
                        <span class="d-none d-lg-block">GDS-QLNT</span>
                        </a>
                    </div><!-- End Logo -->

                    <div class="card mb-3">

                        <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                            <p class="text-center small">Enter your email & password to login</p>
                        </div>

                        {!!
                            Form::open([
                                'url' => route($ctrl.'/do-login'),
                                'method' => 'POST',
                                'id' => 'main-form',
                                'class' => 'row g-3'
                            ])
                        !!}

                            @include($pathViewTemplate.'error')
                            @include($pathViewTemplate.'notify')

                            <div class="col-12">
                                {!! Form::label('email', 'Email') !!}
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                    {!! Form::text('email', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                                    <div class="invalid-feedback">Please enter your email.</div>
                                </div>
                            </div>

                            <div class="col-12">
                                {!! Form::label('password', 'Password') !!}
                                {!! Form::password('password', ['class' => 'form-control', 'required' => true, 'data-eye' => true]) !!}
                                <div class="invalid-feedback">Please enter your password!</div>
                            </div>
                            <div class="col-12"></div>
                            <div class="col-12">
                                {!! Form::hidden('task', 'do-login') !!}
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </div>
                            <div class="col-12"></div>
                        {!! Form::close() !!}

                        </div>
                    </div>

                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                        Designed by <a href="https://bootstrapmade.com/">Gradeus</a>
                    </div>

                    </div>
                </div>
                </div>

            </section>
        </div>
</main><!-- End #main -->


    {{-- <div class="brand">
        <img src="img/logo.jpg">
    </div> --}}
    {{-- <div style="height: 200px"></div>
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
    </div> --}}
@endsection
