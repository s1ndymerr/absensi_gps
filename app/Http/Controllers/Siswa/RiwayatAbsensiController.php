<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;

class RiwayatAbsensiController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $riwayat = Absensi::with('user') // Ambil data user (nama & kelas)
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.riwayat-absen', compact('riwayat'));
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
