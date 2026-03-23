<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\User; // <--- INI WAJIB ADA BIAR GAK MERAH
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil ID yang lagi login
        $userId = Auth::id();

        // Ambil data User lengkap dengan profil Siswanya (biar NIS muncul)
        $user = User::with('siswa')->find($userId);

        // Logic Absensi (Tetap seperti kodingan awal kamu)
        $hadir = Absensi::where('user_id', $userId)
            ->where('status', 'hadir')
            ->count();

        $izin = Absensi::where('user_id', $userId)
            ->where('status', 'izin')
            ->count();

        $alfa = Absensi::where('user_id', $userId)
            ->where('status', 'alfa')
            ->count();

        $tidakHadir = $izin + $alfa;
        $totalAbsensi = $hadir + $tidakHadir;

        // Cek absen hari ini
        $absenHariIni = Absensi::where('user_id', $userId)
            ->whereDate('tanggal', Carbon::today()) // Biasanya kolomnya 'tanggal' atau 'created_at'
            ->first();

        // Kirim semua variabel ke view
        return view('siswa.dashboard', compact(
            'user',
            'hadir',
            'izin',
            'alfa',
            'totalAbsensi',
            'tidakHadir',
            'absenHariIni'
        ));
    }
}