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
                <!-- Nama -->
                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="name" class="modern-input {{ $errors->has('name') ? 'input-error' : '' }}" value="{{ old('name', $siswa->name) }}" placeholder="Masukkan nama lengkap" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <!-- NIS -->
                <div class="form-group">
                    <label>NIS <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="nis" class="modern-input {{ $errors->has('nis') ? 'input-error' : '' }}" value="{{ old('nis', $siswa->nis) }}" placeholder="Nomor Induk Siswa" required>
                        <i class="fas fa-id-badge input-icon"></i>
                    </div>
                </div>

                <!-- NISN -->
                <div class="form-group">
                    <label>NISN</label>
                    <div class="input-wrapper">
                        <input type="text" name="nisn" class="modern-input {{ $errors->has('nisn') ? 'input-error' : '' }}" value="{{ old('nisn', $siswa->nisn) }}" placeholder="Nomor Induk Siswa Nasional">
                        <i class="fas fa-address-card input-icon"></i>
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <div class="input-wrapper">
                        <input type="text" name="nomor_telepon" class="modern-input {{ $errors->has('nomor_telepon') ? 'input-error' : '' }}" value="{{ old('nomor_telepon', $siswa->nomor_telepon) }}" placeholder="08....">
                        <i class="fas fa-phone input-icon"></i>
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-wrapper">
                        <input type="date" name="tanggal_lahir" class="modern-input {{ $errors->has('tanggal_lahir') ? 'input-error' : '' }}" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                        <i class="fas fa-calendar input-icon"></i>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
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

                <!-- Alamat -->
                <div class="form-group full-width">
                    <label>Alamat Lengkap</label>
                    <div class="input-wrapper">
                        <textarea name="alamat" class="modern-input {{ $errors->has('alamat') ? 'input-error' : '' }}" rows="3" placeholder="Tulis alamat domisili..." style="resize: vertical;">{{ old('alamat', $siswa->alamat) }}</textarea>
                        <i class="fas fa-map-marker-alt input-icon" style="top: 15px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Informasi Akademik -->
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

            <!-- Logic PHP untuk Kelas -->
            @php
                if (isset($siswa)) {
                    $kelas = explode(' ', $siswa->kelas);
                    $tingkat = $kelas[0] ?? '';
                    $jurusan_kelas = ($kelas[1] ?? '').' '.($kelas[2] ?? '');
                } else {
                    $tingkat = '';
                    $jurusan_kelas = '';
                }
            @endphp

            <div class="form-grid">
                <!-- Tingkat -->
                <div class="form-group">
                    <label>Tingkat <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select name="tingkat" class="modern-input" required>
                            @foreach (['X','XI','XII'] as $t)
                                <option value="{{ $t }}" {{ $tingkat == $t ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-layer-group input-icon"></i>
                    </div>
                </div>

                <!-- Jurusan & Kelas -->
                <div class="form-group">
                    <label>Jurusan & Kelas <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select name="jurusan_kelas" class="modern-input" required>
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
                        <i class="fas fa-school input-icon"></i>
                    </div>
                </div>

                <!-- Tahun Masuk -->
                <div class="form-group">
                    <label>Tahun Masuk <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="number" name="tahun_masuk" class="modern-input {{ $errors->has('tahun_masuk') ? 'input-error' : '' }}" value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}" placeholder="Contoh: 2023" required>
                        <i class="fas fa-calendar-alt input-icon"></i>
                    </div>
                </div>

                <!-- Nama Orang Tua -->
                <div class="form-group">
                    <label>Nama Orang Tua/Wali</label>
                    <div class="input-wrapper">
                        <input type="text" name="nama_orang_tua" class="modern-input {{ $errors->has('nama_orang_tua') ? 'input-error' : '' }}" value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}" placeholder="Nama orang tua atau wali">
                        <i class="fas fa-users input-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Keamanan Akun -->
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
                <!-- Email -->
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="email" name="email" class="modern-input {{ $errors->has('email') ? 'input-error' : '' }}" value="{{ old('email', $siswa->email) }}" placeholder="nama@email.com" required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" class="modern-input {{ $errors->has('password') ? 'input-error' : '' }}" placeholder="Kosongkan jika tidak ingin diubah">
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" onclick="togglePass('password')" class="toggle-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <!-- Hint Text -->
                    <div class="text-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Kosongkan jika tidak ingin mengubah password saat ini.</span>
                    </div>

                    <!-- Strength Meter -->
                    <div id="passwordStrengthContainer" class="strength-box">
                        <div class="strength-track">
                            <div id="strengthBar" class="strength-fill"></div>
                        </div>
                        <p id="strengthText" class="strength-text">Kekuatan Password</p>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group" id="passwordConfirmationGroup" style="display: none;">
                    <label>Konfirmasi Password <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="modern-input {{ $errors->has('password_confirmation') ? 'input-error' : '' }}" placeholder="Ulangi password" required>
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" onclick="togglePass('password_confirmation')" class="toggle-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Status Akun (Select Style) -->
                <div class="form-group">
                    <label>Status Akun</label>
                    <div class="input-wrapper">
                        <select name="status_akun" class="modern-input {{ $errors->has('status_akun') ? 'input-error' : '' }}">
                            <option value="aktif" {{ old('status_akun', $siswa->status_akun) == 'aktif' ? 'selected' : '' }}">Aktif</option>
                            <option value="tidak_aktif" {{ old('status_akun', $siswa->status_akun) == 'tidak_aktif' ? 'selected' : '' }}">Tidak Aktif</option>
                        </select>
                        <i class="fas fa-toggle-on input-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
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

<style>
    /* --- CSS Global Variables & Reset --- */
    :root {
        --primary: #6366f1;
        --primary-hover: #4f46e5;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border: #e2e8f0;
        --radius: 12px;
        --radius-sm: 8px;
    }

    .edit-siswa-wrapper {
        max-width: 900px;
        margin: 0 auto;
        font-family: 'Inter', sans-serif;
    }

    /* --- Header --- */
    .hero-header {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .hero-blob {
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .hero-content {
        z-index: 1;
    }

    .hero-tag {
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 8px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .hero-content h1 {
        margin: 0 0 5px 0;
        font-size: 1.8rem;
        font-weight: 800;
    }

    .hero-content p {
        margin: 0;
        font-size: 0.95rem;
        opacity: 0.9;
        max-width: 500px;
        line-height: 1.5;
    }

    /* --- Progress Indicator --- */
    .progress-indicator {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 15px;
        border-radius: 16px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.3);
        z-index: 1;
    }

    .progress-wrapper {
        position: relative;
        width: 60px;
        height: 60px;
        margin: 0 auto;
    }

    .progress-svg {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .progress-value {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 700;
        font-size: 0.9rem;
    }

    .progress-indicator p {
        margin: 8px 0 0 0;
        font-size: 0.75rem;
        font-weight: 600;
        opacity: 0.9;
    }

    /* --- Alert --- */
    .alert-error {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .error-icon-box {
        background: #fecaca;
        color: #dc2626;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .error-content h4 {
        margin: 0 0 5px 0;
        font-size: 0.95rem;
        font-weight: 700;
    }

    /* --- Main Card & Toolbar --- */
    .main-form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 0;
        overflow: hidden;
        border: 1px solid #f1f5f9;
    }

    .form-section {
        padding: 30px;
        border-bottom: 1px solid #f8fafc;
    }

    .section-header {
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .icon-box {
        width: 40px;
        height: 40px;
        background: #e0e7ff;
        color: #6366f1;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .icon-indigo { background: rgba(99, 102, 241, 0.1); color: #6366f1; }
    .icon-orange { background: #ffedd5; color: #f97316; }
    .icon-green { background: #dcfce7; color: #10b981; }

    .section-header h3 {
        margin: 0;
        font-size: 1.1rem;
        color: #1e293b;
        font-weight: 700;
    }

    .section-header p {
        margin: 0;
        font-size: 0.85rem;
        color: #64748b;
    }

    /* --- Grid & Inputs --- */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }

    .required { color: #ef4444; }

    .input-wrapper {
        position: relative;
    }

    .modern-input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: #334155;
        background: #ffffff;
        border: 2px solid var(--border);
        border-radius: 10px;
        transition: all 0.3s ease;
        appearance: none;
    }

    .modern-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        background: #fff;
    }

    .modern-input.input-error {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
    
    .modern-input.input-error:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1rem;
        transition: color 0.3s;
        pointer-events: none;
    }

    .modern-input:focus ~ .input-icon {
        color: var(--primary);
    }

    /* Toggle Password Button */
    .toggle-btn {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        font-size: 1rem;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .toggle-btn:hover {
        color: var(--primary);
        background: #f1f5f9;
    }

    /* --- UI Components --- */
    .text-hint {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .strength-box {
        margin-top: 8px;
        display: none;
    }

    .strength-track {
        height: 4px;
        background: #f1f5f9;
        border-radius: 2px;
        overflow: hidden;
    }

    .strength-fill {
        height: 100%;
        width: 0;
        transition: width 0.3s ease, background 0.3s ease;
    }

    .strength-text {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* --- Buttons --- */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 24px;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        font-family: 'Inter', sans-serif;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #a855f7);
        color: white;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(99, 102, 241, 0.35);
    }

    .btn-secondary {
        background: white;
        color: var(--text-main);
        border: 1px solid var(--border);
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* --- Footer --- */
    .form-footer {
        padding: 24px 30px;
        background: white;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    /* =========================================
       ANDROID MOBILE APP OPTIMIZATION
       ========================================= */
    @media (max-width: 768px) {
        
        /* 1. General Container */
        body {
            -webkit-tap-highlight-color: transparent;
            background-color: #f8fafc;
            font-size: 14px;
        }

        .edit-siswa-wrapper {
            padding: 10px;
            margin: 0;
            max-width: 100%;
        }

        /* 2. Header Section */
        .hero-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 24px 20px;
            margin-bottom: 12px;
            border-radius: 0 0 20px 20px;
        }

        .hero-blob { display: none; }

        .hero-content h1 { font-size: 1.5rem; }

        /* Progress Inline */
        .progress-indicator {
            position: static;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 12px;
            padding: 10px 16px;
        }
        .progress-wrapper { width: 36px; height: 36px; margin: 0; }
        .progress-value { font-size: 0.75rem; }

        /* 3. Main Form Card */
        .main-form-card {
            margin: 0 10px 80px 10px;
            border-radius: 12px;
        }

        /* 4. Form Sections */
        .form-section {
            padding: 20px 16px;
        }

        .section-header {
            margin-bottom: 12px;
            gap: 10px;
        }

        .section-header h3 { font-size: 0.95rem; }
        .icon-box { width: 32px; height: 32px; font-size: 0.9rem; }

        /* 5. Grid System (Force Stacking) */
        .form-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* 6. Inputs (Touch Optimized) */
        .form-group.full-width { display: block; }

        .modern-input {
            padding: 12px 12px 12px 42px;
            height: 48px;
            font-size: 16px;
            border-radius: 10px;
        }

        .input-icon { left: 12px; top: 50%; font-size: 1rem; }
        .toggle-btn { right: 10px; padding: 8px; }

        /* 7. Buttons (Full Width Stacked) */
        .form-footer {
            flex-direction: column;
            padding: 16px;
            gap: 10px;
        }

        .btn { width: 100%; padding: 14px; }

    }
</style>

<script>
    // Toggle Password
    function togglePass(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.nextElementSibling.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Logic: Show/hide confirmation & strength based on password input
    document.getElementById('password').addEventListener('input', function() {
        const val = this.value;
        const confirmGroup = document.getElementById('passwordConfirmationGroup');
        const strengthContainer = document.getElementById('passwordStrengthContainer');
        
        if (val.length > 0) {
            confirmGroup.style.display = 'block';
            strengthContainer.style.display = 'block';
            checkPasswordStrength(val);
        } else {
            confirmGroup.style.display = 'none';
            strengthContainer.style.display = 'none';
        }
        
        updateProgress();
    });

    // Password Strength Logic
    function checkPasswordStrength(password) {
        const bar = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');
        
        let strength = 0;
        if(password.length > 0) strength += 10;
        if(password.length > 7) strength += 20;
        if(/[A-Z]/.test(password)) strength += 20;
        if(/[0-9]/.test(password)) strength += 20;
        if(/[^A-Za-z0-9]/.test(password)) strength += 30;

        bar.style.width = strength + '%';
        
        if (strength <= 30) {
            bar.style.background = '#ef4444'; text.style.color = '#ef4444'; text.textContent = 'Lemah';
        } else if (strength <= 60) {
            bar.style.background = '#f59e0b'; text.style.color = '#f59e0b'; text.textContent = 'Sedang';
        } else if (strength <= 80) {
            bar.style.background = '#3b82f6'; text.style.color = '#3b82f6'; text.textContent = 'Kuat';
        } else {
            bar.style.background = '#10b981'; text.style.color = '#10b981'; text.textContent = 'Sangat Kuat';
        }
    }

    // Confirmation Dialog
    function confirmUpdate() {
        return confirm('Apakah Anda yakin ingin menyimpan perubahan data siswa ini?');
    }

    // Progress Circle Logic
    function updateProgress() {
        const form = document.getElementById('siswaForm');
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        let filled = 0;
        inputs.forEach(input => { if(input.value.trim() !== '') filled++; });
        
        const percent = Math.round((filled / inputs.length) * 100);
        
        // Update SVG Stroke Dasharray
        // 100 is circumference approx, 0 is starting dash
        document.querySelector('.progress-ring').setAttribute('stroke-dasharray', `${percent}, 100`);
        document.querySelector('.progress-value').textContent = `${percent}%`;
        
        // Update Circle Color based on completion
        const ring = document.querySelector('.progress-ring');
        if(percent === 100) ring.style.stroke = '#10b981'; // Green
        else ring.style.stroke = '#ffffff';
    }

    // Init
    document.addEventListener('DOMContentLoaded', () => {
        updateProgress();
        document.querySelectorAll('input, select, textarea').forEach(el => el.addEventListener('input', updateProgress));
    });
</script>
@endsection