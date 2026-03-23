<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Lokasi; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return $R * (2 * atan2(sqrt($a), sqrt(1 - $a)));
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

        // AMBIL LOKASI DARI DATABASE (PENTING!)
        $lokasiAktif = Lokasi::where('status', 'aktif')->first();

        if (!$lokasiAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi sekolah belum diaktifkan oleh Admin.',
            ], 400);
        }

        $user = Auth::user();
        $tanggalHariIni = now()->toDateString();

        // CEK SUDAH ABSEN ATAU BELUM
        $sudahAbsen = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $tanggalHariIni)
            ->first();

        if ($sudahAbsen) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah absen hari ini',
            ], 400);
        }

        // HITUNG JARAK BERDASARKAN DATABASE
        $jarak = $this->hitungJarak(
            $request->latitude,
            $request->longitude,
            $lokasiAktif->latitude,
            $lokasiAktif->longitude
        );

        // Kasih radius agak longgar (misal 150 meter) biar nggak rewel GPS-nya
        $radiusMaks = 150; 

        // Kalau jaraknya lebih dari radius, TOLAK ABSEN (Biar nggak langsung 'izin')
        if ($jarak > $radiusMaks) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal! Jarak Anda ' . round($jarak) . ' meter dari sekolah. Maksimal radius ' . $radiusMaks . ' meter.',
            ], 400);
        }

        // Jika dalam radius, status otomatis HADIR
        $status = 'hadir';

        // JAM MASUK & TERLAMBAT
        $jamMasuk = now()->format('H:i:s');
        $batasJam = '07:00:00';
        $terlambat = ($jamMasuk > $batasJam) ? 1 : 0;

        // SIMPAN
        Absensi::create([
            'user_id'     => $user->id,
            'tanggal'     => $tanggalHariIni,
            'status'      => $status,
            'jam_masuk'   => $jamMasuk,
            'terlambat'   => $terlambat,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'jarak_meter' => round($jarak),
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Absen Berhasil! Jarak Anda: ' . round($jarak) . 'm',
            'status'    => $status,
            'jam_masuk' => $jamMasuk,
        ]);
    }
}