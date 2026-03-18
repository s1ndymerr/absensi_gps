<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
        protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'nip',
        'password',
        'status_akun'
    ];

    public function absensis()
{
    return $this->hasMany(Absensi::class);
}

}
