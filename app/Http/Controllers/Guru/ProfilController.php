<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan model User di-import

class ProfilController extends Controller
{
    public function index()
    {
        // PENTING: Pakai with('guru') supaya data NIP dll ikut terbawa
        $user = User::with('guru')->find(Auth::id());
        return view('guru.profil', compact('user'));
    }

    public function edit()
    {
        $user = User::with('guru')->find(Auth::id());
        return view('guru.profil_edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input untuk User DAN Guru
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip'   => 'nullable|string|max:20', // Tambahkan validasi NIP
        ]);

        // 1. Update data dasar di tabel users
        $user->update($request->only('name', 'email'));

        // 2. Update atau Buat data di tabel gurus (Relasi)
        // Ini kunci supaya NIP dan Kelas Pengampu tersimpan
        $user->guru()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nip' => $request->nip,
                'kelas_pengampu' => $request->kelas_pengampu,
                'jurusan' => $request->jurusan,
            ]
        );

        return redirect()->route('guru.profil')
            ->with('success', 'Profil berhasil diperbarui');
    }
}