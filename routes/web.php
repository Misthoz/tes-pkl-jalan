<?php

use App\Http\Controllers\jalanController;
use App\Http\Controllers\kecamatanController;
use App\Http\Controllers\kelurahanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

route::resource('kecamatan', kecamatanController::class);
route::resource('kelurahan', kelurahanController::class);
route::resource('jalan', jalanController::class);
