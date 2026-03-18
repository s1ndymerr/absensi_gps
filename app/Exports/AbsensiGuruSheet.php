<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiGuruSheet implements FromCollection, WithHeadings
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        return Absensi::with('user')
            ->whereDate('tanggal',$this->tanggal)
            ->whereHas('user', function($q){
                $q->where('role','guru');
            })
            ->get()
            ->map(function($absen){
                return [
                    'Nama Guru' => $absen->user->name ?? '-',
                    'Tanggal' => $absen->tanggal,
                    'Status' => ucfirst($absen->status),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Guru','Tanggal','Status'];
    }
}
