<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminGuruController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('guru')->where('role', 'guru');

        if ($request->filled('nama')) {
            $query->where('name', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('status')) {
            $query->where('status_akun', $request->status);
        }

        $gurus = $query->latest()->paginate(10);

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

    public function create()
    {
        return view('admin.guru.create');
    }

public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'nip' => 'nullable|unique:gurus,nip',
            'kelas_pengampu' => 'nullable', // Tambahkan ini
            'jurusan' => 'nullable',        // Tambahkan ini
        ]);

        $statusAkun = $request->status_akun ?? 'nonaktif';

        DB::transaction(function () use ($validated, $statusAkun, $request) {
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
                'kelas_pengampu' => $request->kelas_pengampu, // Simpan kelas
                'jurusan' => $request->jurusan,               // Simpan jurusan
            ]);
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::with('guru')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'nip' => 'nullable|unique:gurus,nip,' . ($user->guru->id ?? 0), // Validasi unique kecuali punya dia sendiri
        ]);

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

            // Pakai updateOrCreate supaya anti-error kalau data di tabel gurus belum ada
            $user->guru()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $request->nip,
                    'kelas_pengampu' => $request->kelas_pengampu,
                    'jurusan' => $request->jurusan,
                ]
            );
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui');
    }

    public function edit($id)
    {
        $guru = User::with('guru')->findOrFail($id);

        return view('admin.guru.edit', compact('guru'));
    }

    public function destroy($id)
    {
        $user = User::with('guru')->findOrFail($id);

        DB::transaction(function () use ($user) {
            $user->guru->delete();
            $user->delete();
        });

        return back()->with('success', 'Data guru dihapus');
    }
}