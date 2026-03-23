<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    public function index()
    {
        $absen = Absensi::where('user_id', Auth::id())
            ->where('tanggal', now()->toDateString())
            ->first();

        return view('siswa.absensi', compact('absen'));
    }

    // ================= ABSEN MASUK =================
    public function masuk(Request $request)
    {
        $request->validate([
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);

        $today  = now()->toDateString();
        $userId = Auth::id();

        // 1. Cegah double absen
        $absen = Absensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        if ($absen) {
            return back()->with('error', 'Kamu sudah punya absensi hari ini');
        }

        // 2. Ambil Lokasi Aktif
        $lokasi = Lokasi::where('status', 'aktif')->first();

        if (!$lokasi) {
            return back()->with('error', 'Lokasi sekolah belum disetting atau diaktifkan oleh Admin.');
        }

        // 3. Hitung Jarak
        $jarak = $this->hitungJarak(
            $request->latitude,
            $request->longitude,
            $lokasi->latitude,
            $lokasi->longitude
        );

        // --- PROTEKSI RADIUS ---
        // Jika radius di DB adalah 0 atau null, gunakan default 100 meter
        $radiusAman = ($lokasi->radius > 0) ? $lokasi->radius : 100;

        if ($jarak > $radiusAman) {
            return back()->with(
                'error',
                'Gagal! Jarak Anda ' . round($jarak) . ' meter. Maksimal radius adalah ' . $radiusAman . ' meter.'
            );
        }

        // 4. Hitung Terlambat
        $jamMasuk  = now()->format('H:i:s');
        $batasJam  = '07:00:00';
        $terlambat = $jamMasuk > $batasJam ? 1 : 0;

        // 5. Simpan ke Database
        Absensi::create([
            'user_id'   => $userId,
            'tanggal'   => $today,
            'status'    => 'hadir',
            'jam_masuk' => $jamMasuk,
            'terlambat' => $terlambat,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'jarak_meter' => round($jarak), // Simpan jaraknya buat bukti
        ]);

        $pesan = $terlambat ? 'Absen masuk berhasil (Anda terlambat)' : 'Absen masuk berhasil tepat waktu';
        return back()->with('success', $pesan);
    }

    // ================= ABSEN PULANG =================
    public function pulang(Request $request)
    {
        $today  = now()->toDateString();
        $userId = Auth::id();

        $absen = Absensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        if (!$absen || $absen->status !== 'hadir') {
            return back()->with('error', 'Kamu belum absen hadir hari ini');
        }

        if ($absen->jam_pulang) {
            return back()->with('error', 'Kamu sudah absen pulang');
        }

        // Kunci jam pulang (Bisa dimatikan sementara untuk testing)
        if (now()->format('H:i') < '16:00') {
            return back()->with('error', 'Belum waktunya pulang! Tunggu sampai jam 16:00');
        }

        $absen->update([
            'jam_pulang' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Hati-hati di jalan, absen pulang berhasil!');
    }

    // ================= HITUNG JARAK =================
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter
        $dlat = deg2rad($lat2 - $lat1);
        $dlon = deg2rad($lon2 - $lon1);

        $a = sin($dlat / 2) * sin($dlat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dlon / 2) * sin($dlon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}

