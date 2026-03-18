<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiSiswaSheet implements FromCollection, WithHeadings
{
    protected $tanggal;
    protected $jurusan;

    public function __construct($tanggal, $jurusan = null)
    {
        $this->tanggal = $tanggal;
        $this->jurusan = $jurusan;
    }

    public function collection()
    {
        return Absensi::with('user')
            ->whereDate('tanggal',$this->tanggal)
            ->whereHas('user', function($q){
                $q->where('role','siswa');
                if($this->jurusan) $q->where('jurusan',$this->jurusan);
            })
            ->get()
            ->map(function($absen){
                return [
                    'Nama' => $absen->user->name ?? '-',
                    'Kelas' => $absen->user->kelas ?? '-',
                    'Jurusan' => $absen->user->jurusan ?? '-',
                    'Tanggal' => $absen->tanggal,
                    'Status' => ucfirst($absen->status),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama','Kelas','Jurusan','Tanggal','Status'];
    }
}
