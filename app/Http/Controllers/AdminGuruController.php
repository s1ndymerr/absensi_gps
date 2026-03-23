<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminGuruController extends Controller
{
    // Tampilkan daftar guru
    public function index(Request $request)
    {
        $query = User::with('guru')->where('role', 'guru');

        if ($request->filled('nama')) {
            $query->where('name', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('status')) {
            $query->where('status_akun', $request->status);
        }

        $gurus = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalGuru = User::where('role', 'guru')->count();

        $jumlahGuruAktif = User::where('role', 'guru')
            ->where('status_akun', 'aktif')
            ->count();

        $guruBaru = User::where('role', 'guru')
            ->whereDate('created_at', today())
            ->count();

        return view('admin.guru.index', compact(
            'gurus',
            'totalGuru',
            'jumlahGuruAktif',
            'guruBaru'
        ));
    }

    // Form tambah guru
    public function create()
    {
        return view('admin.guru.create');
    }

    // Simpan guru baru (🔥 SUDAH RELASI)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'nip' => 'nullable|unique:gurus,nip',
        ]);

        $statusAkun = $request->input('status_akun') === 'aktif' ? 'aktif' : 'tidak_aktif';

        DB::transaction(function () use ($validated, $statusAkun) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status_akun' => $statusAkun,
                'role' => 'guru',
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'] ?? null,
            ]);
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan');
    }

    // Form edit guru
    public function edit($id)
    {
        $guru = User::with('guru')->where('role', 'guru')->findOrFail($id);

        $totalGuru = User::where('role', 'guru')->count();
        $jumlahGuruAktif = User::where('role', 'guru')
            ->where('status_akun', 'aktif')
            ->count();
        $guruBaru = User::where('role', 'guru')
            ->whereDate('created_at', today())
            ->count();

        return view('admin.guru.edit', compact(
            'guru',
            'totalGuru',
            'jumlahGuruAktif',
            'guruBaru'
        ));
    }

    // Update guru (🔥 SUDAH RELASI)
    public function update(Request $request, $id)
    {
        $user = User::with('guru')->findOrFail($id);

        DB::transaction(function () use ($request, $user) {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'status_akun' => $request->status_akun,
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            if ($user->guru) {
                $user->guru->update([
                    'nip' => $request->nip,
                ]);
            }
        });

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui');
    }

    // Hapus guru
    public function destroy($id)
    {
        $user = User::with('guru')->where('role', 'guru')->findOrFail($id);

        DB::transaction(function () use ($user) {
            if ($user->guru) {
                $user->guru->delete();
            }
            $user->delete();
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}