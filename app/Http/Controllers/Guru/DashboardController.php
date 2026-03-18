<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $hadir = Absensi::where('user_id', $user->id)
                        ->where('status', 'hadir')
                        ->count();

        $izin = Absensi::where('user_id', $user->id)
                       ->where('status', 'izin')
                       ->count();

        $sakit = Absensi::where('user_id', $user->id)
                        ->where('status', 'sakit')
                        ->count();

        $total = $hadir + $izin + $sakit;

        return view('guru.dashboard', compact(
            'user',
            'hadir',
            'izin',
            'sakit',
            'total'
        ));
    }
}
