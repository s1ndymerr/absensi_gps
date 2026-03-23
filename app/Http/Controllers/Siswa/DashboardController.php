<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\User; // Tambahkan ini
use Carbon\Carbon;

class DashboardController extends Controller
{
   public function index()
   {
        $userId = auth()->id();

        // AMBIL DATA USER BESERTA RELASI SISWA-NYA
        $user = User::with('siswa')->find($userId);

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

        $absenHariIni = Absensi::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->first();

        return view('siswa.dashboard', compact(
            'user', // KIRIM VARIABEL USER KE VIEW
            'hadir',
            'izin',
            'alfa',
            'totalAbsensi',
            'tidakHadir',
            'absenHariIni'
        ));
   }
}