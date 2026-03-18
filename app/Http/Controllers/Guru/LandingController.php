<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }
}
