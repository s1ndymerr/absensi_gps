<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Ambil semua siswa
        $siswas = User::where('role', 'siswa')
            ->orderBy('kelas')
            ->orderBy('name')
            ->get()
            ->map(function ($siswa) use ($today) {

                // Cek absensi hari ini
                $absen = Absensi::where('user_id', $siswa->id)
                    ->whereDate('tanggal', $today)
                    ->first();

                if (!$absen) {
                    $siswa->status_absen = 'Belum Absen';
                    $siswa->badge = 'secondary';
                } else {
                    switch ($absen->status) {
                        case 'hadir':
                            $siswa->status_absen = 'Hadir';
                            $siswa->badge = 'success';
                            break;
                        case 'izin':
                            $siswa->status_absen = 'Izin';
                            $siswa->badge = 'warning';
                            break;
                        case 'sakit':
                            $siswa->status_absen = 'Sakit';
                            $siswa->badge = 'danger';
                            break;
                        default:
                            $siswa->status_absen = 'Tidak Diketahui';
                            $siswa->badge = 'dark';
                    }
                }

                return $siswa;
            });
              // ✅ INI YANG KURANG
    $totalSiswa = User::where('role', 'siswa')->count();
    $siswaHadir = Absensi::whereDate('tanggal', now())
        ->where('status', 'hadir')
        ->count();
    $siswaBelumAbsen = $totalSiswa - $siswaHadir;

    return view('admin.siswa.index', compact(
        'siswas',
        'totalSiswa',
        'siswaHadir',
        'siswaBelumAbsen'
    ));
// ================== CARD INFO ==================
    $totalSiswa = User::where('role', 'siswa')->count();

    // SISWA AKTIF = yang hadir hari ini
    $jumlahSiswaAktif = Absensi::whereDate('tanggal', now())
        ->where('status', 'hadir')
        ->count();

    $siswaBelumAbsen = $totalSiswa - $jumlahSiswaAktif;

    return view('admin.siswa.index', compact(
        'siswas',
        'totalSiswa',
        'jumlahSiswaAktif',
        'siswaBelumAbsen'
    ));
        return view('admin.siswa.index', compact('siswas'));
    }
    
   public function show($id)
{
    $siswa = User::where('role', 'siswa')->findOrFail($id);

    $absensis = Absensi::where('user_id', $siswa->id)
        ->orderBy('tanggal', 'desc')
        ->get();

    return view('admin.siswa.show', compact('siswa', 'absensis'));
}

}
