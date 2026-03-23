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
        ]);

        $statusAkun = $request->status_akun ?? 'nonaktif';

        DB::transaction(function () use ($validated, $statusAkun) {

            // ✅ simpan ke users
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status_akun' => $statusAkun,
                'role' => 'guru',
            ]);

            // ✅ simpan ke gurus
            Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'] ?? null,
            ]);
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = User::with('guru')->findOrFail($id);

        return view('admin.guru.edit', compact('guru'));
    }

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

            $user->guru->update([
                'nip' => $request->nip,
            ]);
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui');
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