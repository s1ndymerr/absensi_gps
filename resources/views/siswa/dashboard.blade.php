@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
@php
    $user = Auth::user();
@endphp

<div class="siswa-dashboard-wrapper">

    <!-- Profile Hero Section -->
    <div class="profile-hero-card">
        <div class="profile-content">
            <div class="avatar-wrapper">
                <div class="avatar-gradient">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
            <div class="greeting-box">
                <h4 class="greeting">Halo, Siswa!</h4>
                <h2 class="student-name">{{ $user->name }}</h2>
                <div class="student-badges">
                    <span class="badge-class bg-blue">
                        <i class="fas fa-user-graduate"></i> {{ $user->siswa->kelas ?? '-' }}
                    </span>
                    <span class="badge-class bg-teal">
                        <i class="fas fa-id-card"></i> {{ $user->siswa->nis ?? '-' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="hero-decoration">
            <i class="fas fa-graduation-cap"></i>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="stats-grid-custom">
        <!-- 1. Total Absensi -->
        <div class="stat-card-modern">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $totalAbsensi }}</h3>
                <p class="stat-label">Total Absensi</p>
            </div>
        </div>

        <!-- 2. Hadir -->
        <div class="stat-card-modern">
            <div class="stat-icon-wrapper icon-green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $hadir }}</h3>
                <p class="stat-label">Kehadiran Hadir</p>
            </div>
        </div>

        <!-- 3. Tidak Hadir -->
        <div class="stat-card-modern">
            <div class="stat-icon-wrapper icon-red">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $tidakHadir }}</h3>
                <p class="stat-label">Tidak Hadir</p>
            </div>
        </div>

        <!-- 4. Status Hari Ini -->
        <div class="stat-card-modern">
            @if($absenHariIni)
                <div class="stat-icon-wrapper {{ $absenHariIni->status === 'hadir' ? 'icon-green' : 'icon-orange' }}">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-details">
                    <h3>{{ ucfirst($absenHariIni->status) }}</h3>
                    <p class="stat-label">Status Hari Ini</p>
                </div>
            @else
                <div class="stat-icon-wrapper bg-gray">
                    <i class="fas fa-hourglass-start"></i>
                </div>
                <div class="stat-details">
                    <h3>Belum Absen</h3>
                    <p class="stat-label">Status Hari Ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Content Grid (Single Column - No Quick Actions) -->
    <div class="dashboard-content-single">
        
        <div class="dashboard-column">
            
            <!-- Card Informasi Siswa (Penuh Lebar) -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-id-card"></i> Informasi Siswa</h3>
                </div>
                <div class="card-body">
                    
                    <!-- Item 1: Nama -->
                    <div class="info-row">
                        <div class="info-icon-wrapper bg-blue">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                    </div>

                    <!-- Item 2: NIS -->
                    <div class="info-row">
                        <div class="info-icon-wrapper bg-purple">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Nomor Induk Siswa (NIS)</div>
                            <div class="info-value">{{ $user->siswa->nis ?? '-' }}</div>
                        </div>
                    </div>

                    <!-- Item 3: Email -->
                    <div class="info-row">
                        <div class="info-icon-wrapper bg-pink">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Alamat Email</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Info Banner (Pindah ke bawah) -->
            <div class="info-banner">
                <div class="info-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="info-content">
                    <h4>Tips Siswa</h4>
                    <p>Selalu patuhi jadwal belajar dan datang ke sekolah tepat waktu.</p>
                </div>
            </div>

        </div>
    </div>

</div>

<style>
    :root {
        /* Palette Identik */
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
        --color-warning: #f59e0b;
        --color-danger: #ef4444;
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

    .siswa-dashboard-wrapper {
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* --- Profile Hero Section --- */
    .profile-hero-card {
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
        border-radius: 20px;
        padding: 35px;
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 900px; /* Batas lebar agar rapi */
    }

    .profile-content {
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .avatar-wrapper {
        position: relative;
    }
    .avatar-gradient {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 800;
        backdrop-filter: blur(5px);
    }

    .greeting-box h4 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 5px 0;
        opacity: 0.9;
    }

    .student-name {
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0 0 10px 0;
    }

    .student-badges {
        display: flex;
        gap: 10px;
    }

    .badge-class {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .bg-blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .bg-teal { background: linear-gradient(135deg, #14b8a6, #2dd4bf); }
    .bg-purple { background: linear-gradient(135deg, #d8b4fe, #a855f7); }
    .bg-pink { background: linear-gradient(135deg, #f472b6, #fb7185); }

    .hero-decoration {
        font-size: 7rem;
        opacity: 0.1;
        position: absolute;
        right: -10px;
        bottom: -20px;
        transform: rotate(-15deg);
    }

    /* --- Stats Grid (Custom for Siswa) --- */
    .stats-grid-custom {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
        width: 100%;
        max-width: 900px;
    }

    .stat-card-modern {
        background: var(--bg-surface);
        padding: 24px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(255,255,255,0.5);
        /* Flex basis agar rapi */
        flex: 1 1 200px; 
    }

    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }

    .icon-blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
    .icon-green { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
    .icon-red { background: linear-gradient(135deg, #ef4444, #f87171); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
    .icon-orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
    
    .bg-gray { background: #cbd5e1; color: white; }

    .stat-details h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 4px 0;
        color: var(--text-main);
    }

    .stat-label {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* --- Dashboard Content (Single Column) --- */
    .dashboard-content-single {
        width: 100%;
        max-width: 900px;
        display: flex;
        flex-direction: column;
        gap: 30px;
        /* Center alignment wrapper */
        margin: 0 auto; 
    }

    .dashboard-column {
        display: flex;
        flex-direction: column;
        gap: 30px;
        width: 100%;
    }

    /* --- Content Cards --- */
    .content-card {
        background: var(--bg-surface);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        padding: 0;
        overflow: hidden;
        border:1px solid rgba(0,0,0,0.02);
    }

    .card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-soft);
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-title i {
        width: 32px;
        height: 32px;
        background: #e0e7ff;
        color: var(--primary-soft);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .card-body {
        padding: 25px;
    }

    /* --- Info Rows (Modern) --- */
    .info-row {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 20px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.3s;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row:hover {
        background: #f8fafc;
        border-radius: 8px;
        padding: 20px;
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
    .bg-teal { background: linear-gradient(135deg, #14b8a6, #2dd4bf); }

    .info-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
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

    /* --- Info Banner --- */
    .info-banner {
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        border: 1px solid #bfdbfe;
        border-radius: var(--radius-xl);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .info-icon {
        width: 40px;
        height: 40px;
        background: #38bdf8;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .info-content {
        flex: 1;
    }
    .info-content h4 {
        margin: 0 0 5px 0;
        color: #0c4a6e;
        font-size: 1rem;
    }
    .info-content p {
        margin: 0;
        color: #0369a1;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* --- Responsive --- */
    @media (max-width: 992px) {
        .profile-hero-card {
            flex-direction: column;
            text-align: center;
            padding: 25px;
        }
        .profile-content {
            flex-direction: column;
            text-align: center;
        }
        .student-badges {
            justify-content: center;
        }
    }

    /* ----------------------------------------------------------------
       ANDROID / MOBILE RESPONSIVE VIEW (SEIMBANG TOTAL)
    ---------------------------------------------------------------- */
    @media (max-width: 768px) {
        /* 1. Wrapper & Spacing */
        .siswa-dashboard-wrapper {
            padding: 10px; /* Padding minimal */
        }

        /* 2. Header Compact */
        .profile-hero-card {
            border-radius: 20px;
            padding: 25px 15px;
            margin-bottom: 20px;
            flex-direction: column;
            text-align: center;
        }
        
        .header-decoration { display: none; }

        /* Avatar & Text Size */
        .avatar-gradient {
            width: 60px; height: 60px;
            font-size: 1.6rem;
            margin: 0 auto;
        }

        .greeting-box h4 { font-size: 0.9rem; margin-bottom: 4px; }
        .student-name { font-size: 1.4rem; margin-bottom: 8px; }

        .student-badges {
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .badge-class {
            font-size: 0.75rem;
            padding: 4px 10px;
        }

        /* 3. Stats Grid - SEIMBANG SEMPURNA (Perfect Balance) */
        .stats-grid-custom {
            display: grid; /* Grid agar kotak sama besar */
            grid-template-columns: 1fr 1fr; /* 2 Kolom */
            gap: 10px; /* Jarak rapat */
            margin-bottom: 20px;
        }

        .stat-card-modern {
            padding: 15px 10px; /* Padding kompak */
            flex-direction: column; /* Susun vertikal */
            justify-content: center; /* Tengah vertikal */
            align-items: center; /* Tengah horizontal */
            text-align: center;
            height: 100%; /* Isi penuh grid cell */
        }

        /* Ikon & Angka Kecil */
        .stat-icon-wrapper {
            width: 35px; /* Ikon kecil */
            height: 35px;
            font-size: 1rem;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .stat-details {
            width: 100%;
        }

        .stat-details h3 {
            font-size: 1.3rem; /* Angka kecil */
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 0.7rem; /* Label sangat kecil (kompak) */
            line-height: 1.2;
        }

        /* 4. Content Card - SEIMBANG */
        .dashboard-content-single {
            gap: 20px;
        }

        .content-card {
            border-radius: 16px;
        }

        .card-header { padding: 12px 15px; }
        .card-title { font-size: 1rem; }
        .card-body { padding: 0; }

        /* --- Info Rows (Compact & Vertically Balanced) --- */
        .info-row {
            display: flex;
            flex-direction: row;
            justify-content: space-between; /* Label Kiri, Nilai Kanan */
            align-items: center; /* Center vertical balance */
            padding: 10px 15px; /* Padding kompak */
            border-bottom: 1px solid #f8fafc;
            gap: 15px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        /* Ikon Fixed Size */
        .info-icon-wrapper {
            width: 32px; /* Kecil & Fixed */
            height: 32px;
            font-size: 0.9rem;
            border-radius: 8px;
            flex-shrink: 0; /* Jangan mengecil */
        }

        /* Content */
        .info-content {
            padding-left: 0;
            text-align: right; /* Value rata kanan */
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end; /* Vertically align right items */
        }

        /* Tulisan Data PERKECIL SESUAI REQUEST */
        .info-label {
            font-size: 0.7rem; /* Sangat kecil */
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 0.8rem; /* SANGAT KECIL */
            font-weight: 600;
            color: var(--text-main);
            word-break: break-word;
            line-height: 1.3;
        }

        /* 5. Info Banner */
        .info-banner {
            padding: 12px 15px;
            gap: 12px;
            align-items: flex-start;
        }
        .info-icon {
            width: 32px; height: 32px;
            font-size: 1rem;
        }
        .info-content h4 { font-size: 0.9rem; margin-bottom: 2px; }
        .info-content p { font-size: 0.8rem; line-height: 1.4; }
    }
</style>
@endsection