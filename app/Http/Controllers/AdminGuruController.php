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
        // Mengambil data user role guru beserta relasi 'gurus'
        $gurus = User::with('guru')
        ->where('role', 'guru')
        ->latest()
        ->paginate(10);

        if ($request->filled('nama')) {
            $gurus->where('name', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('status')) {
            $gurus->where('status_akun', $request->status);
        }

        

        $totalGuru = User::where('role', 'guru')->count();
        $jumlahGuruAktif = User::where('role', 'guru')->where('status_akun', 'aktif')->count();
        $guruBaru = User::where('role', 'guru')->whereDate('created_at', today())->count();

        return view('admin.guru.index', compact('gurus', 'totalGuru', 'jumlahGuruAktif', 'guruBaru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'nip' => 'nullable|unique:gurus,nip',
            'kelas' => 'nullable', // ✅ Sudah ganti jadi 'kelas'
            'jurusan' => 'nullable',        
        ]);

        $statusAkun = $request->status_akun ?? 'tidak_aktif';

        DB::transaction(function () use ($validated, $statusAkun, $request) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status_akun' => $statusAkun,
                'role' => 'guru',
            ]);

            // Simpan ke tabel gurus
            Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'] ?? null,
                'kelas' => $request->kelas, // ✅ Sudah ganti jadi 'kelas'
                'jurusan' => $request->jurusan,
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::with('gurus')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'nip' => 'nullable|unique:gurus,nip,' . ($user->gurus->id ?? 0),
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

            // Update atau buat data di tabel gurus
            $user->gurus()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $request->nip,
                    'kelas' => $request->kelas, // ✅ Sudah ganti jadi 'kelas'
                    'jurusan' => $request->jurusan,
                ]
            );
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    // Fungsi create, edit, destroy tetap sama (pastikan pakai relasi 'gurus')
    public function create() { return view('admin.guru.create'); }
    public function edit($id) { 
        $guru = User::with('gurus')->findOrFail($id);
        return view('admin.guru.edit', compact('guru')); 
    }
    public function destroy($id) {
        $user = User::with('gurus')->findOrFail($id);
        DB::transaction(function () use ($user) {
            if ($user->gurus) { $user->gurus->delete(); }
            $user->delete();
        });
        return back()->with('success', 'Data guru dihapus');
    }
}