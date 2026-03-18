<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    // tampilkan halaman profil
    public function index()
    {
       $user = Auth::user()->fresh();

        return view('siswa.profil', compact('user'));
    }

    // update profil
   public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6|confirmed',
    ]);

    $user->update([
        'name'  => $request->name,
        'email' => $request->email,
    ]);

    if ($request->password) {
        $user->update([
            'password' => Hash::make($request->password),
        ]);
    }

    // refresh session user
    Auth::setUser($user->fresh());

    return redirect()->route('siswa.profil')
        ->with('success', 'Profil berhasil diperbarui');
}

}
