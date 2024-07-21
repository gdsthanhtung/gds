<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<title>Login Page</title>

    <link href={{ asset('admin/asset/bootstrap/dist/css/bootstrap.min.css') }} rel="stylesheet">
    <link href={{ asset('admin/css/my-login.css') }} rel="stylesheet">

</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
                <div class="row">
                    <div class="col-md-4 col-sm-offset-4">
                        <div class="card-wrapper">
                            @yield('content')
                        </div>
                    </div>
                </div>


			</div>
		</div>
	</section>

    <script src={{ asset("admin/js/jquery/dist/jquery.min.js");}}></script>
    <script src={{ asset("admin/asset/bootstrap/dist/js/bootstrap.min.js");}}></script>
    <script src={{ asset("admin/js/my-login.js");}}></script>
</body>
</html>
