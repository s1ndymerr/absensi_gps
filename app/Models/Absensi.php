<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
    'user_id',
    'tanggal',
    'status',
    'terlambat',
    'alasan',
    'jam_masuk',
    'jam_pulang',
    'latitude',
    'longitude',
    'jarak_meter',
];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
