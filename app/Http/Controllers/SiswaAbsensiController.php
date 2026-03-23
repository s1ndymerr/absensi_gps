<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Lokasi; // 1. Pastikan Model Lokasi di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class SiswaAbsensiController extends Controller
{
    // ==============================
    //   HITUNG JARAK (HAVERSINE)
    // ==============================
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371000; // Radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }

    // ==============================
    //   ABSEN MASUK SISWA
    // ==============================
    public function absen(Request $request)
    {
        $request->validate([
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);

        // 2. AMBIL LOKASI AKTIF DARI DATABASE
        $lokasiAktif = Lokasi::where('status', 'aktif')->first();

        // Cek jika admin belum mengaktifkan lokasi manapun
        if (!$lokasiAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal absen: Lokasi sekolah belum diaktifkan oleh Admin.',
            ], 400);
        }

        $user = Auth::user();
        $tanggalHariIni = now()->toDateString();

        // 3. CEK SUDAH ABSEN ATAU BELUM
        $sudahAbsen = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $tanggalHariIni)
            ->first();

        if ($sudahAbsen) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah absen hari ini',
            ], 400);
        }

        // 4. HITUNG JARAK BERDASARKAN LOKASI DARI DB
        $jarak = $this->hitungJarak(
            $request->latitude,
            $request->longitude,
            $lokasiAktif->latitude,
            $lokasiAktif->longitude
        );

        // Radius toleransi (bisa kamu ubah sesuai kebutuhan)
        $radiusMaks = 100; 

        // Logika kamu: Tetap "Izin" kalau jauh
        $status = $jarak <= $radiusMaks ? 'hadir' : 'izin';

        // JAM MASUK & TERLAMBAT
        $jamMasuk = now()->format('H:i:s');
        $batasJam = '07:00:00';

        // Hanya dianggap terlambat jika statusnya 'hadir' tapi lewat jam 7
        $terlambat = ($status === 'hadir' && $jamMasuk > $batasJam) ? 1 : 0;

        // 5. SIMPAN ABSENSI
        $absensi = Absensi::create([
            'user_id'     => $user->id,
            'tanggal'     => $tanggalHariIni,
            'status'      => $status,
            'jam_masuk'   => $jamMasuk,
            'terlambat'   => $terlambat,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'jarak_meter' => round($jarak), // Kita bulatkan biar rapi
        ]);

        return response()->json([
            'success'   => true,
            'message'   => $status === 'hadir' ? 'Absen Berhasil (Hadir)' : 'Anda diluar radius, status otomatis: Izin',
            'status'    => $status,
            'terlambat' => $terlambat,
            'jam_masuk' => $jamMasuk,
            'jarak'     => round($jarak) . " meter",
        ]);
    }

    // ==============================
    //   HISTORI ABSENSI SISWA
    // ==============================
    public function history()
    {
        $data = Absensi::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->get();

        return response()->json($data);
    }
}