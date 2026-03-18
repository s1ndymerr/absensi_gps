<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminGuruController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\RekapAbsensiController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Siswa\AbsenController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ProfilController;
use App\Http\Controllers\Siswa\RiwayatAbsensiController;

use App\Http\Controllers\Guru\AbsenController as GuruAbsenController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\ValidasiAbsensiController;
use App\Http\Controllers\Siswa\LandingController as SiswaLanding;
use App\Http\Controllers\Guru\LandingController as GuruLanding;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/siswa', [SiswaLanding::class, 'index']);
Route::get('/guru', [GuruLanding::class, 'index']);


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/


// LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

   Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


    Route::resource('guru', AdminGuruController::class);

    Route::get('siswa', [AdminSiswaController::class, 'index'])->name('siswa.index');
    Route::get('siswa/create', [AdminSiswaController::class, 'create'])->name('siswa.create');
    Route::post('siswa/store', [AdminSiswaController::class, 'store'])->name('siswa.store');
    Route::get('siswa/edit/{id}', [AdminSiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('siswa/update/{id}', [AdminSiswaController::class, 'update'])->name('siswa.update');
    Route::delete('siswa/destroy/{id}', [AdminSiswaController::class, 'destroy'])->name('siswa.destroy');

    Route::resource('lokasi', LokasiController::class);

    Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])
        ->name('rekap_absensi.index');
Route::get('/rekap-absensi/export-pdf', [RekapAbsensiController::class, 'exportPdf'])
        ->name('rekap_absensi.export.pdf');
    
         Route::get('/guru/{id}/edit', [AdminGuruController::class, 'edit'])->name('admin.guru.edit');
    Route::put('/guru/{id}', [AdminGuruController::class, 'update'])->name('admin.guru.update');
     Route::get('/siswa', [SiswaController::class, 'index'])
        ->name('guru.siswa.index');
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
        Route::get('/siswa', [AdminSiswaController::class, 'index'])
        ->name('siswa.index');
     


    Route::post('/lokasi/{id}/aktif', [LokasiController::class, 'setAktif'])
        ->name('lokasi.aktif');
});

/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/
Route::prefix('guru')->middleware('auth')->group(function () {

    Route::get('/dashboard', [GuruDashboardController::class, 'index'])
        ->name('guru.dashboard');

    Route::get('/absen', [GuruAbsenController::class, 'index'])
        ->name('guru.absen');

    // **PERBAIKAN NAMA ROUTE SESUAI BLADE**
    Route::post('/absensi/masuk', [GuruAbsenController::class, 'masuk'])
        ->name('guru.absensi.masuk');

    Route::post('/absensi/pulang', [GuruAbsenController::class, 'pulang'])
        ->name('guru.absensi.pulang');

    Route::post('/absensi/izin', [GuruAbsenController::class, 'izin'])
        ->name('guru.absensi.izin');

    Route::get('/validasi-absensi', [ValidasiAbsensiController::class, 'index'])
        ->name('guru.validasi');

    Route::post('/validasi-absensi/{id}/setujui', [ValidasiAbsensiController::class, 'setujui'])
        ->name('guru.validasi.setujui');

    Route::post('/validasi-absensi/{id}/tolak', [ValidasiAbsensiController::class, 'tolak'])
        ->name('guru.validasi.tolak');

     Route::get('/profil', [\App\Http\Controllers\Guru\ProfilController::class, 'index'])
        ->name('guru.profil');
        Route::get('/profil/edit', [\App\Http\Controllers\Guru\ProfilController::class, 'edit'])
        ->name('guru.profil.edit');

    Route::post('/profil/update', [\App\Http\Controllers\Guru\ProfilController::class, 'update'])
        ->name('guru.profil.update');

     Route::post('/guru/profil/update', [App\Http\Controllers\Guru\ProfilController::class, 'update'])
        ->name('guru.profil.update');
        Route::post('/guru/profil/update', [ProfilController::class, 'update'])->name('guru.profil.update');
        Route::get('/absensi/riwayat', [App\Http\Controllers\Guru\AbsenController::class, 'riwayat'])->name('guru.absensi.riwayat');
        // Daftar siswa
     Route::get('/absensi-siswa', [\App\Http\Controllers\Guru\AbsensiSiswaController::class, 'index'])
        ->name('guru.absensi.siswa');
      Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])
        ->name('guru.rekap.absensi');
    
    // Detail siswa
    
});

/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/
Route::prefix('siswa')->middleware('auth')->group(function () {

    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])
        ->name('siswa.dashboard');

    Route::get('/absen', [AbsenController::class, 'index'])
        ->name('siswa.absen');

    Route::post('/absen/masuk', [AbsenController::class, 'masuk'])
        ->name('siswa.absensi.masuk');

    Route::post('/absen/pulang', [AbsenController::class, 'pulang'])
        ->name('siswa.absensi.pulang');

    Route::post('/absen/izin-sakit', [AbsenController::class, 'izinSakit'])
        ->name('siswa.absensi.izin');

    Route::get('/profil', [ProfilController::class, 'index'])
        ->name('siswa.profil');

    Route::post('/profil', [ProfilController::class, 'update'])
        ->name('siswa.profil.update');

    Route::get('/riwayat-absen', [RiwayatAbsensiController::class, 'index'])
        ->name('siswa.riwayat.absen');
});