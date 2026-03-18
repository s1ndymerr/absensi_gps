<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSiswaController extends Controller
{
    // ===================== LIST SISWA =====================
    public function index()
    {
      $siswas = User::where('role', 'siswa')
    ->orderBy('nis', 'asc')
    ->paginate(10);


        $jumlahSiswaAktif = User::where('role', 'siswa')
            ->where('status_akun', 'aktif')
            ->count();
        $totalSiswa = User::where('role', 'siswa')->count();
       $siswaBaru = User::where('role', 'siswa')
    ->whereDate('created_at', today())
    ->count();

        return view('admin.siswa.index', compact(
            'siswas',
            'jumlahSiswaAktif',
            'totalSiswa',
            'siswaBaru'
        ));
    }

    // ===================== FORM TAMBAH =====================
    public function create()
    {
        return view('admin.siswa.create');
    }

    // ===================== SIMPAN SISWA =====================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'status_akun' => 'required|in:aktif,tidak_aktif',
            'nis' => 'required|unique:users,nis',
            'nisn' => 'nullable|unique:users,nisn',
            'tingkat' => 'required',
            'jurusan_kelas' => 'required',
            'tahun_masuk' => 'nullable|digits:4',
            'nama_orang_tua' => 'nullable|string',
            'nomor_telepon' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $kelas = trim($validated['tingkat'].' '.$validated['jurusan_kelas']);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status_akun' => $validated['status_akun'],
            'role' => 'siswa',
            'nis' => $validated['nis'],
            'nisn' => $validated['nisn'] ?? null,
            'kelas' => $kelas,
            'tahun_masuk' => $validated['tahun_masuk'] ?? null,
            'nama_orang_tua' => $validated['nama_orang_tua'] ?? null,
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    // ===================== FORM EDIT =====================
    public function edit($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    // ===================== UPDATE SISWA =====================
    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->id,
            'password' => 'nullable|confirmed|min:8',
            'status_akun' => 'required|in:aktif,tidak_aktif',
            'nis' => 'required|unique:users,nis,' . $siswa->id,
            'nisn' => 'nullable|unique:users,nisn,' . $siswa->id,
            'tingkat' => 'required',
            'jurusan_kelas' => 'required',
            'tahun_masuk' => 'nullable|digits:4',
            'nama_orang_tua' => 'nullable|string',
            'nomor_telepon' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $kelas = trim($validated['tingkat'].' '.$validated['jurusan_kelas']);

        $siswa->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'status_akun' => $validated['status_akun'],
            'nis' => $validated['nis'],
            'nisn' => $validated['nisn'] ?? null,
            'kelas' => $kelas,
            'tahun_masuk' => $validated['tahun_masuk'] ?? null,
            'nama_orang_tua' => $validated['nama_orang_tua'] ?? null,
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
        ]);

        if ($request->filled('password')) {
            $siswa->password = Hash::make($validated['password']);
            $siswa->save();
        }

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    // ===================== HAPUS SISWA =====================
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus');
    }
}
