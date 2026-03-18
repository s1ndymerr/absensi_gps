@extends('layouts.app')

@section('content')
<div class="siswa-absensi-wrapper">

    <!-- Page Header -->
    <div class="page-header-section">
        <div class="header-text">
            <h1 class="main-title">Absensi Siswa Hari Ini</h1>
            <p class="sub-title">Pantau kehadiran dan status absensi seluruh siswa.</p>
        </div>
    </div>

    <!-- Statistics Grid (Modernized Alerts) -->
    <div class="stats-container">
        <!-- 1. Total Siswa -->
        <div class="stat-card-modern">
            <div class="stat-icon-box icon-blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info-box">
                <h3>{{ $totalSiswa }}</h3>
                <p class="stat-desc">Total Siswa</p>
            </div>
        </div>

       <!-- 2. Sudah Absen -->
<div class="stat-card-modern">
    <div class="stat-icon-box icon-green">
        <i class="fas fa-user-check"></i>
    </div>
    <div class="stat-info-box">
        <h3>{{ $sudahAbsen }}</h3>
        <p class="stat-desc">Sudah Absen</p>
       
    </div>
</div>

<!-- 3. Belum Absen -->
<div class="stat-card-modern">
    <div class="stat-icon-box icon-red">
        <i class="fas fa-user-times"></i>
    </div>
    <div class="stat-info-box">
        <h3>{{ $belumAbsen }}</h3>
        <p class="stat-desc">Belum Absen</p>
    </div>
</div>

    </div>

    <!-- Main Content Card -->
    <div class="main-content-card">
        
        <!-- Table Container -->
        @if(count($siswas) > 0)
            <div class="table-container-modern">
                <table class="data-table-modern">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Nama Siswa</th>
                            <th width="15%">Kelas</th>
                            <th width="15%">Jurusan</th>
                            <th width="15%">Status Absensi</th>
                            <th width="10%">Jam Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach ($siswas as $siswa)
                            @php
                                $absen = $siswa->absensis->first();
                            @endphp
                        
                        <tr>
                            <!-- No -->
                            <td class="text-id">{{ $i++ }}</td>
                            
                            <!-- Nama & Avatar -->
                            <td>
                                <div class="user-profile-card">
                                    <!-- Avatar Style disamakan dengan Data Siswa (Ungu/Indigo) -->
                                    <div class="avatar-simple avatar-purple">
                                        {{ substr($siswa->name, 0, 1) }}
                                    </div>
                                    <div class="user-info-text">
                                        <h4 class="name-text">{{ $siswa->name }}</h4>
                                    </div>
                                </div>
                            </td>

                            <!-- Kelas -->
                            <td>
                                <div class="class-info">
                                    <span class="class-name">{{ $siswa->kelas ?? '-' }}</span>
                                </div>
                            </td>

                            <!-- Jurusan -->
                            <td>
                                <div class="class-info">
                                    <span class="jurusan-name">{{ $siswa->jurusan ?? '-' }}</span>
                                </div>
                            </td>

                            <!-- Status -->
                            <td>
                                @if($absen)
                                    <span class="status-pill 
                                        {{ $absen->status === 'hadir' ? 'pill-success' : 
                                           ($absen->status === 'izin' || $absen->status === 'sakit' ? 'pill-warning' : 'pill-danger') }}">
                                        {{ ucfirst($absen->status) }}
                                    </span>
                                @else
                                    <span class="status-pill pill-danger">
                                        Belum Absen
                                    </span>
                                @endif
                            </td>

                            <!-- Jam Masuk -->
                            <td>
                                <span class="time-text">
                                    <i class="far fa-clock text-muted-icon"></i> 
                                    {{ $absen?->jam_masuk ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <!-- Empty State -->
            <div class="empty-state-modern">
                <div class="empty-icon-circle">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3>Belum Ada Data</h3>
                <p>Sistem belum memiliki data siswa untuk saat ini.</p>
            </div>
        @endif

    </div>

</div>

<style>
    :root {
        /* Palette Identik dengan Dashboard & Data Siswa */
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
        --radius-full: 9999px;
    }

    .siswa-absensi-wrapper {
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* --- Header --- */
    .page-header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-text h1 {
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

    /* --- Stats Grid (Sama dengan Data Guru/Dashboard) --- */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
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
    }

    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon-box {
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

    .icon-blue { background: linear-gradient(135deg, #6366f1, #818cf8); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); }
    .icon-green { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
    .icon-red { background: linear-gradient(135deg, #ef4444, #f87171); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }

    .stat-info-box h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 4px 0;
        color: var(--text-main);
    }

    .stat-desc {
        color: var(--text-muted);
        margin: 0 0 10px 0;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .mini-badge {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
    }

    .success-badge { background: #dcfce7; color: #166534; }
    .neutral-badge { background: #f1f5f9; color: #475569; }

    /* --- Main Card & Table --- */
    .main-content-card {
        background: var(--bg-surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 0;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .table-container-modern {
        overflow-x: auto;
    }

    .data-table-modern {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .data-table-modern th {
        padding: 16px 24px;
        text-align: left;
        font-weight: 700;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--border-soft);
    }

    .data-table-modern td {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        color: var(--text-main);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .data-table-modern tbody tr {
        transition: background 0.2s;
    }

    .data-table-modern tbody tr:hover {
        background: #f8fafc;
    }

    .data-table-modern tr:last-child td {
        border-bottom: none;
    }

    /* --- Table Content Styles (Sama Persis Data Siswa) --- */
    .text-id { color: var(--text-muted); font-family: monospace; }
    
    .user-profile-card {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    /* Avatar Profile (Sesuai Data Siswa) */
    .avatar-simple {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
        /* Default style */
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
    }

    /* Class Khusus untuk Siswa (Ungu) */
    .avatar-purple {
        background: linear-gradient(135deg, #a855f7, #d8b4fe);
    }

    .user-info-text h4 {
        margin: 0;
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-main);
    }

    
    .class-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .class-name { font-weight: 600; font-size: 0.9rem; }
    .jurusan-name { font-size: 0.8rem; color: var(--text-muted); }

    .time-text { color: var(--text-muted); font-size: 0.9rem; display: inline-flex; align-items: center; gap: 5px;}
    .text-muted-icon { color: #cbd5e1; margin-right: 0; font-size: 0.8rem;}

    .status-pill {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }

    .pill-success { background: #dcfce7; color: #166534; }
    .pill-warning { background: #fef3c7; color: #92400e; }
    .pill-danger { background: #fee2e2; color: #991b1b; }

    /* --- Empty State --- */
    .empty-state-modern {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-icon-circle {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        color: #cbd5e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 20px;
    }

    .empty-state-modern h3 {
        color: var(--text-main);
        margin-bottom: 10px;
        font-size: 1.2rem;
    }

    .empty-state-modern p {
        color: var(--text-muted);
        margin-bottom: 25px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* ----------------------------------------------------------------
       ANDROID / MOBILE RESPONSIVE VIEW (SIMPAN & SEIMBANG)
    ---------------------------------------------------------------- */
    @media (max-width: 768px) {
        /* 1. Wrapper & Spacing */
        .siswa-absensi-wrapper {
            padding: 10px;
        }

        /* 2. Header & Stats */
        .page-header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }
        .header-text h1 {
            font-size: 1.4rem;
        }
        .sub-title {
            font-size: 0.85rem;
        }

        .stats-container {
            grid-template-columns: 1fr; /* Stack stats */
            gap: 10px;
            margin-bottom: 20px;
        }
        .stat-card-modern {
            padding: 15px;
        }
        .stat-icon-box {
            width: 40px; height: 40px;
            font-size: 1.2rem;
        }
        .stat-info-box h3 {
            font-size: 1.4rem;
        }
        .stat-desc {
            font-size: 0.8rem;
        }

        /* 3. Main Content */
        .main-content-card {
            background: transparent;
            box-shadow: none;
            border: none;
        }

        /* 4. Table Transform to Simple Cards */
        .table-container-modern {
            display: block;
            overflow: visible;
        }
        
        .data-table-modern thead {
            display: none;
        }

        .data-table-modern, 
        .data-table-modern tbody, 
        .data-table-modern tr {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        /* Card Style (TR) */
        .data-table-modern tr {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px; /* Jarak antar kartu */
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid var(--border-soft);
        }

        /* Hide No */
        .data-table-modern td:nth-child(1) {
            display: none;
        }

        /* Row Style (TD) */
        .data-table-modern td {
            display: flex;
            justify-content: space-between; /* Label Kiri, Nilai Kanan (SEIMBANG) */
            align-items: center;
            border-bottom: 1px solid #f8fafc;
            padding: 8px 0;
            width: 100%;
        }

        .data-table-modern td:last-child {
            border-bottom: none;
        }

        /* --- 1. Header Nama (Tengah) --- */
        .data-table-modern td:nth-child(2) {
            flex-direction: row;
            justify-content: center; /* Center nama dan avatar */
            border-bottom: none;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .user-profile-card {
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }
        .avatar-simple {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }
        .user-info-text h4 {
            font-size: 1rem;
            color: var(--text-main);
        }
       

        /* --- Labels (CSS Generated) --- */
        .data-table-modern td::before {
            content: attr(data-label);
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
        }

        /* Mapping Labels */
        .data-table-modern td:nth-child(3)::before { content: "KELAS"; }
        .data-table-modern td:nth-child(4)::before { content: "JURUSAN"; }
        .data-table-modern td:nth-child(5)::before { content: "STATUS"; }
        .data-table-modern td:nth-child(6)::before { content: "JAM"; }

        /* Hide label for Header */
        .data-table-modern td:nth-child(2)::before {
            display: none;
        }

        /* --- Content Values --- */
        .class-name, .jurusan-name {
            font-size: 0.9rem;
            color: var(--text-main);
            font-weight: 600;
        }

        /* Badge alignment fix */
        .status-pill {
            font-size: 0.75rem;
            padding: 4px 10px;
        }

        .time-text {
            font-size: 0.85rem;
            color: var(--text-main);
            font-weight: 600;
        }
        .text-muted-icon {
            color: #cbd5e1;
            font-size: 0.8rem;
        }

        /* 5. Empty State */
        .empty-state-modern {
            padding: 40px 20px;
        }
        .empty-icon-circle {
            width: 60px; height: 60px;
            font-size: 1.8rem;
        }
    }
</style>
@endsection