<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.elements.head')
    <link href={{ asset('admin/css/my-login.css') }} rel="stylesheet">
</head>
<body class="nav-sm">
    @yield('content')

    <script src={{ asset("admin/js/my-login.js");}}></script>
</body>
</html>
