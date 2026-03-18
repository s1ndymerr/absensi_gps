<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapAbsensiExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected $tanggal,
        protected $jurusan,
        protected $kelas
    ) {}

    public function collection()
    {
        $users = User::where('role','siswa')
            ->when($this->jurusan, fn($q)=>$q->where('jurusan',$this->jurusan))
            ->when($this->kelas, fn($q)=>$q->where('kelas',$this->kelas))
            ->get();

        return $users->map(function($u){
            $absen = Absensi::where('user_id',$u->id)
                ->whereDate('tanggal',$this->tanggal)
                ->first();

            return [
                $u->name,
                $u->kelas,
                $u->jurusan,
                $absen->status ?? 'alpha',
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama','Kelas','Jurusan','Status'];
    }
}
