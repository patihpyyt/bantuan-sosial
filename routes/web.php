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
use App\Http\Controllers\LaporanSanggahanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('bansos', [
        'totalPenerima' => \App\Models\PenerimaBansos::count(),
        'totalProgram'  => \App\Models\JenisBansos::count(),
        'totalAnggaran' => \App\Models\Penyaluran::where('status', 'tersalur')->sum('nominal'),
       'totalRTRW' => \App\Models\Warga::distinct('alamat')->count('alamat'),
    ]);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard/cari-warga', [App\Http\Controllers\DashboardController::class, 'cariWarga'])
    ->name('dashboard.cari-warga');

Route::get('/login-warga', [AuthController::class, 'showLoginWarga'])->name('login.warga');
Route::post('/login-warga', [AuthController::class, 'loginWarga']);

Route::get('/cek-bansos', [PortalPublicController::class, 'index'])
->name('portal.index');

Route::post('/cek-bansos', [PortalPublicController::class, 'cek'])
->name('portal.cek');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

    Route::resource('warga', WargaController::class);
    Route::resource('penerima-bansos', PenerimaBansosController::class)
    ->parameters([
        'penerima-bansos' => 'penerimaBansos'
    ]);
    Route::resource('jenis-bansos', JenisBansosController::class);

    Route::get('/penyaluran', [PenyaluranController::class, 'index'])->name('penyaluran.index');
    Route::get('/penyaluran/create', [PenyaluranController::class, 'create'])->name('penyaluran.create');
    Route::post('/penyaluran', [PenyaluranController::class, 'store'])->name('penyaluran.store');
    
    Route::get('/laporan-sanggahan', [LaporanSanggahanController::class, 'index'])
        ->name('laporan-sanggahan.index');

    Route::post('/laporan-sanggahan', [LaporanSanggahanController::class, 'store'])
        ->name('laporan-sanggahan.store');

    Route::put('/laporan-sanggahan/{id}', [LaporanSanggahanController::class, 'update'])
        ->name('laporan-sanggahan.update');

    Route::get('/penyaluran/{id}/edit', [PenyaluranController::class, 'edit'])->name('penyaluran.edit');
    Route::match(['put', 'patch'], '/penyaluran/{id}', [PenyaluranController::class, 'update'])->name('penyaluran.update');
    Route::delete('/penyaluran/{id}', [PenyaluranController::class, 'destroy'])->name('penyaluran.destroy');

    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    Route::get('/log-aktivitas/{id}', [LogAktivitasController::class, 'show'])->name('log-aktivitas.show');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.exportCsv');
    Route::get('/laporan/export-excel',
    [LaporanController::class,'exportExcel'])
    ->name('laporan.exportExcel');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard/provinsi', function () {
        return view('dashboard-provinsi');
    })->name('dashboard.provinsi');

    Route::get('/dashboard/kabupaten', function () {
        return view('dashboard-kabupaten');
    })->name('dashboard.kabupaten');

    Route::get('/dashboard/kecamatan', function () {
        return view('dashboard-kecamatan');
    })->name('dashboard.kecamatan');

    Route::get('/dashboard/kelurahan', function () {
        return view('dashboard-kelurahan');
    })->name('dashboard.kelurahan');

    Route::get('/dashboard/warga', function () {
        return redirect()->route('dashboard');
    })->name('dashboard.warga');

});

require __DIR__.'/auth.php';