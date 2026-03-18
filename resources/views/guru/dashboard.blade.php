@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="guru-dashboard-wrapper">

    <!-- Profile Hero Section -->
    <div class="profile-hero-card">
        <div class="profile-content">
            <div class="avatar-wrapper">
                <div class="avatar-gradient">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
            <div class="greeting-box">
                <h4 class="greeting">Selamat Datang,</h4>
                <h2 class="teacher-name">{{ $user->name }}</h2>
                <div class="teacher-badges">
                    <span class="badge-class bg-purple">
                        <i class="fas fa-chalkboard"></i> {{ $user->kelas ?? '-' }}
                    </span>
                    <span class="badge-class bg-indigo">
                        <i class="fas fa-user-tag"></i> {{ $user->jurusan ?? '-' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="hero-decoration">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
    </div>

    <!-- Statistics Grid (Hanya 3 Kartu - Rapih & Tengah) -->
    <div class="stats-grid-custom">
        <!-- 1. Hadir -->
        <div class="stat-card-modern">
            <div class="stat-icon-wrapper icon-green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $hadir }}</h3>
                <p class="stat-label">Kehadiran Hadir</p>
            </div>
        </div>

        <!-- 2. Izin -->
        <div class="stat-card-modern">
            <div class="stat-icon-wrapper icon-orange">
                <i class="fas fa-file-contract"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $izin }}</h3>
                <p class="stat-label">Izin / Sakit</p>
            </div>
        </div>

        <!-- 3. Alpha -->
        <div class="stat-card-modern">
            <div class="stat-icon-wrapper icon-red">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $sakit }}</h3>
                <p class="stat-label">Tanpa Keterangan</p>
            </div>
        </div>

        <!-- (Total Jadwal DIHAPUS SESUAI PERMINTAAN) -->
    </div>

    <!-- Main Content Grid (Single Column Centered - Tanpa Aksi Cepat) -->
    <div class="dashboard-content-single">
        
        <!-- Left Column: Attendance Chart (Ambil Penuh Lebar) -->
        <div class="dashboard-column">
            
            <!-- Chart Card -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar"></i> Ringkasan Kehadiran</h3>
                </div>
                <div class="card-body">
                    <!-- Visual Chart (CSS only) -->
                    <div class="chart-container">
                        <div class="chart-legend">
                            <div class="legend-item">
                                <span class="dot hadir"></span> Hadir
                            </div>
                            <div class="legend-item">
                                <span class="dot alpha"></span> Tidak Hadir
                            </div>
                        </div>
                        <div class="bar-chart">
                            @php
                                $totalRekap = $total > 0 ? $total : 1;
                                $persenHadir = round(($hadir / $totalRekap) * 100);
                                $persenTidak = 100 - $persenHadir;
                            @endphp
                            
                            <!-- Bar Hadir -->
                            <div class="bar-group">
                                <div class="bar-label">{{ $persenHadir }}%</div>
                                <div class="bar-wrapper">
                                    <div class="bar-fill bg-success" style="width: {{ $persenHadir }}%"></div>
                                </div>
                            </div>

                            <!-- Bar Alpha/Izin/Sakit -->
                            <div class="bar-group">
                                <div class="bar-label">{{ $persenTidak }}%</div>
                                <div class="bar-wrapper">
                                    <div class="bar-fill bg-warning" style="width: {{ $persenTidak }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-text">
                        Anda telah hadir mengajar <strong>{{ $hadir }}</strong> kali dari total <strong>{{ $total }}</strong> sesi. Performa Anda sangat baik!
                    </div>
                </div>
            </div>

            <!-- Info/Status (Dipindah ke bawah Chart) -->
            <div class="info-banner">
                <div class="info-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="info-content">
                    <h4>Tips Mengajar</h4>
                    <p>Pastikan Anda melakukan absen masuk di sekurang 15 menit sebelum jam mengajar dimulai agar data presensi akurat.</p>
                </div>
            </div>

        </div>
    </div>

</div>

<style>
    :root {
        /* Identik dengan Dashboard Utama & Halaman Lain */
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

    .guru-dashboard-wrapper {
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
        max-width: 900px;
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

    .teacher-name {
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0 0 10px 0;
    }

    .teacher-badges {
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

    .bg-purple { background: linear-gradient(135deg, #d8b4fe, #a855f7); }
    .bg-indigo { background: linear-gradient(135deg, #818cf8, #6366f1); }

    .hero-decoration {
        font-size: 7rem;
        opacity: 0.1;
        position: absolute;
        right: -10px;
        bottom: -20px;
        transform: rotate(-15deg);
    }

    /* --- Stats Grid (Hanya 3 Item) --- */
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

    .icon-green { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
    .icon-orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
    .icon-red { background: linear-gradient(135deg, #ef4444, #f87171); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
    .icon-blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }

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

    /* --- Dashboard Content (Single Column Centered) --- */
    .dashboard-content-single {
        width: 100%;
        max-width: 900px;
        display: flex;
        flex-direction: column;
        gap: 30px;
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
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-soft);
        background: white;
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
        padding: 30px 40px; /* Padding lebih luas agar rapi */
    }

    /* --- Chart Visualization --- */
    .chart-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }
    
    .chart-legend {
        display: flex;
        gap: 20px;
        background: #f8fafc;
        padding: 12px 24px;
        border-radius: 20px;
        width: 100%;
        justify-content: center;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-main);
    }
    .dot { width: 10px; height: 10px; border-radius: 50%; }
    .dot.hadir { background: var(--color-success); }
    .dot.alpha { background: var(--color-warning); }

    .bar-chart {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .bar-group {
        display: flex;
        align-items: center;
        gap: 20px;
        width: 100%;
    }
    .bar-label {
        width: 60px;
        font-weight: 700;
        color: var(--text-muted);
        text-align: right;
    }
    .bar-wrapper {
        flex: 1;
        height: 16px; /* Tinggi bar lebih besar agar jelas */
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }
    .bar-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 1.5s ease-out;
    }
    
    .bg-success { background: var(--color-success); }
    .bg-warning { background: var(--color-warning); }

    .summary-text {
        text-align: center;
        margin-top: 25px;
        color: var(--text-muted);
        line-height: 1.6;
        font-size: 1rem;
        padding-top: 20px;
        border-top: 1px dashed var(--border-soft);
    }

    /* --- Info Banner (Aligned Centered) --- */
    .info-banner {
        background: linear-gradient(135deg, #fffbeb, #fcd34d);
        border: 1px solid #fcd34d;
        border-radius: var(--radius-xl);
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .info-icon {
        width: 40px;
        height: 40px;
        background: #fbbf24;
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
        color: #92400e;
        font-size: 1rem;
    }
    .info-content p {
        margin: 0;
        color: #b45309;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* ----------------------------------------------------------------
       ANDROID / MOBILE RESPONSIVE VIEW (SEIMBANG & KOMPAK)
    ---------------------------------------------------------------- */
    @media (max-width: 768px) {
        /* Wrapper & Spacing */
        .guru-dashboard-wrapper {
            padding: 0 15px; /* Padding lebih kecil untuk layar kecil */
        }

        /* --- 1. Hero Card --- */
        .profile-hero-card {
            flex-direction: column;
            text-align: center;
            padding: 25px 20px; /* Padding dikurangi agar compact */
            margin-bottom: 20px;
        }

        .profile-content {
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        /* Ukuran Font & Avatar Disesuaikan agar Tidak Terlalu Besar */
        .avatar-gradient {
            width: 50px; /* Lebih kecil */
            height: 50px;
            font-size: 1.4rem;
        }

        .teacher-name {
            font-size: 1.4rem; /* Dari 1.8rem */
            margin-bottom: 8px;
        }

        .greeting-box h4 {
            font-size: 0.9rem;
        }

        .teacher-badges {
            justify-content: center;
        }

        .badge-class {
            font-size: 0.75rem;
            padding: 4px 10px; /* Padding badge dikurangi */
            gap: 5px;
        }

        /* Sembunyikan dekorasi agar rapi */
        .hero-decoration {
            display: none;
        }

        /* --- 2. Stats Grid --- */
        .stats-grid-custom {
            gap: 12px; /* Jarak antar kartu diperketat */
            margin-bottom: 20px;
        }

        .stat-card-modern {
            padding: 15px; /* Padding dalam kartu dikurangi */
            flex-direction: row; /* Tetap horizontal agar seimbang */
            justify-content: flex-start; /* Rata kiri */
        }

        .stat-icon-wrapper {
            width: 45px; /* Ikon lebih kecil */
            height: 45px;
            font-size: 1.2rem;
            border-radius: 10px;
        }

        .stat-details h3 {
            font-size: 1.5rem; /* Angka tidak terlalu besar */
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 0.8rem;
        }

        /* --- 3. Content Cards --- */
        .dashboard-content-single {
            gap: 20px;
        }

        .card-header {
            padding: 15px 20px;
        }

        .card-title {
            font-size: 1rem;
        }

        .card-body {
            padding: 20px !important; /* Padding body dikurangi drastis agar tidak terlalu kosong */
        }

        /* Chart Mobile */
        .chart-container {
            gap: 15px;
        }

        .chart-legend {
            flex-wrap: wrap;
            padding: 10px 15px;
            gap: 10px;
        }

        .legend-item {
            font-size: 0.8rem;
        }

        .bar-chart {
            gap: 12px; /* Jarak bar dikurangi */
        }

        .bar-group {
            gap: 12px;
        }

        .bar-label {
            width: 50px;
            font-size: 0.85rem;
        }

        .bar-wrapper {
            height: 12px; /* Tinggi bar diperkecil agar proporsional */
            border-radius: 8px;
        }

        .summary-text {
            font-size: 0.9rem;
            padding-top: 15px;
            margin-top: 15px;
            line-height: 1.5;
        }

        /* --- 4. Info Banner --- */
        .info-banner {
            padding: 15px; /* Banner lebih ramping */
            gap: 15px;
            align-items: flex-start;
        }

        .info-icon {
            width: 32px;
            height: 32px;
            font-size: 1rem;
            margin-top: 2px;
        }

        .info-content h4 {
            font-size: 0.95rem;
        }

        .info-content p {
            font-size: 0.85rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate Progress Bars in Chart
        const bars = document.querySelectorAll('.bar-fill');
        bars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 300);
        });
    });
</script>
@endsection