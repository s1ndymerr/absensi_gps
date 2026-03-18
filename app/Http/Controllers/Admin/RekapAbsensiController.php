<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapAbsensiController extends Controller
{
    private function jurusanKelas()
    {
        $jurusan = ['RPL','TKJ','TKR','AK','DPIB','MP','SK'];
        $kelas = [1,2,3];

        $data = [];
        foreach ($jurusan as $j) {
            foreach ($kelas as $k) {
                $data[] = $j.' '.$k;
            }
        }
        return $data;
    }

    // =========================
    // HALAMAN INDEX
    // =========================
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();
        $tipe = $request->tipe ?? 'siswa';

        $tingkat = $request->tingkat;
        $jurusan_kelas = $request->jurusan_kelas;

        $listTingkat = ['X','XI','XII'];
        $listJurusanKelas = $this->jurusanKelas();

        $kelasFull = null;
        if ($tingkat && $jurusan_kelas) {
            $kelasFull = trim($tingkat.' '.$jurusan_kelas);
        }

        $rekap_siswa = collect();
        $rekap_per_kelas = collect();
        $rekap_guru = collect();

        // ================== SISWA ==================
        if ($tipe === 'siswa') {

    $querySiswa = User::where('role','siswa')
        ->where('status_akun','aktif')
        ->when($tingkat, function ($q) use ($tingkat) {
            $q->where('kelas', 'like', $tingkat.' %');
        })
        ->when($jurusan_kelas, function ($q) use ($jurusan_kelas) {
            $q->where('kelas', 'like', '% '.$jurusan_kelas);
        })
        ->orderBy('kelas')
        ->orderBy('name');

    $siswa = $querySiswa->get();

    $rekap_siswa = $siswa->map(function ($s) use ($tanggal) {
        $absen = Absensi::where('user_id', $s->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        return [
            'nama'   => $s->name,
            'kelas'  => $s->kelas,
            'status' => $absen ? $absen->status : 'alpha',
        ];
    });

    $rekap_per_kelas = $rekap_siswa
        ->groupBy('kelas')
        ->map(fn ($i) => [
            'hadir' => $i->where('status','hadir')->count(),
            'izin'  => $i->where('status','izin')->count(),
            'alpha' => $i->where('status','alpha')->count(),
            'total' => $i->count(),
        ]);
}


        // ================== GURU ==================
        if ($tipe === 'guru') {
            $rekap_guru = User::where('role','guru')
                ->where('status_akun','aktif')
                ->orderBy('name')
                ->get()
                ->map(function ($g) use ($tanggal) {
                    $absen = Absensi::where('user_id', $g->id)
                        ->whereDate('tanggal', $tanggal)
                        ->first();

                    return [
                        'nama'   => $g->name,
                        'status' => $absen->status ?? 'alpha',
                    ];
                });
        }

        return view('admin.rekap_absensi.index', compact(
            'tanggal',
            'tipe',
            'tingkat',
            'jurusan_kelas',
            'listTingkat',
            'listJurusanKelas',
            'rekap_siswa',
            'rekap_per_kelas',
            'rekap_guru'
        ));
    }

    // =========================
    // EXPORT PDF
    // =========================
    public function exportPdf(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();
        $tipe = $request->tipe ?? 'siswa';
        $mode = $request->mode ?? 'detail'; // ringkasan | detail

        $tingkat = $request->tingkat;
        $jurusan_kelas = $request->jurusan_kelas;

        $kelasFull = null;
        if ($tingkat && $jurusan_kelas) {
            $kelasFull = trim($tingkat.' '.$jurusan_kelas);
        }

        $rekap_siswa = collect();
        $rekap_per_kelas = collect();
        $rekap_guru = collect();

        // ================== SISWA ==================
        if ($tipe === 'siswa') {
            $siswa = User::where('role','siswa')
                ->where('status_akun','aktif')
                ->when($kelasFull, fn ($q) => $q->where('kelas', $kelasFull))
                ->orderBy('kelas')
                ->orderBy('name')
                ->get();

            $rekap_siswa = $siswa->map(function ($s) use ($tanggal) {
                $absen = Absensi::where('user_id', $s->id)
                    ->whereDate('tanggal', $tanggal)
                    ->first();

                $kelasParts = explode(' ', $s->kelas);

                return [
                    'nama'    => $s->name,
                    'kelas'   => $s->kelas,
                    'jurusan' => $kelasParts[1] ?? '-',
                    'status'  => $absen->status ?? 'alpha',
                ];
            });

            if ($mode !== 'detail') {
                $rekap_per_kelas = $rekap_siswa
                    ->groupBy('kelas')
                    ->map(fn ($i) => [
                        'hadir' => $i->where('status','hadir')->count(),
                        'izin'  => $i->where('status','izin')->count(),
                        'alpha' => $i->where('status','alpha')->count(),
                        'total' => $i->count(),
                    ]);
            }
        }

        // ================== GURU ==================
        if ($tipe === 'guru') {
            $rekap_guru = User::where('role','guru')
                ->where('status_akun','aktif')
                ->orderBy('name')
                ->get()
                ->map(function ($g) use ($tanggal) {
                    $absen = Absensi::where('user_id', $g->id)
                        ->whereDate('tanggal', $tanggal)
                        ->first();

                    return [
                        'nama'   => $g->name,
                        'status' => $absen->status ?? 'alpha',
                    ];
                });
        }
$mode = request('mode');
        return Pdf::loadView('admin.rekap_absensi.pdf', compact(
            'tanggal',
            'tipe',
            'tingkat',
            'jurusan_kelas',
            'rekap_siswa',
            'rekap_per_kelas',
            'rekap_guru',
            'mode'
        ))
        ->setPaper('A4', 'portrait')
        ->stream('rekap-absensi-'.$tipe.'-'.$tanggal.'.pdf');
    }
}
