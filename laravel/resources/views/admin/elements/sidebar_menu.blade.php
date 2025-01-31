@php
    $avt = 'admin/img/img.jpg';
    $fullname = 'N/A';
    if(Session::has('userInfo')) {
        $fullname = Session::get('userInfo')['fullname'];
        $avt = 'images/user/'.Session::get('userInfo')['avatar'];
    }
@endphp
<!-- menu profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
        <img src={{asset($avt)}} alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>Welcome,</span>
        <h2>{{ $fullname }}</h2>
    </div>
</div>
<!-- /menu profile quick info -->
<br />
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer"></i> Dashboard</a></li>
            <li><a href="{{route('user')}}"><i class="fa fa-user"></i> User</a></li>
            <li><a href="{{route('phongtro')}}"><i class="fa fa-home"></i> Phòng Trọ</a></li>
            <li><a href="{{route('congdan')}}"><i class="fa fa-user"></i> Công Dân</a></li>
            <li><a href="{{route('hopdong')}}"><i class="fa fa-book"></i> Hợp Đồng</a></li>
            <li><a href="{{route('hoadon')}}"><i class="fa fa-file"></i> Hóa Đơn</a></li>
            {{-- <li><a href="{{route('slider')}}"><i class="fa fa-sliders"></i> Sliders</a></li> --}}
        </ul>
    </div>
</div>
<!-- /sidebar menu -->
