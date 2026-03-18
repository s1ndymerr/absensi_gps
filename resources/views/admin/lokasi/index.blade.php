@extends('layouts.app')

@section('content')
<div class="lokasi-page-wrapper">

    <!-- Header Section -->
    <div class="page-header-section">
        <div class="header-text">
            <h1 class="main-title">Titik Lokasi GPS</h1>
            <p class="sub-title">Kelola koordinat geografis untuk zona wajib absensi.</p>
        </div>
        <div class="header-action">
            <a href="{{ route('admin.lokasi.create') }}" class="btn btn-primary-gradient">
                <i class="fas fa-map-marked-alt"></i>
                <span>Tambah Lokasi</span>
            </a>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="stats-container">
        <div class="stat-card-modern" style="grid-column: span 2;">
            <div class="stat-icon-box icon-purple">
                <i class="fas fa-map-pin"></i>
            </div>
            <div class="stat-info-box">
                <h3>{{ count($lokasis) }}</h3>
                <p class="stat-desc">Total Titik Lokasi</p>
                <span class="mini-badge neutral-badge">Terdaftar dalam Sistem</span>
            </div>
        </div>
        
        <div class="stat-card-modern">
            <div class="stat-icon-box icon-blue">
                <i class="fas fa-satellite-dish"></i>
            </div>
            <div class="stat-info-box">
                <h3>GPS</h3>
                <p class="stat-desc">Status Sensor</p>
                <span class="mini-badge success-badge">Aktif</span>
            </div>
        </div>
    </div>

    <!-- Main Content: Table -->
    <div class="main-content-card">
        <!-- Toolbar Sederhana -->
        <div class="toolbar-section">
            <div class="page-info-title">
                <i class="fas fa-list text-primary-soft"></i> Daftar Koordinat
            </div>
        </div>

        <!-- Data Table -->
        @if(count($lokasis) > 0)
            <div class="table-container-modern">
                <table class="data-table-modern" id="lokasiTable">
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th width="30%">Nama Lokasi</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lokasis as $index => $lokasi)
                        <tr>
                            <td class="text-id">{{ $index + 1 }}</td>
                            <td>
                                <div class="location-name-box">
                                    <i class="fas fa-map-marker-alt text-primary-soft"></i>
                                    <span class="loc-name">{{ $lokasi->nama_lokasi }}</span>
                                </div>
                            </td>
                            <td>
                                <code class="coord-code">{{ $lokasi->latitude }}</code>
                            </td>
                            <td>
                                <code class="coord-code">{{ $lokasi->longitude }}</code>
                            </td>
                            <td>
                               <form action="{{ route('admin.lokasi.aktif', $lokasi->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn-status-desktop"
                                        style="padding:5px 12px; border-radius:8px; border:none;
                                        background: {{ $lokasi->status == 'aktif' ? '#22c55e' : '#6366f1' }};
                                        color:white; font-weight: 600; font-size: 12px; cursor: pointer;"
                                        {{ $lokasi->status == 'aktif' ? 'disabled' : '' }}>
                                        {{ $lokasi->status == 'aktif' ? 'AKTIF' : 'JADIKAN AKTIF' }}
                                    </button>
                                </form>
                                <div class="action-group">
                                    <!-- Tombol Map -->
                                    <a href="https://maps.google.com/?q={{ $lokasi->latitude }},{{ $lokasi->longitude }}" 
                                       target="_blank" 
                                       class="btn-icon-modern btn-map-soft" 
                                       title="Lihat di Google Maps">
                                        <i class="fas fa-globe"></i>
                                    </a>
                                    
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.lokasi.edit', $lokasi->id) }}" 
                                       class="btn-icon-modern btn-edit-soft" 
                                       title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.lokasi.destroy', $lokasi->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-modern btn-delete-soft" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
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
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3>Belum Ada Lokasi</h3>
                <p>Sistem belum memiliki titik lokasi GPS. Silakan tambahkan lokasi zona absensi.</p>
                <a href="{{ route('admin.lokasi.create') }}" class="btn btn-primary-gradient">
                    <i class="fas fa-plus"></i> Tambah Lokasi
                </a>
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
        
        /* Shadows */
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        
        /* Radius */
        --radius-md: 10px;
        --radius-lg: 16px;
    }

    .lokasi-page-wrapper {
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

    /* --- Buttons --- */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        text-decoration: none;
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
        color: white;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(99, 102, 241, 0.4);
    }

    /* --- Stats Cards --- */
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
        transition: transform 0.3s ease;
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

    .icon-purple { background: linear-gradient(135deg, #a855f7, #d8b4fe); box-shadow: 0 4px 12px rgba(168, 85, 247, 0.3); }
    .icon-blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }

    .stat-info-box h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 4px 0;
        color: var(--text-main);
        line-height: 1.2;
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

    /* --- Main Content --- */
    .main-content-card {
        background: var(--bg-surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 0;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .toolbar-section {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-soft);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .page-info-title {
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .text-primary-soft { color: var(--primary-soft); }

    /* --- Table --- */
    .table-container-modern {
        overflow-x: auto;
    }

    .data-table-modern {
        width: 100%;
        border-collapse: collapse;
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
    .text-id { color: var(--text-muted); font-family: monospace; }

    .location-name-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .loc-name {
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.95rem;
    }

    .coord-code {
        background: #f1f5f9;
        color: #475569;
        padding: 4px 8px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 0.85rem;
    }

    /* --- Action Column Fix (Desktop) --- */
    .data-table-modern td:last-child {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .data-table-modern td form { display: inline-block; margin: 0; }

    .action-group { display: flex; gap: 6px; }

    .btn-icon-modern {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        color: white;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-map-soft { background: #0ea5e9; }
    .btn-map-soft:hover { background: #0284c7; transform: translateY(-2px); }

    .btn-edit-soft { background: #fbbf24; color: #fff; }
    .btn-edit-soft:hover { background: #f59e0b; transform: translateY(-2px); }

    .btn-delete-soft { background: #f43f5e; color: #fff; }
    .btn-delete-soft:hover { background: #e11d48; transform: translateY(-2px); }

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
       ANDROID / MOBILE RESPONSIVE VIEW
    ---------------------------------------------------------------- */
    @media (max-width: 768px) {
        /* 1. Header Layout */
        .page-header-section {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
            text-align: center;
        }
        .header-text h1 { font-size: 1.5rem; }
        .header-action .btn { width: 100%; justify-content: center; }

        /* 2. Stats Layout - PERBAIKAN KESEIMBANGAN GPS */
        .stats-container {
            grid-template-columns: 1fr; /* Stack Vertikal */
            gap: 15px;
        }

        .stat-card-modern {
            padding: 20px;
            min-height: 110px; /* FIX: Paksa tinggi minimal agar seimbang */
            align-items: center; /* Pastikan isi rata tengah vertikal */
        }
        
        /* Hapus style grid-column inline agar ikut aturan baru */
        .stat-card-modern[style*="grid-column: span 2"] {
            grid-column: span 1 !important; 
        }

        /* Spesifik untuk GPS card agar proporsional */
        .stat-card-modern:nth-child(2) .stat-info-box {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .stat-card-modern:nth-child(2) h3 {
            font-size: 1.6rem; /* Ukuran font disesuaikan agar tidak terlalu besar kecilnya */
            margin-bottom: 2px;
        }

        /* 3. Table Transform to Cards */
        .table-container-modern { border: none; background: transparent; box-shadow: none; }
        .data-table-modern thead { display: none; }

        .data-table-modern, .data-table-modern tbody, .data-table-modern tr, .data-table-modern td {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .data-table-modern tr {
            background: white;
            margin-bottom: 16px;
            border: 1px solid var(--border-soft);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .data-table-modern td {
            text-align: right;
            padding: 12px 15px;
            padding-left: 40%; /* Space for label */
            border-bottom: 1px solid #f1f5f9;
            position: relative;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        /* Labels */
        .data-table-modern td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            width: 35%;
            white-space: nowrap;
            font-weight: 700;
            color: var(--text-muted);
            text-align: left;
            font-size: 0.85rem;
        }

        .data-table-modern td:nth-child(1)::before { content: "#"; }
        .data-table-modern td:nth-child(2)::before { content: "Lokasi"; }
        .data-table-modern td:nth-child(3)::before { content: "Latitude"; }
        .data-table-modern td:nth-child(4)::before { content: "Longitude"; }
        .data-table-modern td:nth-child(5)::before { content: "Aksi"; }

        /* Fixes */
        .text-id { width: 100%; text-align: right; font-size: 0.9rem; }
        .location-name-box { justify-content: flex-end; width: 100%; }
        .location-name-box i { margin-left: 8px; order: 2; }
        .location-name-box i:first-child { order: 2; }
        .location-name-box span { order: 1; }
        .coord-code { font-size: 0.9rem; display: inline-block; }

        /* Mobile Action Bar */
        .data-table-modern td:last-child {
            border-bottom: none;
            padding: 15px;
            padding-left: 15px;
            background: #f8fafc;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }
        .data-table-modern td:last-child::before { display: none; }
        .btn-icon-modern { width: 40px; height: 40px; font-size: 1rem; }
        
        .empty-state-modern .btn { width: 100%; justify-content: center; }
    }
</style>
@endsection