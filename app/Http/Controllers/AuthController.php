<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function authenticate(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password'   => 'required',
            'role'       => 'required|in:admin,guru,siswa',
        ]);

        $identifier = $request->identifier;
        $role = $request->role;

        // Cari user sesuai identifier dan role
        $user = User::where(function($q) use ($identifier) {
                $q->where('email', $identifier)
                  ->orWhere('username', $identifier)
                  ->orWhere('nis', $identifier)
                  ->orWhere('nip', $identifier);
            })
            ->where('role', $role)
            ->first();

        if (!$user) {
            return back()->with('error', 'Akun tidak ditemukan untuk role ' . ucfirst($role));
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        if ($user->status_akun !== 'aktif') {
            return back()->with('error', 'Akun tidak aktif');
        }

        Auth::login($user);

        // Regenerate session setelah login
        $request->session()->regenerate();

        // Redirect berdasarkan role
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru'  => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => abort(403),
        };
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
