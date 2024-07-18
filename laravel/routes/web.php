<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

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
    return view('welcome');
});

Route::prefix($prefixAdmin)->group(function () {
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
        Route::controller(userController::class)->group(function () use ($ctrl) {
            Route::get('/', 'show')->name($ctrl);
            Route::get('/form/{id?}', 'form')->where(['id' => '[0-9]+'])->name($ctrl.'/form');
            Route::get('/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name($ctrl.'/delete');
            Route::get('/change-status/{id}/{status}', 'change_status')->where(['id' => '[0-9]+', 'status' => '[a-z]+'])->name($ctrl.'/change-status');
            Route::get('/change-level/{id}/{level}', 'change_level')->where(['id' => '[0-9]+', 'level' => '[a-z]+'])->name($ctrl.'/change-level');
            Route::post('/save', 'save')->name($ctrl.'/save');
        });
    });
});
