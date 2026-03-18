<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================
        // TOTAL USER
        // =====================
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru  = User::where('role', 'guru')->count();
        $guruBaru = User::where('role', 'guru')
    ->whereDate('created_at', Carbon::today())
    ->count();
     $siswaBaru = User::where('role', 'siswa')
    ->whereDate('created_at', Carbon::today())
    ->count();


        // =====================
        // HADIR HARI INI (UNIK PER USER)
        // =====================
        $hadirHariIni = Absensi::whereDate('tanggal', Carbon::today())
            ->where('status', 'hadir')
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        // =====================
        // PERSENTASE (AMAN DIVIDE BY ZERO)
        // =====================
        $persenGuru = $totalGuru > 0
            ? round(($hadirHariIni / $totalGuru) * 100)
            : 0;

        $persenSiswa = $totalSiswa > 0
            ? round(($hadirHariIni / $totalSiswa) * 100)
            : 0;
$periode = request('periode', 'minggu'); // default: minggu
$grafikMingguan = [];
// =====================
// GRAFIK (MINGGU / BULAN / TAHUN)
// =====================

if ($periode == 'minggu') {
    // Senin - Sabtu minggu ini
    $start = Carbon::now()->startOfWeek(Carbon::MONDAY);
    $end   = Carbon::now()->startOfWeek(Carbon::MONDAY)->addDays(5); // sampai Sabtu

    for ($date = $start->copy(); $date <= $end; $date->addDay()) {
        $jumlahHadir = Absensi::whereDate('tanggal', $date)
            ->where('status', 'hadir')
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        $grafikMingguan[] = [
            'hari'   => $date->translatedFormat('D'), // Sen, Sel, Rab, dst
            'jumlah' => $jumlahHadir
        ];
    }
} 
elseif ($periode == 'bulan') {
   // =====================
// GRAFIK (DEFAULT: BULAN INI PER MINGGU)
// =====================
$grafikMingguan = [];

// Ambil awal & akhir bulan ini
$startMonth = Carbon::now()->startOfMonth();
$endMonth   = Carbon::now()->endOfMonth();

$mingguKe = 1;
$current = $startMonth->copy();

while ($current <= $endMonth) {
    $weekStart = $current->copy();
    $weekEnd   = $current->copy()->endOfWeek(Carbon::SUNDAY);

    if ($weekEnd > $endMonth) {
        $weekEnd = $endMonth->copy();
    }

    $jumlahHadir = Absensi::whereBetween('tanggal', [$weekStart, $weekEnd])
        ->where('status', 'hadir')
        ->whereNotNull('user_id')
        ->distinct('user_id')
        ->count('user_id');

    $grafikMingguan[] = [
        'hari'   => 'Minggu ' . $mingguKe,  // ✅ INI YANG GANTI LABEL
        'jumlah' => $jumlahHadir
    ];

    $mingguKe++;
    $current = $weekEnd->addDay();
}
}
 
elseif ($periode == 'tahun') {
    // Januari - Desember tahun ini
    for ($bulan = 1; $bulan <= 12; $bulan++) {
        $jumlahHadir = Absensi::whereYear('tanggal', Carbon::now()->year)
            ->whereMonth('tanggal', $bulan)
            ->where('status', 'hadir')
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        $grafikMingguan[] = [
            'hari'   => Carbon::create()->month($bulan)->translatedFormat('M'), // Jan, Feb, Mar, dst
            'jumlah' => $jumlahHadir
        ];
    }
}

        // =====================
        // AKTIVITAS TERBARU
        // =====================
        $aktivitasTerbaru = Absensi::with('user')
            ->whereNotNull('user_id')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // =====================
        // SISWA TERLAMBAT HARI INI
        // =====================
        $siswaTerlambat = Absensi::with('user')
            ->whereDate('tanggal', Carbon::today())
            ->where('status', 'hadir')
            ->where('terlambat', 1) // aman untuk tinyint / boolean
            ->whereNotNull('user_id')
            ->orderBy('jam_masuk', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'guruBaru', 
            'siswaBaru',
            'hadirHariIni',
            'persenGuru',
            'persenSiswa',
            'grafikMingguan',
            'aktivitasTerbaru',
            'siswaTerlambat'
        ));
    }
    
}
