<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.elements.head')
</head>
<body class="nav-sm">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                @include('admin.elements.sidebar_title')
                @include('admin.elements.sidebar_menu')
            </div>
        </div>

        @include('admin.elements.topnav')

        @yield('content')

        @include('admin.elements.footer')
    </div>
</div>
@include('admin.elements.script')
</body>
</html>
