<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiSiswaController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ambil semua siswa + absensi hari ini
        $siswas = User::where('role', 'siswa')
            ->with(['absensis' => function ($q) use ($today) {
                $q->whereDate('tanggal', $today);
            }])
            ->get();

        // total siswa
        $totalSiswa = $siswas->count();

        // total sudah absen hari ini
        $sudahAbsen = Absensi::whereDate('tanggal', $today)
    ->distinct('user_id')
    ->count('user_id');


        // hadir
        $hadir = Absensi::whereDate('tanggal', $today)
            ->where('status', 'hadir')
            ->count();

        // terlambat
        $terlambat = Absensi::whereDate('tanggal', $today)
            ->where('status', 'terlambat')
            ->count();

        // belum absen
        $belumAbsen = $totalSiswa - $sudahAbsen;

        return view('guru.absensi_siswa.index', compact(
    'siswas',
    'totalSiswa',
    'sudahAbsen',
    'hadir',
    'terlambat',
    'belumAbsen'
));
    }
}
