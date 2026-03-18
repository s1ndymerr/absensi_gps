<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;

class LokasiController extends Controller
{
    public function index()
{
    $lokasis = Lokasi::all();

    return view('admin.lokasi.index', compact('lokasis'));
}


    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        Lokasi::create($request->all());

        return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $request->validate([
            'nama_lokasi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $lokasi->update($request->all());

        return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi berhasil dihapus');
    }
     // ===============================
    // AKTIFKAN LOKASI SEKOLAH
    // ===============================
    public function setAktif($id)
    {
        // Matikan semua lokasi
        Lokasi::query()->update([
            'status' => 'nonaktif'
        ]);

        // Aktifkan lokasi yang dipilih
        Lokasi::where('id', $id)->update([
            'status' => 'aktif'
        ]);

        return redirect()->back()->with('success', 'Lokasi absensi berhasil diaktifkan');
    }
}
