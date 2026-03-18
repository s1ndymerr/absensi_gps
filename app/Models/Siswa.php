<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'users'; // pakai tabel users

    protected $fillable = [
        'name',
        'nis',
        'username',
        'email',
        'password',
        'role',
        'kelas',
        'status_akun'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function absensis()
{
    return $this->hasMany(Absensi::class, 'user_id');
}
}
