<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi mass assignment
     */
   protected $fillable = [
        'nis',
        'nisn',
        'kelas',
        'jurusan',
        'tahun_masuk',
        'nama_orang_tua',
        'nomor_telepon',
        'tanggal_lahir',
        'nip',
        'username',
        'name',
        'email',
        'password',
        'role',
        'status_akun',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function absensis()
{
    return $this->hasMany(Absensi::class, 'user_id');
}


}