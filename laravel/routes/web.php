<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

$prefixAdmin = Config::get('custom.route.prefix_admin', 'admin');


Route::get('/', function () {
    return view('welcome');
});

Route::prefix($prefixAdmin)->group(function () {
    $prefixAdminSlider = 'slider';

    Route::get('/user', function () {
        return '/admin/user';
    });

    Route::prefix($prefixAdminSlider)->group(function () {

        Route::controller(SliderController::class)->group(function () {

            Route::get('/{id}', 'index');

            Route::get('/edit/{id}/{name}', 'edit')->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

            Route::get('/delete/{id}', 'delete')->where(['id' => '[0-9]+']);

        });
    });

    Route::get('/category', function () {
        return '/admin/category';
    });
});
