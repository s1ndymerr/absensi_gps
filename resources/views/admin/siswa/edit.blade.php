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

        <div class="form-section">
            <div class="section-header">
                <div class="icon-box icon-indigo">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h3>Informasi Pribadi</h3>
                    <p>Identitas dasar siswa (Isi yang ingin diubah saja)</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="name" class="modern-input {{ $errors->has('name') ? 'input-error' : '' }}" value="{{ old('name', $siswa->name) }}" placeholder="Masukkan nama lengkap">
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>NIS <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="nis" class="modern-input {{ $errors->has('nis') ? 'input-error' : '' }}" value="{{ old('nis', $siswa->siswa->nis ?? '') }}" placeholder="Nomor Induk Siswa">
                        <i class="fas fa-id-badge input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>NISN</label>
                    <div class="input-wrapper">
                        <input type="text" name="nisn" class="modern-input {{ $errors->has('nisn') ? 'input-error' : '' }}" value="{{ old('nisn', $siswa->siswa->nisn ?? '') }}" placeholder="Nomor Induk Siswa Nasional">
                        <i class="fas fa-address-card input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <div class="input-wrapper">
                        <input type="text" name="nomor_telepon" class="modern-input {{ $errors->has('nomor_telepon') ? 'input-error' : '' }}" value="{{ old('nomor_telepon', $siswa->siswa->nomor_telepon ?? '') }}" placeholder="08....">
                        <i class="fas fa-phone input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-wrapper">
                        <input type="date" name="tanggal_lahir" class="modern-input {{ $errors->has('tanggal_lahir') ? 'input-error' : '' }}" value="{{ old('tanggal_lahir', $siswa->siswa->tanggal_lahir ?? '') }}">
                        <i class="fas fa-calendar input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="input-wrapper">
                        <select name="jenis_kelamin" class="modern-input {{ $errors->has('jenis_kelamin') ? 'input-error' : '' }}">
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
                        <textarea name="alamat" class="modern-input {{ $errors->has('alamat') ? 'input-error' : '' }}" rows="3" placeholder="Tulis alamat domisili..." style="resize: vertical;">{{ old('alamat', $siswa->siswa->alamat ?? '') }}</textarea>
                        <i class="fas fa-map-marker-alt input-icon" style="top: 15px;"></i>
                    </div>
                </div>
            </div>
        </div>

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
                $fullKelas = $siswa->siswa->kelas ?? '';
                $kelasArray = explode(' ', $fullKelas);
                $tingkatValue = $kelasArray[0] ?? '';
                $jurusanValue = isset($kelasArray[1]) ? implode(' ', array_slice($kelasArray, 1)) : '';
            @endphp

            <div class="form-grid">
                <div class="form-group">
                    <label>Tingkat</label>
                    <div class="input-wrapper">
                        <select name="tingkat" class="modern-input">
                            <option value="">-- Pilih Tingkat --</option>
                            @foreach (['X','XI','XII'] as $t)
                                <option value="{{ $t }}" {{ old('tingkat', $tingkatValue) == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-layer-group input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jurusan & Kelas</label>
                    <div class="input-wrapper">
                        <select name="jurusan_kelas" class="modern-input">
                            <option value="">-- Pilih Jurusan --</option>
                            @php $jurusans = ['RPL','TKJ','TKR','AK','DPIB','MP','SK']; @endphp
                            @foreach ($jurusans as $j)
                                @for ($i = 1; $i <= 3; $i++)
                                    @php $val = $j.' '.$i; @endphp
                                    <option value="{{ $val }}" {{ old('jurusan_kelas', $jurusanValue) == $val ? 'selected' : '' }}>{{ $val }}</option>
                                @endfor
                            @endforeach
                        </select>
                        <i class="fas fa-school input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tahun Masuk</label>
                    <div class="input-wrapper">
                        <input type="number" name="tahun_masuk" class="modern-input {{ $errors->has('tahun_masuk') ? 'input-error' : '' }}" value="{{ old('tahun_masuk', $siswa->siswa->tahun_masuk ?? '') }}" placeholder="Contoh: 2023">
                        <i class="fas fa-calendar-alt input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Orang Tua/Wali</label>
                    <div class="input-wrapper">
                        <input type="text" name="nama_orang_tua" class="modern-input {{ $errors->has('nama_orang_tua') ? 'input-error' : '' }}" value="{{ old('nama_orang_tua', $siswa->siswa->nama_orang_tua ?? '') }}" placeholder="Nama orang tua atau wali">
                        <i class="fas fa-users input-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-header">
                <div class="icon-box icon-green">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <h3>Keamanan Akun</h3>
                    <p>Email dan kata sandi untuk login</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="email" name="email" class="modern-input {{ $errors->has('email') ? 'input-error' : '' }}" value="{{ old('email', $siswa->email) }}" placeholder="nama@email.com">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" class="modern-input {{ $errors->has('password') ? 'input-error' : '' }}" placeholder="Kosongkan jika tidak diubah">
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" onclick="togglePass('password')" class="toggle-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="text-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Isi hanya jika ingin mengganti password.</span>
                    </div>
                </div>

                <div class="form-group" id="passwordConfirmationGroup" style="display: none;">
                    <label>Konfirmasi Password Baru</label>
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="modern-input" placeholder="Ulangi password baru">
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
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<style>
    /* ... (Gunakan CSS dari kodingan awal kamu) ... */
</style>

<script>
    // Logic: Toggle Password Visibility
    function togglePass(id) {
        const input = document.getElementById(id);
        const icon = event.currentTarget.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }

    // Logic: Munculkan konfirmasi password HANYA jika password diisi
    document.getElementById('password').addEventListener('input', function() {
        const confirmGroup = document.getElementById('passwordConfirmationGroup');
        confirmGroup.style.display = this.value.length > 0 ? 'block' : 'none';
    });

    // Progress Circle Logic (Disederhanakan)
    function updateProgress() {
        const inputs = document.querySelectorAll('.modern-input');
        let filled = 0;
        inputs.forEach(input => {
            if(input.value && input.value !== "") filled++;
        });
        const percent = Math.round((filled / inputs.length) * 100);
        document.querySelector('.progress-ring').setAttribute('stroke-dasharray', `${percent}, 100`);
        document.querySelector('.progress-value').textContent = `${percent}%`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateProgress();
        document.querySelectorAll('.modern-input').forEach(el => el.addEventListener('input', updateProgress));
    });
</script>
@endsection