<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSiswaController extends Controller
{
    public function index()
    {
        $siswas = User::with('siswa')
            ->where('role', 'siswa')
            ->latest()
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

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'status_akun' => 'required|in:aktif,tidak_aktif',
            'nis' => 'required|unique:siswas,nis',
            'tingkat' => 'required',
            'jurusan_kelas' => 'required',
        ]);

        $kelas = trim($validated['tingkat'].' '.$validated['jurusan_kelas']);

        DB::transaction(function () use ($validated, $kelas) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'siswa',
                'status_akun' => $validated['status_akun'],
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $validated['nis'],
                'kelas' => $kelas,
                'jurusan' => $validated['jurusan_kelas'],

                // optional fields
                'nisn' => request('nisn'),
                'nomor_telepon' => request('nomor_telepon'),
                'tanggal_lahir' => request('tanggal_lahir'),
                'jenis_kelamin' => request('jenis_kelamin'),
                'alamat' => request('alamat'),
                'tahun_masuk' => request('tahun_masuk'),
                'nama_orang_tua' => request('nama_orang_tua'),
            ]);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $siswa = User::with('siswa')->findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

public function update(Request $request, $id)
{
    $user = User::with('siswa')->findOrFail($id);

    $validated = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:8',
        'status_akun' => 'sometimes|required',
        
        // Field Siswa dibuat nullable semua agar tidak dipaksa isi ulang
        'nis' => 'sometimes|required|unique:siswas,nis,' . $user->siswa->id,
        'nisn' => 'nullable',
        'tingkat' => 'nullable',
        'jurusan_kelas' => 'nullable',
        'nomor_telepon' => 'nullable',
        'tanggal_lahir' => 'nullable',
        'alamat' => 'nullable',
        'tahun_masuk' => 'nullable',
        'nama_orang_tua' => 'nullable',
        'jenis_kelamin' => 'nullable',
    ]);

    DB::transaction(function () use ($user, $request, $validated) {
        // 1. Update User (Hanya yang diisi di form)
        $user->update(array_filter([
            'name' => $request->name,
            'email' => $request->email,
            'status_akun' => $request->status_akun,
            'password' => $request->filled('password') ? Hash::make($request->password) : null,
        ]));

        // 2. Logika Gabungan Kelas (Tingkat + Jurusan)
        // Kita cek: kalau salah satu diisi, kita update. Kalau dua-duanya kosong, pakai yang lama.
        $tingkat = $request->tingkat ?? explode(' ', $user->siswa->kelas)[0];
        $jurusan = $request->jurusan_kelas ?? $user->siswa->jurusan;
        $kelasBaru = trim($tingkat . ' ' . $jurusan);

        // 3. Update Tabel Siswa
        // array_filter akan membuang input yang null, sehingga data lama di DB tetap aman
        $user->siswa->update(array_filter([
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'kelas' => $kelasBaru,
            'jurusan' => $jurusan,
            'nomor_telepon' => $request->nomor_telepon,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'tahun_masuk' => $request->tahun_masuk,
            'nama_orang_tua' => $request->nama_orang_tua,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]));
    });

    return redirect()->route('admin.siswa.index')->with('success', 'Data berhasil diupdate!');
}

    public function destroy($id)
    {
        $user = User::with('siswa')->findOrFail($id);

        DB::transaction(function () use ($user) {
            $user->siswa->delete();
            $user->delete();
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus');
    }
}