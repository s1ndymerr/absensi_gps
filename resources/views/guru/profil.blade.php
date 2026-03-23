@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
<div class="profile-page-wrapper">

    <!-- Profile Hero Section (Sama dengan Profil Siswa) -->
    <div class="profile-header-card">
        <div class="avatar-bg">
            <div class="avatar-text">
                {{ substr($user->name, 0, 1) }}
            </div>
        </div>
        <div class="profile-text-info">
            <h2>{{ $user->name }}</h2>
            <div class="profile-meta">
                <span class="meta-item"><i class="fas fa-chalkboard-teacher"></i> Guru</span>
                <span class="meta-separator">•</span>
                <span class="meta-item">{{ $user->guru->kelas ?? '-' }}</span>
                <span class="meta-separator">•</span>
                <span class="meta-item">{{ $user->guru->jurusan ?? '-' }}</span>
            </div>
        </div>
        <div class="header-decoration">
            <i class="fas fa-user-circle"></i>
        </div>
    </div>

    <!-- Main Details Card -->
    <div class="details-card">
        <div class="details-header">
            <h3><i class="fas fa-id-card"></i> Informasi Akun</h3>
        </div>
        
        <div class="details-body">
            
            <!-- Item 1: Nama -->
            <div class="info-row">
    <div class="info-icon-wrapper bg-purple">
        <i class="fas fa-user"></i>
    </div>

    <div class="info-content">
        <div class="info-label">Nama Lengkap</div>

        <!-- MODE VIEW -->
        <div class="info-value view-mode">
            {{ $user->name }}
        </div>

        
    </div>
</div>


            <!-- Item 2: Email -->
            <div class="info-row">
                <div class="info-icon-wrapper bg-indigo">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Alamat Email</div>
                    <div class="info-value">{{ $user->email }}</div>
                </div>
            </div>

            <!-- Item 3: NIP -->
            <div class="info-row">
                <div class="info-icon-wrapper bg-blue">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Nomor Induk Pegawai (NIP)</div>
                    <div class="info-value">{{ $user->guru->nip ?? '-' }}</div>
                </div>
            </div>

            <!-- Item 4: Kelas -->
            <div class="info-row">
                <div class="info-icon-wrapper bg-orange">
                    <i class="fas fa-chalkboard"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Kelas Pengampu</div>
                    <div class="info-value">{{ $user->guru->kelas ?? '-' }}</div>
                </div>
            </div>

            <!-- Item 5: Jurusan -->
            <div class="info-row">
                <div class="info-icon-wrapper bg-pink">
                    <i class="fas fa-bookmark"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Jurusan Keahlian</div>
                    <div class="info-value">{{ $user->guru->jurusan ?? '-' }}</div>
                </div>
            </div>

            <!-- Item 6: Role -->
            <div class="info-row">
                <div class="info-icon-wrapper bg-teal">
                    <i class="fas fa-user-tag"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Role Sistem</div>
                    <div class="info-value">Guru</div>
                </div>
            </div>

        </div>
    </div>

    <!-- Action Footer -->
    <div class="action-footer">
     <a href="{{ route('guru.profil.edit') }}" class="btn-edit-profile">
    <i class="fas fa-pen"></i>
    Edit Profil
</a>

</form>

</div>
<script>
document.getElementById('btnEdit').addEventListener('click', function () {
    document.querySelectorAll('.view-mode').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.edit-mode').forEach(el => {
        el.style.display = 'block';
        el.removeAttribute('disabled');
    });

    this.style.display = 'none';
    document.getElementById('btnSave').style.display = 'inline-flex';
});
</script>


<style>
    :root {
        /* Palette Identik dengan Profil Siswa */
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
        --color-info: #3b82f6;
        --color-teal: #14b8a6;
        
        /* Shadows */
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);

        /* Radius */
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-xl: 24px;
    }

    .profile-page-wrapper {
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 80vh;
        background: var(--bg-body);
        padding-top: 20px;
    }

    /* --- Profile Header Card (Sama dengan Siswa) --- */
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
        top: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .avatar-bg {
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .avatar-text {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.25);
        border: 3px solid rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 800;
        backdrop-filter: blur(5px);
    }

    .profile-text-info {
        z-index: 2;
        flex: 1;
    }

    .profile-text-info h2 {
        margin: 0 0 10px 0;
        font-size: 2rem;
        font-weight: 800;
    }

    .profile-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 0.95rem;
        font-weight: 600;
        opacity: 0.9;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.15);
        padding: 4px 12px;
        border-radius: 20px;
    }

    .meta-separator {
        opacity: 0.5;
    }

    .header-decoration {
        font-size: 8rem;
        opacity: 0.1;
        position: absolute;
        right: 10px;
        bottom: -30px;
        transform: rotate(-10deg);
        z-index: 1;
    }

    /* --- Details Card (Sama dengan Siswa) --- */
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
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .details-header h3 i {
        width: 32px;
        height: 32px;
        background: white;
        color: var(--primary-soft);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        box-shadow: var(--shadow-md);
}

    .details-body {
        padding: 10px 0;
    }

    /* --- Info Rows (Sama dengan Siswa) --- */
    .info-row {
        display: flex;
        align-items: center;
        padding: 20px 30px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.3s;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row:hover {
        background: #f8fafc;
    }

    .info-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        flex-shrink: 0;
    }

    .bg-purple { background: linear-gradient(135deg, #a855f7, #d8b4fe); }
    .bg-indigo { background: linear-gradient(135deg, #6366f1, #818cf8); }
    .bg-blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .bg-orange { background: linear-gradient(135deg, #f97316, #fb923c); }
    .bg-pink { background: linear-gradient(135deg, #ec4899, #f472b6); }
    .bg-teal { background: linear-gradient(135deg, #14b8a6, #2dd4bf); }

    .info-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding-left: 15px;
    }

    .info-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        font-weight: 600;
    }

    .info-value {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-main);
    }

    /* --- Action Footer (Sama dengan Siswa) --- */
    .action-footer {
        width: 100%;
        max-width: 800px;
        display: flex;
        justify-content: center;
    }

    .btn-edit-profile {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 15px 40px;
        background: #e2e8f0;
        color: #94a3b8;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 50px;
        border: none;
        cursor: not-allowed;
        box-shadow: none;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }

    .btn-edit-profile small {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-left: 8px;
        background: rgba(0,0,0,0.1);
        padding: 2px 8px;
        border-radius: 10px;
    }

    /* Jika diaktifkan nanti */
    .btn-edit-profile {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 15px 40px;
    background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
    color: white;
    font-size: 1rem;
    font-weight: 700;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    transition: all 0.3s;
}

    .btn-edit-profile:not([disabled]):hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }
    .btn-edit-profile:not([disabled]) small {
        display: none;
    }

    /* ----------------------------------------------------------------
       ANDROID / MOBILE RESPONSIVE VIEW (DATA LEBIH KECIL/KOMPAK)
    ---------------------------------------------------------------- */
    @media (max-width: 768px) {
        /* 1. Wrapper & Spacing */
        .profile-page-wrapper {
            min-height: 100vh;
            padding-top: 0;
            padding-bottom: 20px;
        }

        /* 2. Profile Header */
        .profile-header-card {
            border-radius: 0 0 24px 24px;
            border-radius: 20px;
            padding: 25px 15px;
            margin-bottom: 20px;
            flex-direction: column;
            text-align: center;
        }

        .header-decoration { display: none; }

        .avatar-text {
            width: 70px;
            height: 70px;
            font-size: 1.6rem;
            margin: 0 auto;
        }

        .profile-text-info h2 {
            font-size: 1.4rem;
            margin-bottom: 8px;
        }

        .profile-meta {
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 0.8rem;
        }

        .meta-item {
            font-size: 0.75rem;
            padding: 3px 8px;
        }

        .meta-separator { display: none; }

        /* 3. Details Card - UKURAN DATA DIKECILKAN */
        .details-card {
            border-radius: 16px;
            margin-bottom: 0;
        }

        /* Header Kecil */
        .details-header {
            padding: 10px 20px; /* Padding vertikal dikurangi */
        }
        .details-header h3 {
            font-size: 0.95rem;
        }

        .details-body { padding: 0; }

        /* --- Baris Data (Info Row) --- */
        .info-row {
            flex-direction: column;
            align-items: center; /* Center Aligned */
            text-align: center;
            /* Padding vertikal dikurangi drastis agar baris tidak tinggi/terlalu besar */
            padding: 12px 15px; 
            gap: 5px; /* Jarak antara ikon dan teks */
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 12px;
        }

        /* Ikon Lebih Kecil */
        .info-icon-wrapper {
            width: 32px; /* Dari 40px -> 32px */
            height: 32px;
            font-size: 0.9rem; /* Ikon di dalam */
            margin-bottom: 0;
            border-radius: 8px;
        }

        /* Teks Label */
        .info-content {
            padding-left: 0;
            width: 100%;
            gap: 2px; /* Jarak label-value diperketat */
        }

        .info-label {
            font-size: 0.7rem; /* Sangat kecil tapi jelas */
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Teks Nilai Data */
        .info-value {
            font-size: 0.9rem; /* Dari 1rem -> 0.9rem (Data lebih kecil) */
            font-weight: 500; /* Jangan bold terlalu tebal */
            color: var(--text-main);
            line-height: 1.4;
        }

        /* 4. Action Footer */
        .action-footer {
            margin-top: 20px;
            padding: 0 15px;
        }

        .btn-edit-profile {
            width: 100%;
            padding: 10px; /* Button kompak */
            font-size: 0.9rem;
            justify-content: center;
            border-radius: 12px;
        }
        
        .btn-edit-profile small {
            font-size: 0.6rem;
            padding: 2px 6px;
        }
        .info-input {
    width: 100%;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.95rem;
    display: none;
}

.edit-mode {
    display: none;
}

.view-mode {
    display: block;
}

    }
</style>
@endsection