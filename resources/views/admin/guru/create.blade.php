@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto; font-family: 'Inter', sans-serif;">
    
    <!-- Header Section dengan Efek Glassmorphism -->
    <div style="
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
    ">
        <!-- Background Decoration -->
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
        
        <div style="z-index: 1;">
            <div style="font-size: 0.85rem; font-weight: 700; letter-spacing: 1px; opacity: 0.9; margin-bottom: 8px; text-transform: uppercase;">
                <i class="fas fa-user-shield"></i> Form Admin
            </div>
            <h1 style="margin: 0 0 5px 0; font-size: 1.8rem; font-weight: 800;">Tambah Guru Baru</h1>
            <p style="margin: 0; font-size: 0.95rem; opacity: 0.9; max-width: 500px; line-height: 1.5;">
                Lengkapi formulir di bawah ini untuk mendaftarkan guru ke sistem E-Absensi.
            </p>
        </div>

        <!-- Progress Indicator -->
        <div style="
            background: rgba(255, 255, 255, 0.2); 
            backdrop-filter: blur(10px); 
            padding: 15px; 
            border-radius: 16px; 
            text-align: center; 
            border: 1px solid rgba(255,255,255,0.3);
            z-index: 1;
        ">
            <div class="progress-wrapper" style="position: relative; width: 60px; height: 60px; margin: 0 auto;">
                <svg style="width: 100%; height: 100%; transform: rotate(-90deg);" viewBox="0 0 36 36">
                    <path class="progress-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="3" />
                    <path class="progress-ring" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#ffffff" stroke-width="3" />
                </svg>
                <div class="progress-value" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: 700; font-size: 0.9rem;">0%</div>
            </div>
            <p style="margin: 8px 0 0 0; font-size: 0.75rem; font-weight: 600; opacity: 0.9;">Kelengkapan Data</p>
        </div>
    </div>

    <!-- Error Summary -->
    @if ($errors->any())
        <div style="background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 16px 20px; border-radius: 12px; margin-bottom: 25px; display: flex; align-items: flex-start; gap: 15px;">
            <div style="background: #fecaca; color: #dc2626; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <h4 style="margin: 0 0 5px 0; font-size: 0.95rem; font-weight: 700;">Mohon perbaiki kesalahan berikut:</h4>
                <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Form Card -->
    <form action="{{ route('admin.guru.store') }}" method="POST" id="teacherForm" style="
        background: white; 
        border-radius: 16px; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        border: 1px solid #f1f5f9;
    ">
        @csrf

        <!-- Section 1: Data Diri -->
        <div style="padding: 30px; border-bottom: 1px solid #f8fafc;">
            <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #e0e7ff; color: #6366f1; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b; font-weight: 700;">Informasi Pribadi</h3>
                    <p style="margin: 0; font-size: 0.85rem; color: #64748b;">Identitas dasar guru</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
                <!-- Nama -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative;">
                        <input type="text" name="name" class="modern-input {{ $errors->has('name') ? 'input-error' : '' }}" placeholder="Masukkan Nama Lengkap" value="{{ old('name') }}" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <!-- NIP -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">NIP</label>
                    <div style="position: relative;">
                        <input type="text" name="nip" class="modern-input {{ $errors->has('nip') ? 'input-error' : '' }}" placeholder="Nomor Induk Pegawai" value="{{ old('nip') }}">
                        <i class="fas fa-id-card input-icon"></i>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Email <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative;">
                        <input type="email" name="email" class="modern-input {{ $errors->has('email') ? 'input-error' : '' }}" placeholder="guru@sekolah.id" value="{{ old('email') }}" required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <!-- Telepon -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Nomor Telepon</label>
                    <div style="position: relative;">
                        <input type="tel" name="telepon" class="modern-input {{ $errors->has('telepon') ? 'input-error' : '' }}" placeholder="08...." value="{{ old('telepon') }}">
                        <i class="fas fa-phone input-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Keamanan -->
        <div style="padding: 30px; border-bottom: 1px solid #f8fafc;">
            <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #dcfce7; color: #10b981; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b; font-weight: 700;">Keamanan Akun</h3>
                    <p style="margin: 0; font-size: 0.85rem; color: #64748b;">Kata sandi untuk login</p>
                </div>
            </div>

            <div style="display: grid; gap: 24px;">
                <!-- Password -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Password <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password" class="modern-input {{ $errors->has('password') ? 'input-error' : '' }}" placeholder="Minimal 8 karakter" required>
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" onclick="togglePass('password')" class="toggle-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <!-- Hint Text -->
                    <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px; font-size: 0.8rem; color: #94a3b8;">
                        <i class="fas fa-info-circle"></i>
                        <span>Masukkan minimal 8 karakter untuk keamanan akun.</span>
                    </div>

                    <!-- Strength Meter (Hidden by default via JS logic) -->
                    <div id="passwordStrengthContainer" style="margin-top: 8px; display: none;">
                        <div style="height: 4px; background: #f1f5f9; border-radius: 2px; overflow: hidden;">
                            <div id="strengthBar" style="height: 100%; width: 0; transition: width 0.3s ease, background 0.3s ease;"></div>
                        </div>
                        <p id="strengthText" style="font-size: 0.75rem; color: #94a3b8; margin-top: 4px;">Kekuatan Password</p>
                    </div>
                </div>

                <!-- Confirm Password (Hidden by default via JS logic) -->
                <div id="passwordConfirmationGroup" style="display: none;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Konfirmasi Password <span style="color: #ef4444;">*</span></label>
                    <div style="position: relative;">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="modern-input {{ $errors->has('password_confirmation') ? 'input-error' : '' }}" placeholder="Ulangi password" required>
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" onclick="togglePass('password_confirmation')" class="toggle-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Tambahan -->
        <div style="padding: 30px; border-bottom: 1px solid #f8fafc;">
            <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #ffedd5; color: #f97316; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-info"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b; font-weight: 700;">Data Tambahan</h3>
                    <p style="margin: 0; font-size: 0.85rem; color: #64748b;">Informasi pendukung (Opsional)</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
                <!-- Jenis Kelamin -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Jenis Kelamin</label>
                    <div style="display: flex; gap: 12px;">
                        <label class="custom-radio">
                            <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}>
                            <span>Laki-laki</span>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                            <span>Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Tanggal Lahir</label>
                    <div style="position: relative;">
                        <input type="date" name="tanggal_lahir" class="modern-input" value="{{ old('tanggal_lahir') }}" style="color-scheme: light;">
                        <i class="fas fa-calendar input-icon"></i>
                    </div>
                </div>

                <!-- Kelas (FITUR BARU) -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Kelas</label>
                    <div style="position: relative;">
                        <input type="text" name="kelas" class="modern-input {{ $errors->has('kelas') ? 'input-error' : '' }}" placeholder="Contoh: X RPL" value="{{ old('kelas') }}">
                        <i class="fas fa-school input-icon"></i>
                    </div>
                </div>

                <!-- Jurusan (FITUR BARU) -->
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Jurusan</label>
                    <div style="position: relative;">
                        <input type="text" name="jurusan" class="modern-input {{ $errors->has('jurusan') ? 'input-error' : '' }}" placeholder="Contoh: RPL" value="{{ old('jurusan') }}">
                        <i class="fas fa-graduation-cap input-icon"></i>
                    </div>
                </div>

                <!-- Alamat -->
                <div style="grid-column: 1 / -1;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px;">Alamat Lengkap</label>
                    <div style="position: relative;">
                        <textarea name="alamat" class="modern-input" rows="3" placeholder="Tulis alamat domisili guru..." style="resize: vertical;">{{ old('alamat') }}</textarea>
                        <i class="fas fa-map-marker-alt input-icon" style="top: 15px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Status -->
        <div style="padding: 30px; background: #f8fafc;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div>
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b;">Status Akun</h3>
                    <p style="margin: 0; font-size: 0.85rem; color: #64748b;">Aktifkan akun agar guru bisa langsung login.</p>
                </div>
        
        <!-- Status Akun (Select Style) -->
        <div class="form-group">
            <div class="input-wrapper">
                <select name="status_akun" class="modern-input {{ $errors->has('status_akun') ? 'input-error' : '' }}">
                    <option value="aktif" {{ old('status_akun', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status_akun') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div style="padding: 24px 30px; background: white; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 15px;">
            <a href="{{ url('/admin/guru') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary" onclick="return confirmCreate()">
                <i class="fas fa-save" style="margin-right: 8px;"></i> Simpan Data
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

    /* --- Modern Input Style --- */
    .modern-input {
        width: 100%;
        padding: 12px 16px 12px 44px; /* Space for icon */
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: #334155;
        background: #ffffff;
        border: 2px solid var(--border);
        border-radius: var(--radius);
        transition: all 0.3s ease;
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

    /* --- Custom Radio Buttons --- */
    .custom-radio {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: var(--text-main);
        padding: 8px 16px;
        border: 2px solid var(--border);
        border-radius: var(--radius-sm);
        transition: all 0.3s;
        user-select: none;
    }

    .custom-radio:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }

    .custom-radio input {
        display: none;
    }

    .custom-radio:has(input:checked) {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.05);
        color: var(--primary);
        font-weight: 600;
    }

    /* --- Buttons --- */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 24px;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: var(--radius);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        font-family: 'Inter', sans-serif;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
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

    /* --- Animations --- */
    @media (max-width: 600px) {
        .btn { width: 100%; }
        .modern-input { padding: 12px 12px 12px 40px; }
    }

    /* =========================================
       ANDROID MOBILE APP OPTIMIZATION (COMPACT)
       ========================================= */
    @media (max-width: 768px) {
        
        /* 1. General Container & Body */
        body {
            background-color: #f8fafc;
            font-size: 14px; /* Slightly smaller base font */
        }

        div[style*="max-width: 900px"] {
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        /* 2. Header Section (COMPACT) */
        div[style*="linear-gradient(135deg, #6366f1"] {
            flex-direction: column;
            align-items: flex-start;
            border-radius: 0 0 16px 16px !important;
            padding: 16px !important; /* Reduced padding */
            margin-bottom: 12px !important; /* Reduced margin */
            gap: 12px !important;
        }

        h1[style*="font-size: 1.8rem"] {
            font-size: 1.3rem !important; /* Smaller Title */
            margin-bottom: 2px !important;
        }

        /* Hide/Reduce Subtitle to save space */
        div[style*="max-width: 500px; line-height: 1.5"] {
            font-size: 0.8rem !important;
            opacity: 0.8;
        }

        /* Progress Indicator Mobile (Compact) */
        div[style*="backdrop-filter: blur(10px)"] {
            position: static !important;
            width: 100% !important;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px !important;
            padding: 8px 12px !important; /* Tight padding */
            border-radius: 10px !important;
            text-align: left;
        }

        .progress-wrapper {
            width: 36px !important; /* Smaller circle */
            height: 36px !important;
            margin: 0 !important;
        }
        
        .progress-value {
            font-size: 0.7rem !important;
        }

        /* 3. Error Alert */
        div[style*="background: #fee2e2"] {
            margin: 0 10px 12px 10px !important; /* Smaller margins */
            padding: 12px !important;
            border-radius: 10px !important;
            font-size: 0.8rem;
        }

        /* 4. Main Form Card */
        form {
            margin: 0 10px 12px 10px !important; /* Compact margins */
            border-radius: 12px !important;
        }

        /* 5. Form Sections */
        div[style*="border-bottom: 1px solid #f8fafc"] {
            padding: 16px 12px !important; /* Reduced internal padding */
        }

        div[style*="background: #f8fafc"] { /* Status Section */
            padding: 16px 12px !important;
            border-radius: 0 0 12px 12px !important;
        }

        /* Section Headers (Compact) */
        div[style*="margin-bottom: 25px"] {
            margin-bottom: 12px !important;
            gap: 8px !important;
        }

        div[style*="margin-bottom: 25px"] h3 {
            font-size: 0.95rem !important;
        }

        div[style*="width: 40px; height: 40px"] {
            width: 30px !important; /* Smaller Icon Box */
            height: 30px !important;
            font-size: 0.85rem !important;
        }

        /* 6. Grid System (Force 1 Column Compact) */
        div[style*="grid-template-columns: repeat(auto-fit"] {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important; /* Reduced Gap */
        }

        /* 7. Inputs (Compact & Touch Optimized) */
        .modern-input {
            padding: 10px 12px 10px 36px !important; /* Tighter Padding */
            font-size: 14px !important; /* Compact Font */
            border-radius: 8px !important;
        }

        .input-icon {
            left: 10px !important; /* Adjust Icon Position */
            font-size: 0.85rem !important;
        }

        .toggle-btn {
            right: 10px !important;
            padding: 2px !important;
        }

        /* Labels */
        label {
            font-size: 0.75rem !important;
            margin-bottom: 4px !important;
        }

        /* Radio Button Compact */
        .custom-radio {
            width: 100%;
            justify-content: center;
            padding: 8px !important; /* Compact Radio */
            font-size: 0.85rem !important;
        }
        
        div[style*="display: flex; gap: 12px;"] {
            gap: 8px !important;
        }

        /* 8. Status Switch (Compact) */
        div[style*="position: relative; display: inline-block; width: 60px"] {
            width: 50px !important; /* Smaller Switch */
            height: 26px !important;
        }

        /* 9. Footer Actions (Compact Buttons) */
        div[style*="justify-content: flex-end; gap: 15px"] {
            flex-direction: column !important;
            padding: 12px !important;
            gap: 8px !important;
        }

        .btn {
            width: 100% !important;
            padding: 10px !important; /* Compact Button Height */
            font-size: 0.9rem !important;
            border-radius: 10px !important;
        }

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

    // Logic: Show/hide confirmation & strength based on password input (Sama seperti Edit)
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

    // Password Strength Logic (Sama seperti Edit)
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

    // Confirmation Dialog (Sama seperti Edit)
    function confirmCreate() {
        return confirm('Apakah Anda yakin ingin menyimpan data guru baru ini?');
    }

    // Progress Circle Logic
    function updateProgress() {
        const form = document.getElementById('teacherForm');
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        let filled = 0;
        inputs.forEach(input => { if(input.value.trim() !== '') filled++; });
        
        const percent = Math.round((filled / inputs.length) * 100);
        
        // Update SVG Stroke Dasharray
        // 100 is the circumference approx, 0 is starting dash
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
        document.querySelectorAll('input, textarea').forEach(el => el.addEventListener('input', updateProgress));
    });
</script>
@endsection