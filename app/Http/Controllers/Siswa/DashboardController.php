<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use Carbon\Carbon; // Tambahkan ini

class DashboardController extends Controller
{
   public function index()
   {
       $userId = auth()->id();

       $hadir = Absensi::where('user_id', $userId)
           ->where('status', 'hadir')
           ->count();

       $izin = Absensi::where('user_id', $userId)
           ->where('status', 'izin')
           ->count();

       $alfa = Absensi::where('user_id', $userId)
           ->where('status', 'alfa')
           ->count();

       // TOTAL SEMUA
       $tidakHadir = $izin + $alfa;
       $totalAbsensi = $hadir + $tidakHadir;

       // -------------------------
       // Tambahkan definisi $absenHariIni
       $absenHariIni = Absensi::where('user_id', $userId)
           ->whereDate('created_at', Carbon::today())
           ->first(); // tetap satu record, tidak merubah logika
       // -------------------------

       return view('siswa.dashboard', compact(
           'hadir',
           'izin',
           'alfa',
           'totalAbsensi',
           'tidakHadir',
           'absenHariIni' // tambahkan di compact
       ));
   }
}
