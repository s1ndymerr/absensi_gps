@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    
    <!-- Welcome Section (Hero Card Gradient) -->
    <div class="welcome-hero">
        <div class="hero-content">
            <div class="greeting">Halo, Admin!</div>
            <h2 class="dashboard-title">Dashboard E-Absensi</h2>
            <p class="welcome-text">
                Selamat datang kembali di panel admin. Pantau aktivitas guru dan siswa secara <span>real-time</span>.
            </p>
        </div>
        <div class="hero-decoration">
            <i class="fas fa-shield-alt"></i>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="stats-grid">
        <!-- Card 1: Total Guru -->
        <div class="stat-card">
            <div class="stat-icon-wrapper style-blue">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-value">{{ $totalGuru }}</h3>
                <p class="stat-label">Total Guru</p>
                <span class="stat-badge success">
                    <i class="fas fa-arrow-up"></i> {{ $persenGuru }}%
                </span>
            </div>
        </div>

        <!-- Card 2: Total Siswa -->
        <div class="stat-card">
            <div class="stat-icon-wrapper style-purple">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-value">{{ $totalSiswa }}</h3>
                <p class="stat-label">Total Siswa</p>
                <span class="stat-badge success">
                    <i class="fas fa-arrow-up"></i> {{ $persenSiswa }}%
                </span>
            </div>
        </div>

        <!-- Card 3: Kehadiran Hari Ini -->
        <div class="stat-card">
            <div class="stat-icon-wrapper style-green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-value">{{ $hadirHariIni }}</h3>
                <p class="stat-label">Hadir Hari Ini</p>
                
                @php
                    $progressHadir = $totalSiswa > 0 ? round(($hadirHariIni / $totalSiswa) * 100) : 0;
                @endphp
                
                <div class="progress-wrapper">
                    <div class="progress-track">
                        <div class="progress-fill-custom" data-width="{{ $progressHadir }}%"></div>
                    </div>
                    <span class="progress-text">{{ $progressHadir }}%</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Tanggal Hari Ini -->
        <div class="stat-card">
            <div class="stat-icon-wrapper style-orange">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-value">{{ now()->format('d') }}</h3>
                <p class="stat-label">{{ now()->format('F') }}</p>
                <span class="stat-badge neutral">
                    <i class="far fa-clock"></i> {{ now()->format('H:i') }} WIB
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="main-grid">
        <!-- Left Column: Chart & Late Students -->
        <div class="content-column">
            
            <!-- Chart Card -->
            <div class="content-card">
                <div class="card-header-custom">
                    <h3 class="card-heading"><i class="fas fa-chart-bar"></i> Statistik Kehadiran</h3>
                    <!-- Filter Periode: Minggu, Bulan, Tahun -->
                    <form method="GET" id="filterForm">
    <select name="periode" class="custom-select" onchange="document.getElementById('filterForm').submit()">
        <option value="minggu" {{ request('periode') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
        <option value="bulan" {{ request('periode') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
        <option value="tahun" {{ request('periode') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
    </select>
</form>

                </div>
                <div class="card-body">
                    <div class="chart-area">
                        @foreach ($grafikMingguan as $data)
                            @php
                                $persen = $totalSiswa > 0 ? round(($data['jumlah'] / $totalSiswa) * 100) : 0;
                            @endphp
                            <div class="chart-bar-container">
                                <!-- Persentase di atas grafik (Selalu Tampil) -->
                                <div class="bar-percentage">{{ $persen }}%</div>
                                <div class="bar-fill" style="height: {{ $persen }}%;"></div>
                                <div class="bar-tooltip">{{ $data['jumlah'] }} Siswa</div>
                                <span class="bar-label">{{ substr($data['hari'], 0, 3) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Late Students Card -->
            <div class="content-card">
                <div class="card-header-custom">
                    <h3 class="card-heading"><i class="fas fa-exclamation-circle"></i> Siswa Terlambat</h3>
                </div>
                <div class="card-body">
                    @if ($siswaTerlambat->isNotEmpty())
                        <div class="late-list">
                            @foreach ($siswaTerlambat as $item)
                                <div class="late-item">
                                    <div class="late-avatar">
                                        <i class="fas fa-user-clock"></i>
                                    </div>
                                    <div class="late-details">
                                        <p class="late-name">{{ $item->user->name ?? 'Siswa' }}</p>
                                        <span class="late-time">Terlambat: {{ $item->jam_masuk ?? '-' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state-card">
                            <i class="fas fa-smile-beam"></i>
                            <p>Semua siswa tepat waktu hari ini!</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Column: Activity & Quick Links -->
        <div class="sidebar-column">
            
            <!-- Recent Activity Card -->
            <div class="content-card">
                <div class="card-header-custom">
                    <h3 class="card-heading"><i class="fas fa-history"></i> Aktivitas Terbaru</h3>
                </div>
                <div class="card-body">
                    @forelse ($aktivitasTerbaru as $aktivitas)
                        <div class="activity-item">
                            <div class="activity-dot {{ $aktivitas->status == 'hadir' ? 'bg-success' : 'bg-warning' }}"></div>
                            <div class="activity-text">
                                <p>{{ $aktivitas->user->name ?? 'User' }}</p>
                                <span class="time-ago">{{ $aktivitas->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-simple">
                            <p>Belum ada aktivitas.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Links Card -->
            <div class="content-card">
                <div class="card-header-custom">
                    <h3 class="card-heading"><i class="fas fa-rocket"></i> Menu Cepat</h3>
                </div>
                <div class="card-body">
                    <div class="quick-menu">
                        <a href="{{ url('/admin/guru') }}" class="quick-item">
                            <div class="quick-icon bg-indigo"><i class="fas fa-chalkboard-teacher"></i></div>
                            <span>Data Guru</span>
                        </a>
                        <a href="{{ url('/admin/siswa') }}" class="quick-item">
                            <div class="quick-icon bg-pink"><i class="fas fa-user-graduate"></i></div>
                            <span>Data Siswa</span>
                        </a>
                        <a href="{{ url('/admin/lokasi') }}" class="quick-item">
                            <div class="quick-icon bg-orange"><i class="fas fa-map-marker-alt"></i></div>
                            <span>Lokasi GPS</span>
                        </a>
                        <a href="{{ url('/admin/rekap-absensi') }}" class="quick-item">
                            <div class="quick-icon bg-blue"><i class="fas fa-clipboard-list"></i></div>
                            <span>Laporan Absen</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* --- Variables & Reset --- */
    :root {
        --primary-soft: #6366f1;
        --bg-body: #f1f5f9;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --card-bg: #ffffff;
        --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        --radius-md: 12px;
        --radius-lg: 16px;
    }

    .dashboard-container {
        max-width: 100%;
        padding: 0;
        color: var(--text-main);
    }

    /* --- Welcome Hero Section --- */
    .welcome-hero {
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
    }
    
    .welcome-hero::before {
        content: '';
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

    .greeting {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .dashboard-title {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .welcome-text {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
        max-width: 500px;
        line-height: 1.5;
    }

    .welcome-text span {
        font-weight: 700;
        color: #fef08a;
    }

    .hero-decoration {
        font-size: 8rem;
        opacity: 0.15;
        position: absolute;
        right: 20px;
        bottom: -20px;
        transform: rotate(-15deg);
    }

    /* --- Stats Grid --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--card-bg);
        padding: 24px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(255,255,255,0.5);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
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

    .style-blue { background: linear-gradient(135deg, #6366f1, #818cf8); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); }
    .style-purple { background: linear-gradient(135deg, #a855f7, #d8b4fe); box-shadow: 0 4px 12px rgba(168, 85, 247, 0.3); }
    .style-green { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
    .style-orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }

    .stat-info {
        flex: 1;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 4px 0;
        color: var(--text-main);
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0 0 10px 0;
        font-weight: 500;
    }

    .stat-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-badge.success { background: #dcfce7; color: #166534; }
    .stat-badge.neutral { background: #f1f5f9; color: #475569; }

    /* Progress Bar in Stats */
    .progress-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .progress-track {
        flex: 1;
        height: 6px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-fill-custom {
        height: 100%;
        background: var(--primary-soft);
        width: 0%; 
        border-radius: 10px;
        transition: width 1s ease-out;
    }
    .progress-text {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-muted);
        min-width: 35px;
        text-align: right;
    }

    /* --- Main Grid Layout --- */
    .main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
    }

    /* --- Content Cards --- */
    .content-card {
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        padding: 24px;
        margin-bottom: 25px;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .card-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .card-heading {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-heading i {
        color: var(--primary-soft);
        font-size: 0.9rem;
        background: #e0e7ff;
        padding: 8px;
        border-radius: 8px;
    }

    .custom-select {
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        color: var(--text-muted);
        font-size: 0.85rem;
        background: white;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .custom-select:hover {
        border-color: var(--primary-soft);
        color: var(--primary-soft);
    }

    /* --- Chart Styling --- */
    .chart-area {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        height: 220px;
        padding-top: 30px;
    }

    .chart-bar-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        height: 100%;
        justify-content: flex-end;
        position: relative;
    }

    .bar-percentage {
        margin-bottom: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--primary-soft);
        z-index: 2;
    }

    .bar-fill {
        width: 30px;
        background: linear-gradient(180deg, #818cf8, #6366f1);
        border-radius: 6px 6px 0 0;
        transition: height 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        cursor: pointer;
    }
    
    .bar-fill:hover {
        opacity: 0.8;
    }

    .bar-tooltip {
        position: absolute;
        top: -30px;
        background: #1e293b;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
        white-space: nowrap;
        z-index: 10;
    }

    .chart-bar-container:hover .bar-tooltip {
        opacity: 1;
        top: -35px;
    }

    .bar-label {
        margin-top: 10px;
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    /* --- Late Students List --- */
    .late-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .late-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px;
        background: #fff7ed; 
        border-radius: 12px;
        border-left: 4px solid #f97316;
        transition: transform 0.2s;
    }
    
    .late-item:hover {
        transform: translateX(5px);
    }

    .late-avatar {
        width: 36px;
        height: 36px;
        background: #ffedd5;
        color: #c2410c;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .late-name {
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0;
        color: var(--text-main);
    }

    .late-time {
        font-size: 0.75rem;
        color: #c2410c;
    }

    /* --- Recent Activity --- */
    .activity-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .activity-item:last-child { border-bottom: none; }

    .activity-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    .bg-success { background: #10b981; }
    .bg-warning { background: #f59e0b; }

    .activity-text p {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-main);
    }
    .time-ago {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    /* --- Quick Links --- */
    .quick-menu {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .quick-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 18px 10px;
        background: #f8fafc;
        border-radius: 12px;
        text-decoration: none;
        color: var(--text-main);
        transition: all 0.3s;
        border: 1px solid transparent;
    }

    .quick-item:hover {
        background: white;
        border-color: #e2e8f0;
        transform: translateY(-3px);
        box-shadow: var(--shadow-soft);
    }

    .quick-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }

    .bg-indigo { background: #6366f1; }
    .bg-pink { background: #ec4899; }
    .bg-orange { background: #f97316; }
    .bg-blue { background: #3b82f6; }

    .quick-item span {
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
    }

    /* --- Empty States --- */
    .empty-state-card {
        text-align: center;
        padding: 30px 10px;
        color: var(--text-muted);
    }
    .empty-state-card i {
        font-size: 2.5rem;
        color: #10b981;
        margin-bottom: 10px;
        display: block;
    }
    .empty-state-simple p {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.9rem;
        padding: 10px;
    }

    /* --- Responsive (Desktop/Tablet) --- */
    @media (max-width: 992px) {
        .main-grid {
            grid-template-columns: 1fr;
        }
        .sidebar-column {
            order: -1;
        }
        .welcome-hero {
            flex-direction: column;
            align-items: flex-start;
        }
        .hero-decoration {
            right: -20px;
            bottom: -10px;
            font-size: 6rem;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .quick-menu {
            grid-template-columns: 1fr;
        }
        .dashboard-title {
            font-size: 1.5rem;
        }
        .welcome-text {
            font-size: 0.9rem;
        }
    }

    /* =========================================
       ANDROID MOBILE APP OPTIMIZATION (BALANCED)
       ========================================= */
    @media (max-width: 768px) {
        
        /* 1. General App Feel */
        body {
            -webkit-tap-highlight-color: transparent;
            -webkit-font-smoothing: antialiased;
        }

        .dashboard-container {
            padding: 0 0 80px 0;
        }

        /* 2. Welcome Hero */
        .welcome-hero {
            border-radius: 0 0 24px 24px;
            padding: 24px 20px;
            margin-bottom: 24px;
            min-height: 160px;
            justify-content: center;
        }

        .hero-decoration {
            display: none;
        }

        .dashboard-title {
            font-size: 1.6rem;
        }

        /* 3. Stats Grid (SEIMBANG 2x2) */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Paksa 2 kolom */
            gap: 12px;
            padding: 0 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            flex-direction: column; /* Ikon di atas, teks di bawah */
            text-align: center;
            padding: 20px 12px;
            gap: 10px;
            /* Pastikan tinggi kartu seragam */
            align-items: center; 
            justify-content: center;
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            font-size: 1.2rem;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .stat-label {
            font-size: 0.75rem;
        }

        .stat-badge, .progress-wrapper {
            width: 100%;
            justify-content: center;
            margin-top: 5px;
        }

        /* 4. Layout Utama */
        .main-grid {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 0 16px;
        }

        .sidebar-column {
            order: -1;
        }

        .content-card {
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 16px;
        }

        /* 5. Chart (Scroll Horizontal) */
        .chart-area {
            overflow-x: auto;
            justify-content: flex-start;
            padding-bottom: 10px;
            scrollbar-width: none; 
            -ms-overflow-style: none;
        }
        .chart-area::-webkit-scrollbar { 
            display: none; 
        }

        .chart-bar-container {
            min-width: 45px;
            margin-right: 12px;
        }

        .bar-percentage {
            font-size: 0.75rem;
        }

        /* 6. Menu Cepat (Grid 2x2 untuk kesan seimbang) */
        .quick-menu {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 kolom agar seimbang dengan ikon */
            gap: 12px;
        }

        .quick-item {
            background: transparent;
            padding: 15px 10px;
            border: none;
            box-shadow: none;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
        }

        .quick-item:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-soft);
            border-color: var(--primary-soft);
        }

        .quick-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        .quick-item span {
            font-size: 0.8rem;
            color: var(--text-main);
        }

        /* 7. List Items */
        .late-item, .activity-item {
            padding: 12px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate Progress Bars in Stats Cards
        document.querySelectorAll('.progress-fill-custom').forEach(bar => {
            const targetWidth = bar.getAttribute('data-width');
            setTimeout(() => {
                bar.style.width = targetWidth;
            }, 300);
        });

        // Animate Chart Bars (Growth effect from bottom)
        const bars = document.querySelectorAll('.bar-fill');
        bars.forEach(bar => {
            const targetHeight = bar.style.height;
            bar.style.height = '0%';
            setTimeout(() => {
                bar.style.height = targetHeight;
            }, 100);
        });
    });
</script>
@endsection