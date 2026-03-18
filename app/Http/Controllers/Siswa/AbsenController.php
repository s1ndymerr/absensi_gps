<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use App\Models\Lokasi;
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

        // Cegah double absen
        $absen = Absensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        if ($absen) {
            return back()->with('error', 'Kamu sudah punya absensi hari ini');
        }

        // ==========================
        // HITUNG TERLAMBAT
        // ==========================
        $jamMasuk  = now()->format('H:i:s');
        $batasJam  = '07:00:00';
        $terlambat = $jamMasuk > $batasJam ? 1 : 0;
        $lokasi = Lokasi::where('status', 'aktif')->first();

        if (!$lokasi) {
            return back()->with('error', 'Lokasi sekolah belum disetting');
}
$jarak = $this->hitungJarak(
    $request->latitude,
    $request->longitude,
    $lokasi->latitude,
    $lokasi->longitude
);

 if ($jarak > $lokasi->radius) {
        return back()->with(
            'error',
            'Kamu terlalu jauh dari sekolah. Pastikan berada di area absensi.'
        );

 }


        Absensi::create([
            'user_id'   => $userId,
            'tanggal'   => $today,
            'status'    => 'hadir',
            'jam_masuk' => $jamMasuk,
            'terlambat' => $terlambat, // 🔥 WAJIB ADA
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
        ]);

       $pesan = 'Absen masuk berhasil';

if ($terlambat) {
    $pesan = 'Absen masuk berhasil (Anda terlambat)';
}

return back()->with('success', $pesan);
    }

    // ================= ABSEN PULANG =================
    public function pulang(Request $request)
    {
        $request->validate([
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);

        $today  = now()->toDateString();
        $userId = Auth::id();

        $absen = Absensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        if (!$absen || $absen->status !== 'hadir') {
            return back()->with('error', 'Kamu belum absen hadir');
        }
                // KUNCI JAM PULANG SISWA
        if (now()->format('H:i') < '16:00') {
            return back()->with('error', 'Absen pulang hanya bisa dilakukan setelah jam 16.00');
        }

        if ($absen->jam_pulang) {
            return back()->with('error', 'Kamu sudah absen pulang');
        }

        $absen->update([
            'jam_pulang' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Absen pulang berhasil');
    }

    // ================= IZIN / SAKIT =================
    public function izinSakit(Request $request)
    {
        $request->validate([
            'status' => 'required|in:izin,sakit',
            'alasan' => 'required|min:5',
        ]);

        $today  = now()->toDateString();
        $userId = Auth::id();

        $cek = Absensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        if ($cek) {
            return back()->with('error', 'Absensi hari ini sudah ada');
        }

        Absensi::create([
            'user_id'         => $userId,
            'tanggal'         => $today,
            'status'          => $request->status,
            'alasan'          => $request->alasan,
        ]);

        return back()->with('success', 'Pengajuan dikirim (menunggu persetujuan)');
    }
              private function hitungJarak($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371000; // meter

    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;

    $a = sin($dlat / 2) * sin($dlat / 2) +
         cos($lat1) * cos($lat2) *
         sin($dlon / 2) * sin($dlon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c;
}



        public function setAktif($id)
        {
            // 1. Matikan semua lokasi
            Lokasi::where('status', 'aktif')->update([
                'status' => 'nonaktif'
            ]);

            // 2. Aktifkan lokasi yang dipilih
            Lokasi::where('id', $id)->update([
                'status' => 'aktif'
            ]);

            return back()->with('success', 'Lokasi absensi berhasil diaktifkan');
        }

}

