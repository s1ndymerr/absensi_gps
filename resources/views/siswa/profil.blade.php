@extends('layouts.app')

@section('title', 'Profil Siswa')

@section('content')
<div class="profile-wrapper">

    <!-- Page Header -->
    <div class="page-header-section">
        <div class="header-content">
            <h1 class="main-title">Profil Siswa</h1>
            <p class="sub-title">Ubah informasi pribadi dan keamanan akun Anda.</p>
        </div>
    </div>

    <!-- Alerts (Success & Error) -->
    @if(session('success'))
        <div class="soft-alert success-alert">
            <i class="fas fa-check-circle"></i>
            <div class="alert-content">
                <strong>Berhasil!</strong>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="soft-alert error-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="alert-content">
                <strong>Terjadi Kesalahan!</strong>
                <p>Mohon periksa kembali formulir Anda.</p>
            </div>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="profile-form-card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-edit"></i> Ubah Data Diri</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('siswa.profil.update') }}">
                @csrf

                <!-- Input Group: Nama -->
                <div class="form-group-modern">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-group-modern">
                        <div class="input-icon-wrapper bg-blue">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" id="name" name="name" class="modern-input"
                               value="{{ $user->name }}" required placeholder="Masukkan nama lengkap">
                    </div>
                    <small class="error-msg">
                        {{ $errors->first('name') ? 'Nama ' . $errors->first('name') : '' }}
                    </small>
                </div>

                <!-- Input Group: Email -->
                <div class="form-group-modern">
                    <label for="email">Alamat Email</label>
                    <div class="input-group-modern">
                        <div class="input-icon-wrapper bg-purple">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input type="email" id="email" name="email" class="modern-input"
                               value="{{ $user->email }}" required placeholder="contoh@email.com">
                    </div>
                    <small class="error-msg">
                        {{ $errors->first('email') ? 'Email ' . $errors->first('email') : '' }}
                    </small>
                </div>

                <!-- Readonly Section (NIS & Kelas) -->
                <div class="row-readonly">
                    <div class="form-group-modern flex-1">
                        <label for="nis">Nomor Induk Siswa (NIS)</label>
                        <div class="input-group-modern">
                            <div class="input-icon-wrapper bg-gray">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <input type="text" id="nis" class="modern-input input-disabled"
                                   value="{{ $user->nis }}" readonly>
                        </div>
                        <small class="info-msg">Data ini tidak dapat diubah</small>
                    </div>

                    <div class="form-group-modern flex-1">
                        <label for="kelas">Kelas</label>
                        <div class="input-group-modern">
                            <div class="input-icon-wrapper bg-gray">
                                <i class="fas fa-chalkboard"></i>
                            </div>
                            <input type="text" id="kelas" class="modern-input input-disabled"
                                   value="{{ $user->kelas }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="form-divider"></div>

                <!-- Input Group: Password -->
                <div class="form-group-modern">
                    <label for="password">Password Baru (Opsional)</label>
                    <div class="input-group-modern">
                        <div class="input-icon-wrapper bg-teal">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" id="password" name="password" class="modern-input"
                               placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>
                    <small class="info-msg">Biarkan kosong jika Anda tidak ingin mengubah password.</small>
                </div>

                <!-- Input Group: Password Confirmation -->
                <div class="form-group-modern">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-group-modern">
                        <div class="input-icon-wrapper bg-teal">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="modern-input"
                               placeholder="Ulangi password baru">
                    </div>
                    <small class="error-msg">
                        {{ $errors->first('password_confirmation') ? 'Konfirmasi ' . $errors->first('password_confirmation') : '' }}
                    </small>
                </div>

                <!-- Submit Button -->
                <div class="form-action">
                    <button type="submit" class="btn btn-primary-gradient btn-block">
                        <i class="fas fa-save"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<style>
    :root {
        /* Identik dengan halaman lain */
        --primary-soft: #6366f1;
        --primary-dark: #4f46e5;
        --secondary-soft: #a855f7;
        --bg-body: #f1f5f9;
        --bg-surface: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-soft: #e2e8f0;
        
        /* Status Colors */
        --color-success: #10b981;
        --color-danger: #ef4444;
        --color-warning: #f59e0b;
        --color-info: #3b82f6;
        --color-teal: #14b8a6;
        
        /* Shadows */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);

        /* Radius */
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-xl: 24px;
    }

    .profile-wrapper {
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* --- Header --- */
    .page-header-section {
        width: 100%;
        max-width: 800px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 0 10px; /* Flex align */
    }

    .header-content h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 5px 0;
        letter-spacing: -0.5px;
    }

    .sub-title {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.95rem;
    }

    /* --- Alerts (Sama dengan Absensi) --- */
    .soft-alert {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border-left: 5px solid;
        width: 100%;
        max-width: 800px;
    }
    .success-alert {
        background: #f0fdf4;
        border-color: #22c55e;
        color: #15803d;
    }
    .error-alert {
        background: #fef2f2;
        border-color: #ef4444;
        color: #991b1b;
    }
    .alert-icon { font-size: 1.4rem; flex-shrink: 0; }
    .alert-content { flex: 1; }
    .alert-content strong { display: block; font-size: 0.9rem; margin-bottom: 4px; }
    .alert-content p { margin: 0; font-size: 0.9rem; }

    /* --- Main Form Card --- */
    .profile-form-card {
        background: var(--bg-surface);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        padding: 0;
        overflow: hidden;
        width: 100%;
        max-width: 800px;
        border: 1px solid rgba(0,0,0,0.02);
        margin-bottom: 50px;
    }

    .card-header {
        padding: 25px 30px;
        border-bottom: 1px solid var(--border-soft);
        background: #fff;
    }

    .card-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-title i {
        width: 36px;
        height: 36px;
        background: #e0e7ff;
        color: var(--primary-soft);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .card-body {
        padding: 30px;
    }

    /* --- Form Elements --- */
    .form-group-modern {
        margin-bottom: 25px;
        position: relative;
    }

    .form-group-modern label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.9rem;
    }

    /* Input Group (Icon + Input) */
    .input-group-modern {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon-wrapper {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 45px;
        background: var(--bg-body); /* Fallback */
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        z-index: 2;
    }

    /* Gradients for Icons */
    .bg-blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .bg-purple { background: linear-gradient(135deg, #a855f7, #d8b4fe); }
    .bg-teal { background: linear-gradient(135deg, #14b8a6, #2dd4bf); }
    .bg-gray { background: #cbd5e1; color: #fff; opacity: 0.8; }

    .modern-input {
        width: 100%;
        padding: 12px 15px 12px 55px; /* Left padding for icon */
        background: #f8fafc;
        border: 1px solid var(--border-soft);
        border-radius: 10px;
        color: var(--text-main);
        font-size: 0.95rem;
        transition: all 0.3s;
        outline: none;
    }

    .modern-input:focus {
        background: white;
        border-color: var(--primary-soft);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Readonly Input Style */
    .input-disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
        border-color: transparent;
    }
    .input-disabled:focus {
        background: #f1f5f9;
        box-shadow: none;
        border-color: transparent;
    }

    .info-msg {
        display: block;
        margin-top: 6px;
        font-size: 0.8rem;
        color: var(--text-muted);
        font-style: italic;
    }

    .error-msg {
        display: block;
        margin-top: 6px;
        font-size: 0.8rem;
        color: var(--color-danger);
        font-weight: 600;
    }

    /* --- Readonly Row Section --- */
    .row-readonly {
        display: flex;
        gap: 20px;
    }
    .flex-1 { flex: 1; }

    /* --- Divider --- */
    .form-divider {
        height: 1px;
        background: var(--border-soft);
        margin: 30px 0;
        position: relative;
    }
    .form-divider::after {
        content: 'Keamanan Akun';
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        padding: 0 10px;
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    /* --- Button --- */
    .form-action {
        margin-top: 10px;
    }
    .btn-primary-gradient {
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }
    .btn-block {
        width: 100%;
        padding: 14px 20px;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .btn-block:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(99, 102, 241, 0.4);
    }

    /* ----------------------------------------------------------------
       ANDROID / MOBILE RESPONSIVE VIEW (SEIMBANG & KOMPAK)
    ---------------------------------------------------------------- */
    @media (max-width: 768px) {
        /* 1. Wrapper & Spacing */
        .profile-wrapper {
            padding: 10px; /* Padding minimal */
        }

        /* 2. Header Compact */
        .page-header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
            margin-bottom: 20px;
        }
        .header-content h1 {
            font-size: 1.5rem; /* Tidak terlalu besar */
        }
        .sub-title {
            font-size: 0.9rem;
        }

        /* 3. Alerts Compact */
        .soft-alert {
            padding: 12px 15px; /* Padding dikurangi */
            margin-bottom: 15px;
            border-radius: 10px;
        }
        .alert-icon { font-size: 1.2rem; }
        .alert-content strong { font-size: 0.85rem; }
        .alert-content p { font-size: 0.85rem; }

        /* 4. Main Card Compact */
        .profile-form-card {
            max-width: 100%; /* Lebar penuh */
            border-radius: 16px;
            box-shadow: var(--shadow-md);
        }
        .card-header {
            padding: 15px 20px;
        }
        .card-header h3 {
            font-size: 1.1rem;
        }
        .card-body {
            padding: 20px; /* Padding body dikurangi */
        }

        /* 5. Form Groups (Balance & Compact) */
        .form-group-modern {
            margin-bottom: 20px; /* Jarak konsisten */
        }

        .form-group-modern label {
            font-size: 0.85rem; /* Label kecil */
            margin-bottom: 6px;
        }

        /* 6. Input Group (The Key for Balance) */
        .input-group-modern {
            height: 45px; /* TINGGI FIX agar SEIMBANG */
        }

        .input-icon-wrapper {
            width: 40px; /* Ikon lebih kecil/ramping */
            font-size: 1rem;
        }

        .modern-input {
            padding-left: 45px; /* Sesuaikan dengan lebar ikon */
            padding-top: 0;
            padding-bottom: 0;
            height: 100%; /* Isi tinggi parent */
            font-size: 0.9rem; /* Font lebih kecil */
            border-radius: 10px;
        }

        /* Readonly Disabled Style Mobile */
        .input-disabled {
            background: #f8fafc;
            color: #94a3b8;
            border-color: #e2e8f0;
        }

        /* Error/Info Messages Small */
        .error-msg, .info-msg {
            font-size: 0.75rem;
            margin-top: 4px;
        }

        /* 7. Readonly Row Section (Stacked) */
        .row-readonly {
            flex-direction: column; /* Susun vertikal */
            gap: 0; /* Gap ditiadakan, pakai margin */
        }
        .row-readonly > .form-group-modern {
            margin-bottom: 20px; /* Konsisten margin */
        }
        .row-readonly > .form-group-modern:last-child {
            margin-bottom: 0; /* Reset margin terakhir */
        }

        /* 8. Divider */
        .form-divider {
            margin: 25px 0;
        }
        .form-divider::after {
            font-size: 0.75rem;
            top: -9px;
        }

        /* 9. Button Compact */
        .form-action {
            margin-top: 5px;
        }
        .btn-block {
            padding: 12px 20px; /* Height kompak */
            font-size: 0.95rem;
            border-radius: 12px;
        }
    }
</style>
@endsection