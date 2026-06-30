<?php

use App\Http\Controllers\JenisBansosController;
use App\Http\Controllers\PenerimaBansosController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PenyaluranController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PortalPublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('bansos');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/cek-bansos', [PortalPublicController::class, 'index'])->name('portal.index');
Route::post('/cek-bansos', [PortalPublicController::class, 'cek'])->name('portal.cek');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('warga', WargaController::class);
    Route::resource('penerima-bansos', PenerimaBansosController::class)
    ->parameters([
        'penerima-bansos' => 'penerimaBansos'
    ]);
    Route::resource('jenis-bansos', JenisBansosController::class);

    Route::get('/penyaluran', [PenyaluranController::class, 'index'])->name('penyaluran.index');
    Route::get('/penyaluran/create', [PenyaluranController::class, 'create'])->name('penyaluran.create');
    Route::post('/penyaluran', [PenyaluranController::class, 'store'])->name('penyaluran.store');
    Route::get('/penyaluran/{id}/edit', [PenyaluranController::class, 'edit'])->name('penyaluran.edit');
    Route::put('/penyaluran/{id}', [PenyaluranController::class, 'update'])->name('penyaluran.update');
    Route::patch('/penyaluran/{id}', [PenyaluranController::class, 'update']);
    Route::delete('/penyaluran/{id}', [PenyaluranController::class, 'destroy'])->name('penyaluran.destroy');

    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    Route::get('/log-aktivitas/{id}', [LogAktivitasController::class, 'show'])->name('log-aktivitas.show');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.exportCsv');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';