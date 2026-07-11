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
use App\Http\Controllers\Provinsi\AnggaranController;
use App\Http\Controllers\Provinsi\DashboardController as DashboardProvinsiController;
use App\Http\Controllers\Provinsi\MonitoringController;
use App\Http\Controllers\Provinsi\DistribusiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('bansos', [
        'totalPenerima' => \App\Models\PenerimaBansos::count(),
        'totalProgram'  => \App\Models\JenisBansos::count(),
        'totalAnggaran' => \App\Models\Penyaluran::where('status', 'tersalur')->sum('nominal'),
        'totalRTRW'     => \App\Models\Warga::distinct('alamat')->count('alamat'),
    ]);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login-warga', [AuthController::class, 'showLoginWarga'])->name('login.warga');
Route::post('/login-warga', [AuthController::class, 'loginWarga']);

Route::get('/login-provinsi', function () {
    return view('auth.login-provinsi');
})->name('login.provinsi');

Route::get('/login-kabupaten', function () {
    return view('auth.login-kabupaten');
})->name('login.kabupaten');

Route::get('/login-kecamatan', function () {
    return view('auth.login-kecamatan');
})->name('login.kecamatan');

Route::get('/login-kelurahan', function () {
    return view('auth.login');
})->name('login.kelurahan');

Route::get('/cek-bansos', [PortalPublicController::class, 'index'])->name('portal.index');
Route::post('/cek-bansos', [PortalPublicController::class, 'cek'])->name('portal.cek');


Route::middleware('auth')->group(function () {

    // ================= DASHBOARD REDIRECTOR =================
    // /dashboard otomatis mengarahkan ke dashboard sesuai role user yang login
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'provinsi'  => redirect()->route('dashboard.provinsi'),
            'kecamatan' => redirect()->route('dashboard.kecamatan'),
            'kelurahan' => redirect()->route('dashboard.kelurahan'),
            default     => redirect()->route('dashboard.warga'),
        };
    })->name('dashboard');


    // ================= PROVINSI (khusus role: provinsi) =================
    Route::middleware('role:provinsi')->group(function () {

        Route::get('/dashboard/provinsi', [DashboardProvinsiController::class, 'index'])
            ->name('dashboard.provinsi');

        Route::get('/dashboard/cari-warga', [DashboardProvinsiController::class, 'cariWarga'])
            ->name('dashboard.cari-warga');

        Route::resource('anggaran', AnggaranController::class);

        Route::prefix('provinsi')->name('provinsi.')->group(function () {

            // Monitoring
            Route::get('monitoring', [MonitoringController::class, 'index'])
                ->name('monitoring.index');
            Route::get('monitoring/export', [MonitoringController::class, 'export'])
                ->name('monitoring.export');
            Route::get('monitoring/grafik', [MonitoringController::class, 'grafikTren'])
                ->name('monitoring.grafik');
            Route::get('monitoring/{kabupatenId}', [MonitoringController::class, 'show'])
                ->name('monitoring.show');

            // Distribusi
            Route::get('distribusi', [DistribusiController::class, 'index'])
                ->name('distribusi.index');
            Route::get('distribusi/create', [DistribusiController::class, 'create'])
                ->name('distribusi.create');
            Route::post('distribusi', [DistribusiController::class, 'store'])
                ->name('distribusi.store');
            Route::patch('distribusi/{id}/cancel', [DistribusiController::class, 'cancel'])
                ->name('distribusi.cancel');
            Route::get('distribusi/{kabupatenId}', [DistribusiController::class, 'show'])
                ->name('distribusi.show');
                Route::get('distribusi/{id}/edit', [DistribusiController::class, 'edit'])
                ->name('distribusi.edit');
            Route::put('distribusi/{id}', [DistribusiController::class, 'update'])
                ->name('distribusi.update');

        });

    });


    // ================= KECAMATAN =================
    Route::get('/dashboard/kecamatan', function () {
        return view('dashboard-kecamatan');
    })->name('dashboard.kecamatan');


    // ================= KELURAHAN =================
    Route::get('/dashboard/kelurahan', function () {
        return view('dashboard-kelurahan');
    })->name('dashboard.kelurahan');


    // ================= WARGA =================
    Route::get('/dashboard/warga', function () {
        return view('dashboard-warga');
    })->name('dashboard.warga');


    // ================= RESOURCE ROUTES (dipakai lintas role, sesuaikan nanti) =================
    Route::resource('warga', WargaController::class);

    Route::resource('penerima-bansos', PenerimaBansosController::class)
        ->parameters([
            'penerima-bansos' => 'penerimaBansos',
        ]);

    Route::resource('jenis-bansos', JenisBansosController::class);

    // Penyaluran
    Route::get('/penyaluran', [PenyaluranController::class, 'index'])->name('penyaluran.index');
    Route::get('/penyaluran/create', [PenyaluranController::class, 'create'])->name('penyaluran.create');
    Route::post('/penyaluran', [PenyaluranController::class, 'store'])->name('penyaluran.store');
    Route::get('/penyaluran/{id}/edit', [PenyaluranController::class, 'edit'])->name('penyaluran.edit');
    Route::match(['put', 'patch'], '/penyaluran/{id}', [PenyaluranController::class, 'update'])->name('penyaluran.update');
    Route::delete('/penyaluran/{id}', [PenyaluranController::class, 'destroy'])->name('penyaluran.destroy');

    // Laporan Sanggahan
    Route::get('/laporan-sanggahan', [LaporanSanggahanController::class, 'index'])->name('laporan-sanggahan.index');
    Route::post('/laporan-sanggahan', [LaporanSanggahanController::class, 'store'])->name('laporan-sanggahan.store');
    Route::put('/laporan-sanggahan/{id}', [LaporanSanggahanController::class, 'update'])->name('laporan-sanggahan.update');

    // Log Aktivitas
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    Route::get('/log-aktivitas/{id}', [LogAktivitasController::class, 'show'])->name('log-aktivitas.show');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.exportCsv');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';