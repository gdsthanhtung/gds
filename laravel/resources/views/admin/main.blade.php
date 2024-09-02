<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.elements.head')
</head>
<body class="nav-sm">
    @include('admin.elements.sidebar_menu')
    @include('admin.elements.topnav')
    <main id="main" class="main">
        @yield('content')
    </main>
    @include('admin.elements.footer')
    @include('admin.elements.script')
</body>
</html>
