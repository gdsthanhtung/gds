<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CongDanController;
use App\Http\Controllers\Admin\PhongTroController;
use App\Http\Controllers\Admin\HopDongController;
use App\Http\Controllers\Admin\NhanKhauController;

/*
|--------------------------------------------------------------------------
| Set config paraer
|--------------------------------------------------------------------------
*/

$prefixAdmin = Config::get('custom.route.prefix_admin', 'admin');

/*
|--------------------------------------------------------------------------
| Config Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome',['pathViewTemplate' => "admin.templates."]);
})->name('/');

$prefix = Config::get('custom.route.auth.prefix', 'auth');
$ctrl   = Config::get('custom.route.auth.ctrl', 'auth');
Route::prefix($prefix)->group(function () use ($ctrl) {
    Route::controller(AuthController::class)->group(function () use ($ctrl) {
        Route::get('/', 'show')->name($ctrl)->middleware('check.login');
        Route::post('/do-login', 'do_login')->name($ctrl.'/do-login');
        Route::get('/logout', 'logout')->name($ctrl.'/logout');
    });
});

Route::prefix($prefixAdmin)->middleware('check.permission')->group(function () {
    $prefix = Config::get('custom.route.dashboard.prefix', 'dashboard');
    $ctrl   = Config::get('custom.route.dashboard.ctrl', 'dashboard');
    Route::prefix($prefix)->group(function () use ($ctrl) {
        Route::controller(DashboardController::class)->group(function () use ($ctrl) {
            Route::get('/', 'show')->name($ctrl);
        });
    });

    $prefix = Config::get('custom.route.slider.prefix', 'slider');
    $ctrl   = Config::get('custom.route.slider.ctrl', 'slider');
    Route::prefix($prefix)->group(function () use ($ctrl) {
        Route::controller(SliderController::class)->group(function () use ($ctrl) {
            Route::get('/', 'show')->name($ctrl);
            Route::get('/form/{id?}', 'form')->where(['id' => '[0-9]+'])->name($ctrl.'/form');
            Route::get('/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name($ctrl.'/delete');
            Route::get('/change-status/{id}/{status}', 'change_status')->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($ctrl.'/change-status');
            Route::post('/save', 'save')->name($ctrl.'/save');
        });
    });

    $prefix = Config::get('custom.route.user.prefix', 'user');
    $ctrl   = Config::get('custom.route.user.ctrl', 'user');
    Route::prefix($prefix)->group(function () use ($ctrl) {
        Route::controller(UserController::class)->group(function () use ($ctrl) {
            Route::get('/', 'show')->name($ctrl);
            Route::get('/form/{id?}', 'form')->where(['id' => '[0-9]+'])->name($ctrl.'/form');
            Route::get('/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name($ctrl.'/delete');
            Route::get('/change-status/{id}/{status}', 'change_status')->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($ctrl.'/change-status');
            Route::get('/change-level/{id}/{level}', 'change_level')->where(['id' => '[0-9]+', 'level' => '[a-z]+'])->name($ctrl.'/change-level');
            Route::post('/save', 'save')->name($ctrl.'/save');
        });
    });

    $prefix = Config::get('custom.route.phongtro.prefix', 'phongtro');
    $ctrl   = Config::get('custom.route.phongtro.ctrl', 'phongtro');
    Route::prefix($prefix)->group(function () use ($ctrl) {
        Route::controller(PhongTroController::class)->group(function () use ($ctrl) {
            Route::get('/', 'show')->name($ctrl);
            Route::get('/form/{id?}', 'form')->where(['id' => '[0-9]+'])->name($ctrl.'/form');
            Route::get('/form-add-cong-dan/{id?}', 'form_add_cong_dan')->where(['id' => '[0-9]+'])->name($ctrl.'/form_add_cong_dan');
            Route::get('/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name($ctrl.'/delete');
            Route::get('/change-status/{id}/{status}', 'change_status')->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($ctrl.'/change-status');
            Route::post('/save', 'save')->name($ctrl.'/save');
        });
    });

    $prefix = Config::get('custom.route.congdan.prefix', 'congdan');
    $ctrl   = Config::get('custom.route.congdan.ctrl', 'congdan');
    Route::prefix($prefix)->group(function () use ($ctrl) {
        Route::controller(CongDanController::class)->group(function () use ($ctrl) {
            Route::get('/', 'show')->name($ctrl);
            Route::get('/form/{id?}', 'form')->where(['id' => '[0-9]+'])->name($ctrl.'/form');
            Route::get('/ct01/{id?}', 'ct01')->where(['id' => '[0-9]+'])->name($ctrl.'/ct01');
            Route::get('/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name($ctrl.'/delete');
            Route::get('/change-status/{id}/{status}', 'change_status')->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($ctrl.'/change-status');
            Route::get('/change-level/{id}/{level}', 'change_level')->where(['id' => '[0-9]+', 'level' => '[a-z]+'])->name($ctrl.'/change-level');
            Route::post('/save', 'save')->name($ctrl.'/save');
        });
    });

    $prefix = Config::get('custom.route.hopdong.prefix', 'hopdong');
    $ctrl   = Config::get('custom.route.hopdong.ctrl', 'hopdong');
    Route::prefix($prefix)->group(function () use ($ctrl) {
        Route::controller(HopDongController::class)->group(function () use ($ctrl) {
            Route::get('/', 'show')->name($ctrl);
            Route::get('/form/{id?}', 'form')->where(['id' => '[0-9]+'])->name($ctrl.'/form');
            Route::get('/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name($ctrl.'/delete');
            Route::get('/change-status/{id}/{status}', 'change_status')->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($ctrl.'/change-status');
            Route::post('/save', 'save')->name($ctrl.'/save');
        });
    });

    $prefix = Config::get('custom.route.nhankhau.prefix', 'nhankhau');
    $ctrl   = Config::get('custom.route.nhankhau.ctrl', 'nhankhau');
    Route::prefix($prefix)->group(function () use ($ctrl) {
        Route::controller(NhanKhauController::class)->group(function () use ($ctrl) {
            Route::post('/save', 'save')->name($ctrl.'/save');
        });
    });
    $prefix = Config::get('custom.route.hoadon.prefix', 'hoadon');
    $ctrl   = Config::get('custom.route.hoadon.ctrl', 'hoadon');
    Route::prefix($prefix)->group(function () use ($ctrl) {
        Route::controller(HopDongController::class)->group(function () use ($ctrl) {
            Route::get('/', 'show')->name($ctrl);
            Route::get('/form/{id?}', 'form')->where(['id' => '[0-9]+'])->name($ctrl.'/form');
            Route::get('/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name($ctrl.'/delete');
            Route::get('/change-status/{id}/{status}', 'change_status')->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($ctrl.'/change-status');
            Route::post('/save', 'save')->name($ctrl.'/save');
        });
    });
});
