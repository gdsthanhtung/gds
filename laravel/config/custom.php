<?php

return [
    'route' => [
        'prefix_admin' => 'admin',
        'slider' => [
            'ctrl' => 'slider',
            'prefix' => 'slider',
            'view' => 'slider'
        ],
        'dashboard' => [
            'ctrl' => 'dashboard',
            'prefix' => 'dashboard',
            'view' => 'dashboard'
        ],
        'user' => [
            'ctrl' => 'user',
            'prefix' => 'user',
            'view' => 'user'
        ],
        'auth' => [
            'ctrl' => 'auth',
            'prefix' => 'auth',
            'view' => 'auth'
        ],
        'phongtro' => [
            'ctrl' => 'phongtro',
            'prefix' => 'phongtro',
            'view' => 'phong_tro'
        ],
        'congdan' => [
            'ctrl' => 'congdan',
            'prefix' => 'congdan',
            'view' => 'cong_dan'
        ],
        'hopdong' => [
            'ctrl' => 'hopdong',
            'prefix' => 'hopdong',
            'view' => 'hop_dong'
        ],
    ],
    'format' => [
        'longTime' => 'd/m/Y H:m:s',
        'shortTime' => 'd/m/Y'
    ],
    'template' => [
        'formLabel' => [
            'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
        ],
        'formInput' => [
            'class' => 'form-control col-md-7 col-xs-12'
        ],
        'formInputDateRange' => [
            'class' => 'form-control col-md-3 col-xs-6'
        ]
    ],
    'enum' => [
        'ruleStatus'    => [
            'active'    => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            'inactive'  => ['name' => 'Chưa kích hoạt', 'class' => 'btn-warning'],
            'all'       => ['name' => 'Tất cả', 'class' => 'btn-primary'],
            'unknown'   => ['name' => 'Không xác định', 'class' => 'btn-danger']
        ],
        'selectStatus' => [
            'active' => 'Kích hoạt',
            'inactive' => 'Chưa kích hoạt'
        ],
        'selectYesNo' => [
            '0' => 'No',
            '1' => 'Yes'
        ],
        'selectLevel' => [
            'user' => 'Người dùng',
            'admin' => 'Quản trị viên'
        ],
        'searchSelection' => [
            'all' => ['name' => 'Tìm Tất cả'],
            'id' => ['name' => 'Tìm theo ID'],
            'name' => ['name' => 'Tìm theo Tên'],
            'username' => ['name' => 'Tìm theo Username'],
            'fullname' => ['name' => 'Tìm theo Tên đầy đủ'],
            'email' => ['name' => 'Tìm theo Email'],
            'description' => ['name' => 'Tìm theo Mô tả'],
            'content' => ['name' => 'Tìm theo Nội dung'],
            'link' => ['name' => 'Tìm theo Link'],
            'cccd_number' => ['name' => 'Tìm số CCCD'],
            'address' => ['name' => 'Tìm theo Đ/C thường trú'],
            'phone' => ['name' => 'Tìm theo Số điện thoại'],
        ],
        'searchSelectionHopDong' => [
            'all' => ['name' => 'Tìm Tất cả'],
            'main.id' => ['name' => 'Tìm theo ID Hợp đồng'],
            'main.ma_hop_dong' => ['name' => 'Tìm theo Mã hợp đồng'],
            'cd.fullname' => ['name' => 'Tìm theo Tên công dân'],
            'cd.cccd_number' => ['name' => 'Tìm theo Số CCCD'],
            'pt.name' => ['name' => 'Tìm theo Số phòng'],
        ],
        'selectionInModule' => [
            'default' => ['all'],
            'slider' => ['all', 'name', 'description', 'link'],
            'user' => ['all', 'username', 'email', 'fullname'],
            'phongtro' => ['all', 'name'],
            'congdan' => ['all', 'fullname', 'cccd_number', 'address', 'phone'],
            'hopdong' => ['all', 'main.id', 'main.ma_hop_dong', 'cd.fullname', 'cd.cccd_number', 'pt.name'],
        ],
        'ruleBtn' => [
            'edit'      => ['class' => 'btn-success',               'title' => 'Điều chỉnh',    'icon' => 'fa-pencil',  'route' => "/form"],
            'delete'    => ['class' => 'btn-delete btn-danger',     'title' => 'Xoá',           'icon' => 'fa-trash',   'route' => "/delete"],
            'info'      => ['class' => 'btn-info',                  'title' => 'Thông tin',     'icon' => 'fa-info',    'route' => "/form"],
        ],
        'btnInArea' => [
            'default' => ['edit', 'delete'],
            'slider' => ['edit', 'delete'],
            'user' => ['edit'],
            'phongtro' => ['edit', 'delete'],
            'congdan' => ['edit', 'delete'],
            'hopdong' => ['edit', 'delete'],
        ],
        'gender' => [
            'M' => 'Nam',
            'W' => 'Nữ'
        ],
        'defaultPath' => [
            'avatar' => 'default/avatar.jpg',
            'cccd_image_front' => 'default/cccd_front.jpg',
            'cccd_image_rear' => 'default/cccd_rear.jpg',
        ],
        'path' => [
            'congdan' => [
                'avatar' => 'congdan/avatar',
                'cccd_image_front' => 'congdan/cccd_image_front',
                'cccd_image_rear' => 'congdan/cccd_image_rear',
            ]
        ]
    ]
];
