@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="riwayat-wrapper">

    <!-- Header Section -->
    <div class="page-header-section">
        <div class="header-left">
            <h1 class="main-title">Riwayat Absensi</h1>
            <p class="sub-title">Pantau riwayat kehadiran Anda secara lengkap.</p>
        </div>
        <div class="header-right">
            <a href="{{ route('guru.absen') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Info Banner (Modernized Alert) -->
    <div class="info-banner-card">
        <div class="info-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="info-content">
            <h4>Informasi Sistem</h4>
            <p>Jika ada perbedaan data atau kesalahan pada riwayat, silakan hubungi administrator sistem.</p>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="main-content-card">
        
        <!-- Toolbar (Legend) -->
        <div class="toolbar-section">
            <div class="legend-group">
                <span class="legend-item"><span class="dot dot-success"></span> Hadir</span>
                <span class="legend-item"><span class="dot dot-warning"></span> Izin</span>
                <span class="legend-item"><span class="dot dot-danger"></span> Sakit</span>
            </div>
        </div>

        <!-- Data Table -->
        @if($absensi->count() > 0)
            <div class="table-container-modern">
                <table class="data-table-modern">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Tanggal Absen</th>
                            <th width="10%">Status</th>
                            <th width="15%">Jam Masuk</th>
                            <th width="15%">Jam Pulang</th>
                            <th width="35%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $a)
                            <tr>
                                <!-- Nomor -->
                                <td class="text-id">{{ $loop->iteration }}</td>
                                
                                <!-- Tanggal & Hari -->
                                <td>
                                    <div class="date-display">
                                        <span class="date-text">{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</span>
                                        <span class="day-text">{{ \Carbon\Carbon::parse($a->tanggal)->format('l') }}</span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td>
                                    @if($a->status == 'hadir')
                                        <span class="status-pill pill-success">Hadir</span>
                                    @elseif($a->status == 'izin')
                                        <span class="status-pill pill-warning">Izin</span>
                                    @else
                                        <span class="status-pill pill-danger">Sakit</span>
                                    @endif
                                </td>

                                <!-- Jam Masuk -->
                                <td>
                                    <div class="time-cell">
                                        <i class="far fa-clock text-muted-icon"></i>
                                        {{ $a->jam_masuk ?? '-' }}
                                    </div>
                                </td>

                                <!-- Jam Pulang -->
                                <td>
                                    <div class="time-cell">
                                        <i class="fas fa-sign-out-alt text-muted-icon"></i>
                                        {{ $a->jam_pulang ?? '-' }}
                                    </div>
                                </td>

                                <!-- Keterangan -->
                                <td>
                                    <span class="keterangan-text">
                                        {{ $a->alasan ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty State -->
                            <tr>
                                <td colspan="6" class="empty-cell">
                                    <div class="empty-state-modern">
                                        <div class="empty-icon-circle">
                                            <i class="fas fa-history"></i>
                                        </div>
                                        <h3>Belum Ada Data</h3>
                                        <p>Riwayat absensi Anda masih kosong.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Laravel Standard) -->
            @if(method_exists($absensi, 'links'))
                <div class="pagination-modern">
                    <div class="page-info-text">
                        Menampilkan {{ $absensi->firstItem() }} hingga {{ $absensi->lastItem() }} dari total {{ $absensi->total() }} data
                    </div>
                    <div class="pagination-links">
                        {{ $absensi->links() }}
                    </div>
                </div>
            @endif

        @else
            <!-- Empty State Global -->
            <div class="empty-state-modern">
                <div class="empty-icon-circle">
                    <i class="fas fa-history"></i>
                </div>
                <h3>Belum Ada Data</h3>
                <p>Sistem belum memiliki riwayat absensi Anda.</p>
            </div>
        @endif

    </div>

</div>

<style>
    :root {
        /* Identik dengan Halaman Lain */
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

        /* Radius */
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-full: 9999px;
    }

    .riwayat-wrapper {
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

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        text-decoration: none;
        background: white;
        color: var(--text-muted);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-soft);
    }

    .btn-back:hover {
        border-color: var(--primary-soft);
        color: var(--primary-soft);
        background: #f8fafc;
    }

    /* --- Info Banner Card --- */
    .info-banner-card {
        background: #eff6ff; /* Light Blue background */
        border: 1px solid #bfdbfe;
        border-left: 5px solid var(--color-info);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: #dbeafe;
        color: var(--color-info);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .info-content h4 {
        margin: 0 0 5px 0;
        color: #1e40af;
        font-size: 1rem;
    }
    .info-content p {
        margin: 0;
        color: #1e3a8a;
        font-size: 0.9rem;
    }

    /* --- Main Card --- */
    .main-content-card {
        background: var(--bg-surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 0;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
    }

    /* --- Toolbar --- */
    .toolbar-section {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-soft);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
    }

    .legend-group {
        display: flex;
        gap: 20px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-main);
    }
    .dot { width: 8px; height: 8px; border-radius: 50%; }
    .dot-success { background: var(--color-success); }
    .dot-warning { background: var(--color-warning); }
    .dot-danger { background: var(--color-danger); }

    /* --- Table Styling (Sama Persis Data Siswa) --- */
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

    /* Table Content */
    .text-id { color: var(--text-muted); font-family: monospace; font-weight: 700; }
    
    .date-display {
        display: flex;
        flex-direction: column;
    }
    .date-text {
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 2px;
    }
    .day-text {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 500;
    }

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

    .time-cell {
        color: var(--text-muted);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .text-muted-icon { color: #cbd5e1; font-size: 0.8rem; }

    .keterangan-text {
        color: var(--text-main);
        font-size: 0.95rem;
    }

    /* --- Pagination (Modernized for Laravel Links) --- */
    .pagination-modern {
        padding: 20px 24px;
        border-top: 1px solid var(--border-soft);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
    }

    .page-info-text {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .pagination-links {
        display: flex;
        gap: 6px;
    }

    /* Style Laravel Pagination Links */
    .pagination-links a, .pagination-links span {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid var(--border-soft);
        background: white;
        color: var(--text-main);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .pagination-links a:hover {
        border-color: var(--primary-soft);
        color: var(--primary-soft);
    }

    .pagination-links li.active span {
        background: var(--primary-soft);
        color: white;
        border-color: var(--primary-soft);
        font-weight: 600;
    }

    .pagination-links li.disabled span {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f8fafc;
    }
    
    /* Fix list style for pagination */
    .pagination-links ul {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 5px;
    }

    /* --- Empty State --- */
    .empty-cell {
        padding: 0; /* Override default td padding */
    }
    
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
       ANDROID / MOBILE RESPONSIVE VIEW (SEIMBANG & KOMPAK)
    ---------------------------------------------------------------- */
    @media (max-width: 768px) {
        /* 1. Wrapper & Spacing */
        .riwayat-wrapper {
            padding: 10px; /* Padding minimal */
        }

        /* 2. Header Compact */
        .page-header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .header-left h1 {
            font-size: 1.4rem;
        }

        .sub-title {
            font-size: 0.85rem;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
            padding: 10px;
        }

        /* 3. Info Banner Compact */
        .info-banner-card {
            padding: 12px 15px;
            gap: 12px;
            flex-direction: row;
            align-items: flex-start;
        }

        .info-icon {
            width: 32px; height: 32px;
            font-size: 1rem;
        }

        .info-content h4 { font-size: 0.9rem; margin-bottom: 2px; }
        .info-content p { font-size: 0.8rem; line-height: 1.4; }

        /* 4. Main Card Layout */
        .main-content-card {
            border-radius: 16px;
            box-shadow: none; /* Flat look for cards */
            border: none;
            background: transparent;
        }

        .toolbar-section {
            background: transparent;
            border: none;
            padding: 0 0 10px 0;
            display: flex;
        }
        .legend-group {
            width: 100%;
            justify-content: space-around;
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-soft);
        }
        .legend-item {
            font-size: 0.75rem;
            flex-direction: column;
            gap: 4px;
        }

        /* 5. Table Transform to Cards */
        .table-container-modern {
            display: block;
            overflow: visible;
        }

        .data-table-modern thead {
            display: none;
        }

        .data-table-modern, 
        .data-table-modern tbody, 
        .data-table-modern tr, 
        .data-table-modern td {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        /* Card Styling (TR) */
        .data-table-modern tr {
            background: white;
            margin-bottom: 12px; /* Jarak kartu */
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            overflow: hidden;
            border: 1px solid var(--border-soft);
        }

        /* Hide Column 1 (No) */
        .data-table-modern td:nth-child(1) {
            display: none;
        }

        /* Cell Styling (TD) */
        .data-table-modern td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #f8fafc;
            min-height: 40px;
        }

        .data-table-modern td:last-child {
            border-bottom: none;
            padding-bottom: 12px;
        }

        /* Labels */
        .data-table-modern td::before {
            content: attr(data-label);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            text-align: left;
        }

        /* Set Content based on Column Index */
        .data-table-modern td:nth-child(2)::before { content: "TANGGAL"; }
        .data-table-modern td:nth-child(3)::before { content: "STATUS"; }
        .data-table-modern td:nth-child(4)::before { content: "MASUK"; }
        .data-table-modern td:nth-child(5)::before { content: "PULANG"; }
        .data-table-modern td:nth-child(6)::before { content: "KET."; }

        /* Content Specifics */
        
        /* Date (Header Style in Card) */
        .data-table-modern td:nth-child(2) {
            background: #f8fafc;
            padding: 12px 15px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
        }
        .data-table-modern td:nth-child(2)::before {
            margin-bottom: 4px;
        }
        .date-text {
            font-size: 0.9rem; /* Font kecil tapi jelas */
        }
        .day-text {
            font-size: 0.75rem;
        }

        /* Status Badge */
        .status-pill {
            padding: 4px 10px;
            font-size: 0.75rem;
            border-radius: 12px;
        }

        /* Time Cells */
        .time-cell {
            font-size: 0.8rem;
            gap: 6px;
        }
        .text-muted-icon {
            font-size: 0.7rem;
        }

        /* Keterangan Text */
        .keterangan-text {
            font-size: 0.8rem;
            line-height: 1.4;
            text-align: right;
        }

        /* 6. Pagination */
        .pagination-modern {
            background: transparent;
            border: none;
            flex-direction: column;
            gap: 15px;
            padding: 20px 0;
        }

        .pagination-links ul {
            width: 100%;
            justify-content: center;
        }

        .pagination-links a, .pagination-links span {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }
    }
</style>
@endsection