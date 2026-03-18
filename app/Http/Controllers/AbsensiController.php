<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Siswa;


class AbsensiController extends Controller
{
public function index()
{
    // ABSENSI SISWA
    $absensi_siswa = Absensi::with('siswa')
        ->whereNotNull('siswa_id')
        ->orderBy('tanggal', 'desc')
        ->get();

    // ABSENSI GURU
    $absensi_guru = Absensi::with('guru')
        ->whereNotNull('guru_id')
        ->orderBy('tanggal', 'desc')
        ->get();

    return view('admin.rekap_absensi.index', compact(
        'absensi_siswa',
        'absensi_guru'
    ));
}

    public function exportExcel()
    {
        return Excel::download(new AbsensiExport, 'rekap-absensi.xlsx');
    }

    public function exportPDF()
    {
        $absensis = Absensi::with('siswa')->get();
        $pdf = PDF::loadView('admin.rekap_absensi.pdf', compact('absensis'));
        return $pdf->download('rekap-absensi.pdf');
    }
}
