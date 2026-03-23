@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="edit-siswa-wrapper">
    
    <div class="hero-header">
        <div class="hero-blob"></div>
        
        <div class="hero-content">
            <div class="hero-tag">
                <i class="fas fa-user-edit"></i> Manajemen Siswa
            </div>
            <h1>Edit Data Siswa</h1>
            <p>Perbarui data untuk: <strong>{{ $siswa->name }}</strong></p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <div class="error-icon-box">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="error-content">
                <h4>Mohon perbaiki kesalahan berikut:</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" id="siswaForm" class="main-form-card">
        @csrf
        @method('PUT')

        <!-- INFORMASI PRIBADI -->
        <div class="form-section">
            <div class="section-header">
                <div class="icon-box icon-indigo">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h3>Informasi Pribadi</h3>
                    <p>Identitas dasar siswa</p>
                </div>
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="name" class="modern-input {{ $errors->has('name') ? 'input-error' : '' }}" value="{{ old('name', $siswa->name) }}" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>NIS <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="nis" class="modern-input {{ $errors->has('nis') ? 'input-error' : '' }}" value="{{ old('nis', $siswa->siswa->nis ?? '') }}" required>
                        <i class="fas fa-id-badge input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>NISN</label>
                    <div class="input-wrapper">
                        <input type="text" name="nisn" class="modern-input" value="{{ old('nisn', $siswa->siswa->nisn ?? '') }}">
                        <i class="fas fa-address-card input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <div class="input-wrapper">
                        <input type="text" name="nomor_telepon" class="modern-input" value="{{ old('nomor_telepon', $siswa->siswa->nomor_telepon ?? '') }}">
                        <i class="fas fa-phone input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-wrapper">
                        <input type="date" name="tanggal_lahir" class="modern-input" value="{{ old('tanggal_lahir', $siswa->siswa->tanggal_lahir ?? '') }}">
                        <i class="fas fa-calendar input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select name="jenis_kelamin" class="modern-input">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->siswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <i class="fas fa-venus-mars input-icon"></i>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Alamat Lengkap</label>
                    <div class="input-wrapper">
                        <textarea name="alamat" class="modern-input">{{ old('alamat', $siswa->siswa->alamat ?? '') }}</textarea>
                        <i class="fas fa-map-marker-alt input-icon"></i>
                    </div>
                </div>

            </div>
        </div>

        <!-- AKADEMIK -->
        <div class="form-section">

            <div class="section-header">
                <div class="icon-box icon-orange">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h3>Informasi Akademik</h3>
                    <p>Kelas dan tahun ajaran</p>
                </div>
            </div>

            @php
                $kelas = explode(' ', $siswa->siswa->kelas ?? '');
                $tingkat = $kelas[0] ?? '';
                $jurusan_kelas = ($kelas[1] ?? '').' '.($kelas[2] ?? '');
            @endphp

            <div class="form-grid">

                <div class="form-group">
                    <label>Tingkat <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select name="tingkat" class="modern-input">
                            @foreach (['X','XI','XII'] as $t)
                                <option value="{{ $t }}" {{ $tingkat == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-layer-group input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jurusan & Kelas <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select name="jurusan_kelas" class="modern-input">
                            @php $jurusan = ['RPL','TKJ','TKR','AK','DPIB','MP','SK']; @endphp
                            @foreach ($jurusan as $j)
                                @for ($i = 1; $i <= 3; $i++)
                                    @php $val = $j.' '.$i; @endphp
                                    <option value="{{ $val }}" {{ $jurusan_kelas == $val ? 'selected' : '' }}>
                                        {{ $val }}
                                    </option>
                                @endfor
                            @endforeach
                        </select>
                        <i class="fas fa-school input-icon"></i>
                    </div>
                </div>

            </div>
        </div>

        <!-- AKUN -->
        <div class="form-section">

            <div class="section-header">
                <div class="icon-box icon-green">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <h3>Keamanan Akun</h3>
                </div>
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="email" name="email" class="modern-input" value="{{ old('email', $siswa->email) }}" required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" class="modern-input">
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status Akun</label>
                    <div class="input-wrapper">
                        <select name="status_akun" class="modern-input">
                            <option value="aktif" {{ old('status_akun', $siswa->status_akun) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status_akun', $siswa->status_akun) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        <i class="fas fa-toggle-on input-icon"></i>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin update data?')">
                <i class="fas fa-save"></i> Perbarui Data
            </button>
        </div>

    </form>
</div>
@endsection