@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="edit-siswa-wrapper">
    
    <!-- Header Section Glassmorphism -->
    <div class="hero-header">
        <div class="hero-blob"></div>
        
        <div class="hero-content">
            <div class="hero-tag">
                <i class="fas fa-user-edit"></i> Manajemen Siswa
            </div>
            <h1>Edit Data Siswa</h1>
            <p>Perbarui data untuk: <strong>{{ $siswa->nama }}</strong></p>
        </div>

        <!-- Progress Indicator -->
        <div class="progress-indicator">
            <div class="progress-wrapper">
                <svg class="progress-svg" viewBox="0 0 36 36">
                    <path class="progress-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="3" />
                    <path class="progress-ring" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#ffffff" stroke-width="3" />
                </svg>
                <div class="progress-value">0%</div>
            </div>
            <p>Kelengkapan Data</p>
        </div>
    </div>

    <!-- Error Summary -->
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

    <!-- Main Form Card -->
    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" id="siswaForm" class="main-form-card">
        @csrf
        @method('PUT')

        <!-- Section 1: Informasi Pribadi -->
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
                        <input type="text" name="name" class="modern-input {{ $errors->has('name') ? 'input-error' : '' }}" value="{{ old('name', $siswa->name) }}" placeholder="Masukkan nama lengkap" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>NIS <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="nis" class="modern-input {{ $errors->has('nis') ? 'input-error' : '' }}" value="{{ old('nis', $siswa->nis) }}" placeholder="Nomor Induk Siswa" required>
                        <i class="fas fa-id-badge input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>NISN</label>
                    <div class="input-wrapper">
                        <input type="text" name="nisn" class="modern-input {{ $errors->has('nisn') ? 'input-error' : '' }}" value="{{ old('nisn', $siswa->nisn) }}" placeholder="Nomor Induk Siswa Nasional">
                        <i class="fas fa-address-card input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <div class="input-wrapper">
                        <input type="text" name="nomor_telepon" class="modern-input {{ $errors->has('nomor_telepon') ? 'input-error' : '' }}" value="{{ old('nomor_telepon', $siswa->nomor_telepon) }}" placeholder="08....">
                        <i class="fas fa-phone input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-wrapper">
                        <input type="date" name="tanggal_lahir" class="modern-input {{ $errors->has('tanggal_lahir') ? 'input-error' : '' }}" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                        <i class="fas fa-calendar input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select name="jenis_kelamin" class="modern-input {{ $errors->has('jenis_kelamin') ? 'input-error' : '' }}" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <i class="fas fa-venus-mars input-icon"></i>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Alamat Lengkap</label>
                    <div class="input-wrapper">
                        <textarea name="alamat" class="modern-input {{ $errors->has('alamat') ? 'input-error' : '' }}" rows="3" style="resize: vertical;">{{ old('alamat', $siswa->alamat) }}</textarea>
                        <i class="fas fa-map-marker-alt input-icon" style="top: 15px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section lainnya tetap sama ... -->

        <!-- Keamanan Akun -->
        <div class="form-group">
            <label>Status Akun</label>
            <div class="input-wrapper">
                <select name="status_akun" class="modern-input {{ $errors->has('status_akun') ? 'input-error' : '' }}">
                    <option value="aktif" {{ old('status_akun', $siswa->status_akun) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status_akun', $siswa->status_akun) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <i class="fas fa-toggle-on input-icon"></i>
            </div>
        </div>

        <!-- Footer -->
        <div class="form-footer">
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary" onclick="return confirmUpdate()">
                <i class="fas fa-save"></i> Perbarui Data
            </button>
        </div>
    </form>
</div>
@endsection