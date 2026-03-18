<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;

class RekapAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $kelas = $request->kelas;

        $siswaQuery = User::where('role', 'siswa');

        if ($kelas) {
            $siswaQuery->where('kelas', $kelas);
        }

        $siswa = $siswaQuery->get();
        $userIds = $siswa->pluck('id');

        $tanggal = $request->tanggal ?? now()->toDateString();

        $absensi = Absensi::whereIn('user_id', $userIds)
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->groupBy('status');

        return view('guru.rekap_absensi.index', [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'tanggal' => $tanggal,
            'hadir' => $absensi['hadir']->count() ?? 0,
            'izin'  => $absensi['izin']->count() ?? 0,
            'sakit' => $absensi['sakit']->count() ?? 0,
            'alpha' => $absensi['alpha']->count() ?? 0,
        ]);
    }
}
