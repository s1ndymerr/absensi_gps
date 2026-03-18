<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = User::where('role', 'siswa')
            ->orderBy('kelas')
            ->orderBy('name')
            ->get()
            ->map(function ($siswa) {
                $absenHariIni = Absensi::where('user_id', $siswa->id)
                    ->whereDate('tanggal', now())
                    ->first();

                $siswa->status_absen = $absenHariIni->status ?? 'belum absen';
                return $siswa;
            });

        $totalSiswa = User::where('role', 'siswa')->count();

        $jumlahSiswaAktif = Absensi::whereDate('tanggal', now())
            ->where('status', 'hadir')
            ->count();

        $siswaBelumAbsen = $totalSiswa - $jumlahSiswaAktif;

    return view('admin.dashboard', compact(
    'totalSiswa',
    'totalGuru',
    'hadirHariIni',
     'persenGuru',
     'persenSiswa',
    'grafikMingguan',
    'aktivitasTerbaru',
    'siswaTerlambat'
));
    }
}
