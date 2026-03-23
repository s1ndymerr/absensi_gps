@extends('layouts.app')

@section('title', 'Edit Profil Guru')

@section('content')
<style>
    /* --- CSS VARIABLES & RESET --- */
    :root {
        --primary-soft: #6366f1;
        --primary-dark: #4f46e5;
        --secondary-soft: #a855f7;
        --bg-body: #f1f5f9;
        --bg-surface: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-soft: #e2e8f0;
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        --radius-xl: 24px;
    }

    body {
        background-color: var(--bg-body);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
    }

    .profile-page-wrapper {
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 80vh;
        background: var(--bg-body);
        padding-top: 20px;
    }

    /* --- HEADER CARD --- */
    .profile-header-card {
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
        border-radius: 24px;
        padding: 40px;
        width: 100%;
        max-width: 800px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        display: flex;
        align-items: center;
        gap: 30px;
        margin-bottom: 30px;
    }

    .profile-header-card::after {
        content: '';
        position: absolute;
        top: -50px; left: -50px;
        width: 200px; height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .avatar-bg {
        flex-shrink: 0; position: relative; z-index: 2;
    }

    .avatar-text {
        width: 100px; height: 100px;
        background: rgba(255, 255, 255, 0.25);
        border: 3px solid rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.5rem; font-weight: 800;
        backdrop-filter: blur(5px);
    }

    .profile-text-info { z-index: 2; flex: 1; }
    .profile-text-info h2 { margin: 0 0 10px 0; font-size: 2rem; font-weight: 800; }
    
    .profile-meta {
        display: flex; align-items: center; gap: 15px;
        font-size: 0.95rem; font-weight: 600; opacity: 0.9;
    }

    .meta-item {
        display: flex; align-items: center; gap: 6px;
        background: rgba(255, 255, 255, 0.15);
        padding: 4px 12px; border-radius: 20px;
    }

    .meta-separator { opacity: 0.5; }

    /* --- DETAILS CARD --- */
    .details-card {
        background: var(--bg-surface);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        padding: 0;
        width: 100%;
        max-width: 800px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
        margin-bottom: 30px;
    }

    .details-header {
        padding: 20px 30px;
        border-bottom: 1px solid var(--border-soft);
        background: #f8fafc;
    }

    .details-header h3 {
        margin: 0; font-size: 1.1rem; font-weight: 700; color: var(--text-main);
        display: flex; align-items: center; gap: 10px;
    }
    
    .details-header h3 i {
        width: 32px; height: 32px;
        background: white; color: var(--primary-soft);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem;
        box-shadow: var(--shadow-md);
    }

    .details-body { padding: 10px 0; }

    /* --- FORM ROWS --- */
    .info-row {
        display: flex; align-items: center;
        padding: 20px 30px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.3s;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row:hover { background: #f8fafc; }

    .info-icon-wrapper {
        width: 50px; height: 50px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; color: white; flex-shrink: 0;
    }

    /* Gradients */
    .bg-purple { background: linear-gradient(135deg, #a855f7, #d8b4fe); }
    .bg-indigo { background: linear-gradient(135deg, #6366f1, #818cf8); }
    .bg-blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .bg-orange { background: linear-gradient(135deg, #f97316, #fb923c); }
    .bg-pink { background: linear-gradient(135deg, #ec4899, #f472b6); }
    .bg-teal { background: linear-gradient(135deg, #14b8a6, #2dd4bf); }

    .info-content {
        flex: 1; display: flex; flex-direction: column; gap: 4px;
        padding-left: 15px;
    }

    .info-label {
        font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;
        color: var(--text-muted); font-weight: 600;
    }

    .info-input {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.95rem;
        font-family: inherit;
    }
    
    .info-input:focus {
        outline: none; border-color: var(--primary-soft);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    input[readonly] {
        background-color: #f8fafc;
        color: #64748b;
        cursor: not-allowed;
    }

    .action-footer {
        width: 100%; max-width: 800px;
        display: flex; justify-content: center; gap: 15px;
        margin-bottom: 40px;
    }

    .btn-edit-profile {
        display: inline-flex; align-items: center; justify-content: center;
        gap: 12px; padding: 15px 40px;
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
        color: white; font-size: 1rem; font-weight: 700;
        border-radius: 50px; border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-edit-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }

    @media (max-width: 768px) {
        .profile-header-card {
            flex-direction: column; text-align: center;
            padding: 25px 15px;
        }
        .profile-meta { justify-content: center; }
        .info-row { flex-direction: column; align-items: flex-start; }
        .info-content { padding-left: 0; width: 100%; }
        .action-footer { flex-direction: column; }
    }
</style>

<div class="profile-page-wrapper">

    <div class="profile-header-card">
        <div class="avatar-bg">
            <div class="avatar-text">
                {{ substr($user->name, 0, 1) }}
            </div>
        </div>
        <div class="profile-text-info">
            <h2>Edit Profil</h2>
            <div class="profile-meta">
                <span class="meta-item">
                    <i class="fas fa-chalkboard-teacher"></i> Guru
                </span>
                <span class="meta-separator">•</span>
                <span class="meta-item">{{ $user->gurus->kelas_pengampu ?? '-' }}</span>
                <span class="meta-separator">•</span>
                <span class="meta-item">{{ $user->gurus->jurusan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="details-card">
        <div class="details-header">
            <h3><i class="fas fa-pen"></i> Ubah Informasi Akun</h3>
        </div>

        <form method="POST" action="{{ route('guru.profil.update') }}">
            @csrf

            <div class="details-body">

                <div class="info-row">
                    <div class="info-icon-wrapper bg-purple">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <label class="info-label">Nama Lengkap</label>
                        <input type="text"
                               name="name"
                               value="{{ $user->name }}"
                               class="info-input"
                               required>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon-wrapper bg-indigo">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <label class="info-label">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ $user->email }}"
                               class="info-input"
                               required>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon-wrapper bg-blue">
                        <i class="fas fa-id-badge"></i>
                    </div>
                    <div class="info-content">
                        <label class="info-label">Nomor Induk Pegawai (NIP)</label>
                        <input type="text"
                               value="{{ $user->gurus->nip ?? '-' }}"
                               class="info-input"
                               readonly>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon-wrapper bg-orange">
                        <i class="fas fa-chalkboard"></i>
                    </div>
                    <div class="info-content">
                        <label class="info-label">Kelas Pengampu</label>
                        <input type="text"
                               value="{{ $user->gurus->kelas_pengampu ?? '-' }}"
                               class="info-input"
                               readonly>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon-wrapper bg-pink">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <div class="info-content">
                        <label class="info-label">Jurusan Keahlian</label>
                        <input type="text"
                               value="{{ $user->gurus->jurusan ?? '-' }}"
                               class="info-input"
                               readonly>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon-wrapper bg-teal">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="info-content">
                        <label class="info-label">Password Baru</label>
                        <input type="password"
                               name="password"
                               class="info-input"
                               placeholder="Kosongkan jika tidak diubah">
                    </div>
                </div>

            </div>

            <div class="action-footer">
                <button type="submit" class="btn-edit-profile">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>

                <a href="{{ route('guru.profil') }}"
                   class="btn-edit-profile"
                   style="background:#e2e8f0;color:#475569">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection