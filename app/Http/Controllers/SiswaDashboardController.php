<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'siswa') {
                abort(403, 'Anda tidak memiliki akses.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $siswa = Auth::user();
        return view('layouts.siswa', compact('siswa'));
    }
}
