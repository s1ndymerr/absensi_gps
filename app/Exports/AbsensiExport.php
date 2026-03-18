<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AbsensiExport implements WithMultipleSheets
{
    protected $tanggal;
    protected $jurusan;

    public function __construct($tanggal, $jurusan = null)
    {
        $this->tanggal = $tanggal;
        $this->jurusan = $jurusan;
    }

    public function sheets(): array
    {
        return [
            new AbsensiSiswaSheet($this->tanggal, $this->jurusan),
            new AbsensiGuruSheet($this->tanggal),
        ];
    }
}
