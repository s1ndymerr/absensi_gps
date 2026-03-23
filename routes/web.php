<?php

use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\AuthController;

// ADMIN
use App\Http\Controllers\AdminGuruController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\RekapAbsensiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// SISWA
use App\Http\Controllers\Siswa\AbsenController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ProfilController;
use App\Http\Controllers\Siswa\RiwayatAbsensiController;
use App\Http\Controllers\Siswa\LandingController as SiswaLanding;

// GURU
use App\Http\Controllers\Guru\AbsenController as GuruAbsenController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\ValidasiAbsensiController;
use App\Http\Controllers\Guru\LandingController as GuruLanding;
use App\Http\Controllers\Guru\ProfilController as GuruProfilController;

// HOME
use App\Http\Controllers\HomeController;





/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/siswa', [SiswaLanding::class, 'index']);
Route::get('/guru', [GuruLanding::class, 'index']);

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('guru', AdminGuruController::class);

    Route::resource('siswa', AdminSiswaController::class);

    Route::resource('lokasi', LokasiController::class);

    Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])
        ->name('rekap_absensi.index');

    Route::get('/rekap-absensi/export-pdf', [RekapAbsensiController::class, 'exportPdf'])
        ->name('rekap_absensi.export.pdf');

    Route::post('/lokasi/{id}/aktif', [LokasiController::class, 'setAktif'])
        ->name('lokasi.aktif');
});

/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/

Route::prefix('guru')->name('guru.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [GuruDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/absen', [GuruAbsenController::class, 'index'])
        ->name('absen');

    Route::post('/absensi/masuk', [GuruAbsenController::class, 'masuk'])
        ->name('absensi.masuk');

    Route::post('/absensi/pulang', [GuruAbsenController::class, 'pulang'])
        ->name('absensi.pulang');

    Route::post('/absensi/izin', [GuruAbsenController::class, 'izin'])
        ->name('absensi.izin');

    Route::get('/validasi-absensi', [ValidasiAbsensiController::class, 'index'])
        ->name('validasi');

    Route::post('/validasi-absensi/{id}/setujui', [ValidasiAbsensiController::class, 'setujui'])
        ->name('validasi.setujui');

    Route::post('/validasi-absensi/{id}/tolak', [ValidasiAbsensiController::class, 'tolak'])
        ->name('validasi.tolak');

    Route::get('/profil', [GuruProfilController::class, 'index'])
        ->name('profil');

    Route::get('/profil/edit', [GuruProfilController::class, 'edit'])
        ->name('profil.edit');

    Route::post('/profil/update', [GuruProfilController::class, 'update'])
        ->name('profil.update');

    Route::get('/absensi/riwayat', [GuruAbsenController::class, 'riwayat'])
        ->name('absensi.riwayat');

    Route::get('/absensi-siswa', [\App\Http\Controllers\Guru\AbsensiSiswaController::class, 'index'])
        ->name('absensi.siswa');

    Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])
        ->name('rekap.absensi');
});

/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::prefix('siswa')->name('siswa.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/absen', [AbsenController::class, 'index'])
        ->name('absen');

    Route::post('/absen/masuk', [AbsenController::class, 'masuk'])
        ->name('absensi.masuk');

    Route::post('/absen/pulang', [AbsenController::class, 'pulang'])
        ->name('absensi.pulang');

    Route::post('/absen/izin-sakit', [AbsenController::class, 'izinSakit'])
        ->name('absensi.izin');

    Route::get('/profil', [ProfilController::class, 'index'])
        ->name('profil');

    Route::post('/profil', [ProfilController::class, 'update'])
        ->name('profil.update');

    Route::get('/riwayat-absen', [RiwayatAbsensiController::class, 'index'])
        ->name('riwayat.absen');
        
});


Route::get('/generate-hash', function () {
    return \Illuminate\Support\Facades\Hash::make('admin123');
});
