<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class ValidasiAbsensiController extends Controller
{
    public function index()
    {
        $pengajuan = Absensi::whereIn('status', ['izin', 'sakit'])
            ->where('approval_status', 'pending')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('guru.validasi_absensi', compact('pengajuan'));
    }

    public function setujui($id)
    {
        Absensi::where('id', $id)->update([
            'approval_status' => 'disetujui'
        ]);

        return back()->with('success', 'Pengajuan disetujui');
    }

    public function tolak($id)
    {
        Absensi::where('id', $id)->update([
            'approval_status' => 'ditolak'
        ]);

        return back()->with('success', 'Pengajuan ditolak');
    }
}
