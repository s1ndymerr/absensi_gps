<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaAbsensiController extends Controller
{
    // ==============================
    //   LOKASI SEKOLAH
    // ==============================
    private $lokasiSekolah = [
        'latitude'  => -6.912345,
        'longitude' => 107.654321,
    ];

    // ==============================
    //   HITUNG JARAK (HAVERSINE)
    // ==============================
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371000;
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

        $user = Auth::user();
        $tanggalHariIni = now()->toDateString();

        // ❗ CEK SUDAH ABSEN ATAU BELUM
        $sudahAbsen = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $tanggalHariIni)
            ->first();

        if ($sudahAbsen) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah absen hari ini',
            ], 400);
        }

        // HITUNG JARAK
        $jarak = $this->hitungJarak(
            $request->latitude,
            $request->longitude,
            $this->lokasiSekolah['latitude'],
            $this->lokasiSekolah['longitude']
        );

        $radiusMaks = 100;

        // STATUS HADIR / IZIN
        $status = $jarak <= $radiusMaks ? 'hadir' : 'izin';

        // JAM MASUK & TERLAMBAT
        $jamMasuk = now()->format('H:i:s');
        $batasJam = '07:00:00';

        $terlambat = ($status === 'hadir' && $jamMasuk > $batasJam) ? 1 : 0;

        // SIMPAN ABSENSI
        Absensi::create([
            'user_id'     => $user->id,
            'tanggal'     => $tanggalHariIni,
            'status'      => $status,
            'jam_masuk'   => $jamMasuk,
            'terlambat'   => $terlambat,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'jarak_meter' => $jarak,
        ]);

        return response()->json([
            'success'   => true,
            'status'    => $status,
            'terlambat' => $terlambat,
            'jam_masuk' => $jamMasuk,
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
