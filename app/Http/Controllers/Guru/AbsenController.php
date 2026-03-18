<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use Carbon\Carbon;
use App\Models\Lokasi;


class AbsenController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();

        $absenHariIni = Absensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        return view('guru.absensi', compact('absenHariIni'));
    }

  public function masuk(Request $request)
{
    $request->validate([
        'latitude'  => 'required',
        'longitude' => 'required',
    ]);

    $userId = Auth::id();
    $today = Carbon::today()->toDateString();

    // Cek sudah absen hari ini
    if (Absensi::where('user_id', $userId)->where('tanggal', $today)->exists()) {
        return back()->with('error', 'Anda sudah melakukan absensi hari ini.');
    }

    // LOGIC JAM MASUK
    $jamSekarang = Carbon::now()->format('H:i');
    $batasMasuk = '08:00';

    $terlambat = $jamSekarang > $batasMasuk;
    $lokasi = Lokasi::where('status', 'aktif')->first();

        if (!$lokasi) {
            return back()->with('error', 'Lokasi absensi belum diset.');
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
        'terlambat' => $terlambat, // 👈 FLAG
        'jam_masuk' => Carbon::now()->format('H:i:s'),
        'latitude_masuk'  => $request->latitude,
        'longitude_masuk' => $request->longitude,
    ]);

    return back()->with(
        'success',
        $terlambat
            ? 'Absen masuk berhasil (Anda terlambat)'
            : 'Absen masuk berhasil'
    );
}

   public function pulang(Request $request)
{
    $request->validate([
        'latitude'  => 'required',
        'longitude' => 'required',
    ]);

    $userId = Auth::id();
    $today = Carbon::today()->toDateString();

    // KUNCI JAM PULANG
    if (Carbon::now()->format('H:i') < '16:00') {
        return back()->with('error', 'Absen pulang hanya bisa dilakukan setelah jam 16.00');
    }

    $absen = Absensi::where('user_id', $userId)
        ->where('tanggal', $today)
        ->where('status', 'hadir')
        ->first();

    if (!$absen) {
        return back()->with('error', 'Anda belum melakukan absen masuk.');
    }

    if ($absen->jam_pulang) {
        return back()->with('error', 'Anda sudah melakukan absen pulang.');
    }

    $absen->update([
        'jam_pulang' => Carbon::now()->format('H:i:s'),
        'latitude_pulang'  => $request->latitude,
        'longitude_pulang' => $request->longitude,
    ]);

    return back()->with('success', 'Absen pulang berhasil');
}


    public function izin(Request $request)
    {
        $request->validate([
            'status' => 'required|in:izin,sakit',
            'alasan' => 'required',
        ]);

        $userId = Auth::id();
        $today = Carbon::today()->toDateString();

        if (Absensi::where('user_id', $userId)->where('tanggal', $today)->exists()) {
            return back()->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        Absensi::create([
            'user_id' => $userId,
            'tanggal' => $today,
            'status'  => $request->status,
            'alasan'  => $request->alasan,
        ]);

        return back()->with('success', 'Pengajuan ' . $request->status . ' berhasil.');
    }

    public function riwayat()
    {
        $absensi = Absensi::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('guru.riwayat_absen', compact('absensi'));
    }
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371000; // meter

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);

    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earthRadius * $c;
}

}
