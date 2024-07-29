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
        ]
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
        'selectLevel' => [
            'user' => 'Người dùng',
            'admin' => 'Quản trị viên'
        ],
        'searchSelection' => [
            'all' => ['name' => 'Tìm tất cả'],
            'id' => ['name' => 'Tìm theo id'],
            'name' => ['name' => 'Tìm theo tên'],
            'username' => ['name' => 'Tìm theo username'],
            'fullname' => ['name' => 'Tìm theo tên đầy đủ'],
            'email' => ['name' => 'Tìm theo email'],
            'description' => ['name' => 'Tìm theo mô tả'],
            'content' => ['name' => 'Tìm theo nội dung'],
            'link' => ['name' => 'Tìm theo link'],
        ],
        'selectionInModule' => [
            'default' => ['all'],
            'slider' => ['all', 'name', 'description', 'link'],
            'user' => ['all', 'username', 'email', 'fullname'],
            'phongtro' => ['all', 'name'],
            'congdan' => ['all', 'username', 'email', 'fullname'],
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
        ]
    ]
];
