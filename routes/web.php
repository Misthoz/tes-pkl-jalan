<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\jalanController;
use App\Http\Controllers\kecamatanController;
use App\Http\Controllers\kelurahanController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\RiwayatKondisiController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\UserController;
use App\Models\kelurahan;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kecamatan', kecamatanController::class);
    Route::resource('kelurahan', kelurahanController::class);
    Route::resource('jalan', jalanController::class);
    Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');
    Route::post('/dokumentasi', [DokumentasiController::class, 'store'])->name('dokumentasi.store');
    Route::delete('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'destroy'])->name('dokumentasi.destroy');
    Route::post('/riwayat-kondisi', [RiwayatKondisiController::class, 'store'])->name('riwayat-kondisi.store');
    Route::get('/export/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/api/kelurahan-by-kecamatan/{kecamatan_id}', function ($kecamatan_id) {
        return kelurahan::where('kecamatan_id', $kecamatan_id)->orderBy('nama_kelurahan')->get();
    })->name('api.kelurahan');

    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
        Route::patch('/trash/{id}/restore', [TrashController::class, 'restore'])->name('trash.restore');
        Route::delete('/trash/{id}/force-delete', [TrashController::class, 'forceDelete'])->name('trash.force-delete');
        Route::patch('/trash/kelurahan/{id}/restore', [TrashController::class, 'restoreKelurahan'])->name('trash.kelurahan.restore');
        Route::delete('/trash/kelurahan/{id}/force-delete', [TrashController::class, 'forceDeleteKelurahan'])->name('trash.kelurahan.force-delete');
        Route::patch('/trash/kecamatan/{id}/restore', [TrashController::class, 'restoreKecamatan'])->name('trash.kecamatan.restore');
        Route::delete('/trash/kecamatan/{id}/force-delete', [TrashController::class, 'forceDeleteKecamatan'])->name('trash.kecamatan.force-delete');
    });
});
