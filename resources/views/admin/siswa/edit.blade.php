@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="edit-siswa-wrapper">
    
    <!-- Header -->
    <div class="hero-header">
        <div class="hero-content">
            <div class="hero-tag">
                <i class="fas fa-user-edit"></i> Manajemen Siswa
            </div>
            <h1>Edit Data Siswa</h1>
            <p>Perbarui data untuk: <strong>{{ $siswa->name }}</strong></p>
        </div>
    </div>

    <!-- Error -->
    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" id="siswaForm">
        @csrf
        @method('PUT')

        <!-- INFORMASI USER -->
        <div class="form-section">
            <h3>Informasi Akun</h3>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', $siswa->name) }}">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $siswa->email) }}">
            </div>

            <div class="form-group">
                <label>Status Akun</label>
                <select name="status_akun">
                    <option value="aktif" {{ old('status_akun', $siswa->status_akun) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status_akun', $siswa->status_akun) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <div class="form-group">
                <label>Password (opsional)</label>
                <input type="password" name="password">
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation">
            </div>
        </div>

        <!-- INFORMASI SISWA -->
        <div class="form-section">
            <h3>Data Siswa</h3>

            @php
                $kelas = explode(' ', $siswa->siswa->kelas ?? '');
                $tingkat = $kelas[0] ?? '';
                $jurusan_kelas = ($kelas[1] ?? '').' '.($kelas[2] ?? '');
            @endphp

            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="nis" value="{{ old('nis', $siswa->siswa->nis ?? '') }}">
            </div>

            <div class="form-group">
                <label>NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn', $siswa->siswa->nisn ?? '') }}">
            </div>

            <div class="form-group">
                <label>Tingkat</label>
                <select name="tingkat">
                    @foreach(['X','XI','XII'] as $t)
                        <option value="{{ $t }}" {{ $tingkat == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Jurusan & Kelas</label>
                <select name="jurusan_kelas">
                    @php
                        $jurusan = ['RPL','TKJ','TKR','AK','DPIB','MP','SK'];
                    @endphp

                    @foreach ($jurusan as $j)
                        @for ($i = 1; $i <= 3; $i++)
                            @php $val = $j.' '.$i; @endphp
                            <option value="{{ $val }}" {{ $jurusan_kelas == $val ? 'selected' : '' }}>
                                {{ $val }}
                            </option>
                        @endfor
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>No Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $siswa->siswa->nomor_telepon ?? '') }}">
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->siswa->tanggal_lahir ?? '') }}">
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin">
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->siswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $siswa->siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat">{{ old('alamat', $siswa->siswa->alamat ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label>Tahun Masuk</label>
                <input type="number" name="tahun_masuk" value="{{ old('tahun_masuk', $siswa->siswa->tahun_masuk ?? '') }}">
            </div>

            <div class="form-group">
                <label>Nama Orang Tua</label>
                <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua', $siswa->siswa->nama_orang_tua ?? '') }}">
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('admin.siswa.index') }}">Batal</a>
            <button type="submit" onclick="return confirm('Yakin update data?')">
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection