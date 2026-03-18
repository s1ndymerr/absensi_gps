<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminGuruController extends Controller
{
    // Tampilkan daftar guru
   public function index(Request $request)
{
    $query = User::where('role', 'guru');

    // Filter berdasarkan nama
    if ($request->filled('nama')) {
        $query->where('name', 'like', '%' . $request->nama . '%');
    }

    // Filter berdasarkan status akun (PAKAI status_akun, BUKAN status)
    if ($request->filled('status')) {
        $query->where('status_akun', $request->status);
    }

    // Data tabel (pakai paginate biar rapi)
    $gurus = $query->orderBy('created_at', 'desc')->paginate(10);

    // Hitungan card
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

    // Simpan guru baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'nip' => 'nullable|unique:users,nip',
            'kelas' => 'nullable|string',
    'jurusan' => 'nullable|string',
        ]);

        // Tangani status akun checkbox
        $statusAkun = $request->input('status_akun') === 'aktif' ? 'aktif' : 'tidak_aktif';

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status_akun' => $statusAkun,
            'role' => 'guru',
            'nip' => $validated['nip'] ?? null,
            'kelas' => $validated['kelas'],
            'jurusan' => $validated['jurusan'],

        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan');
    }

    // Form edit guru
  public function edit($id)
{
    $guru = User::where('role', 'guru')->findOrFail($id);

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


    // Update guru
 public function update(Request $request, $id)
{
    $guru = User::findOrFail($id);

    $data = [
        'name'   => $request->name,
        'email'  => $request->email,
        'nip'    => $request->nip,
        'kelas'  => $request->kelas,
        'jurusan'=> $request->jurusan,

        // ✅ FIX PALING BENAR
       'status_akun' => $request->status_akun,
    ];

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }
 $guru->status_akun = $request->status_akun; // ⬅️ WAJIB
    $guru->update($data);

    return redirect()
        ->route('admin.guru.index')
        ->with('success', 'Data guru berhasil diperbarui');
}




    // Hapus guru
    public function destroy($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
