@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="riwayat-wrapper">

    <!-- Page Header -->
    <div class="page-header-section">
        <div class="header-text">
            <h1 class="main-title">Riwayat Absensi</h1>
            <p class="sub-title">Pantau riwayat kehadiran siswa secara lengkap.</p>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="main-content-card">
        
        <!-- Toolbar -->
        <div class="toolbar-section">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Cari nama atau tanggal..." id="searchInput" class="search-input-modern">
            </div>
        </div>

        <!-- Data Table -->
        @if(count($riwayat) > 0)
            <div class="table-container-modern">
                <table class="data-table-modern" id="riwayatTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Nama Siswa</th>
                            <th width="10%">Kelas</th>
                            <th width="20%">Tanggal Absen</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $index => $absen)
                            <tr>
                                <!-- Nomor -->
                                <td class="text-id">{{ $index + 1 }}</td>
                                
                                <!-- Nama & Avatar -->
                                <td>
                                    <div class="user-profile-card">
                                        <div class="avatar-simple avatar-purple">
                                            {{ substr($absen->user->name, 0, 1) }}
                                        </div>
                                        <div class="user-info-text">
                                            <h4 class="name-text">{{ $absen->user->name }}</h4>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kelas -->
                                <td>
                                    <span class="class-name">{{ $absen->siswa->kelas ?? '-' }}</span>
                                </td>

                                <!-- Tanggal -->
                                <td>
                                    <div class="date-display">
                                        <span class="date-text">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</span>
                                        <span class="day-text">{{ \Carbon\Carbon::parse($absen->tanggal)->format('l') }}</span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td>
                                    @if($absen->status === 'hadir')
                                        <span class="status-pill pill-success">Hadir</span>
                                    @elseif($absen->status === 'izin')
                                        <span class="status-pill pill-warning">Izin</span>
                                    @elseif($absen->status === 'sakit')
                                        <span class="status-pill pill-danger">Sakit</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($riwayat, 'links'))
                <div class="pagination-modern">
                    <div class="page-info-text">
                        Menampilkan {{ $riwayat->firstItem() }} hingga {{ $riwayat->lastItem() }} dari total {{ $riwayat->total() }} data
                    </div>
                    <div class="pagination-links">
                        {{ $riwayat->links() }}
                    </div>
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="empty-state-modern">
                <div class="empty-icon-circle">
                    <i class="fas fa-history"></i>
                </div>
                <h3>Belum Ada Data</h3>
                <p>Riwayat absensi masih kosong.</p>
            </div>
        @endif

    </div>

</div>

<style>
    :root {
        /* Warna Dasar */
        --primary-soft: #6366f1;
        --primary-dark: #4f46e5;
        --secondary-soft: #a855f7;
        --bg-body: #f3f4f6;
        --bg-surface: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-soft: #e2e8f0;
        
        /* Status Colors */
        --bg-success: #dcfce7;
        --text-success: #166534;
        --bg-warning: #fef3c7;
        --text-warning: #92400e;
        --bg-danger: #fee2e2;
        --text-danger: #991b1b;
        
        /* Shadows & Radius */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        --radius-lg: 16px;
        --radius-md: 10px;
    }

    /* --- Reset & Base Layout --- */
    .riwayat-wrapper {
        padding: 0;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    /* --- Header --- */
    .page-header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-text h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 5px 0;
        letter-spacing: -0.5px;
    }
    .sub-title { color: var(--text-muted); margin: 0; font-size: 0.9rem; }

    /* --- Main Card --- */
    .main-content-card {
        background: var(--bg-surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(0,0,0,0.02);
        overflow: hidden;
    }

    /* --- Toolbar --- */
    .toolbar-section {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-soft);
        display: flex;
        justify-content: space-between;
        background: #fff;
    }

    .search-wrapper {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .search-input-modern {
        width: 100%;
        padding: 11px 15px 11px 40px;
        border: 1px solid var(--border-soft);
        border-radius: 10px;
        font-size: 0.95rem;
        background: #f8fafc;
    }
    .search-input-modern:focus {
        outline: none;
        border-color: var(--primary-soft);
        background: white;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* --- Desktop Table Styling --- */
    .table-container-modern { overflow-x: auto; }
    
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

    .data-table-modern tbody tr:hover { background: #f8fafc; }
    .data-table-modern tr:last-child td { border-bottom: none; }

    /* Desktop Specifics */
    .user-profile-card { display: flex; align-items: center; gap: 15px; }
    .avatar-simple {
        width: 36px; height: 36px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: 0.9rem;
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
    }
    .avatar-purple { background: linear-gradient(135deg, #a855f7, #d8b4fe); }
    .user-info-text h4 { margin: 0; font-weight: 600; font-size: 0.95rem; color: var(--text-main); }
    
    .date-display { display: flex; flex-direction: column; gap: 2px; }
    .date-text { font-weight: 600; font-size: 0.9rem; color: var(--text-main); }
    .day-text { font-size: 0.75rem; color: var(--text-muted); font-weight: 500; }

    /* --- Status Pills (Global) --- */
    .status-pill {
        padding: 6px 12px; border-radius: 20px; font-size: 0.8rem;
        font-weight: 600; display: inline-block;
    }
    .pill-success { background: var(--bg-success); color: var(--text-success); }
    .pill-warning { background: var(--bg-warning); color: var(--text-warning); }
    .pill-danger  { background: var(--bg-danger); color: var(--text-danger); }

    .class-name { font-weight: 600; font-size: 0.9rem; color: var(--text-main); }

    /* Pagination */
    .pagination-modern {
        padding: 20px 24px;
        border-top: 1px solid var(--border-soft);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
    }
    .pagination-links ul { display: flex; list-style: none; padding: 0; margin: 0; gap: 5px; }
    .pagination-links a, .pagination-links span {
        width: 36px; height: 36px; border-radius: 8px; border: 1px solid var(--border-soft);
        background: white; color: var(--text-main); display: flex;
        align-items: center; justify-content: center; text-decoration: none;
        font-size: 0.9rem; transition: all 0.2s;
    }
    .pagination-links a:hover { border-color: var(--primary-soft); color: var(--primary-soft); }
    .pagination-links li.active span { background: var(--primary-soft); color: white; border-color: var(--primary-soft); font-weight: 600; }
    .pagination-links li.disabled span { opacity: 0.5; cursor: not-allowed; background: #f8fafc; }
    .page-info-text { color: var(--text-muted); font-size: 0.9rem; }

    /* Empty State */
    .empty-state-modern { text-align: center; padding: 80px 20px; }
    .empty-icon-circle { width: 80px; height: 80px; background: #f1f5f9; color: #cbd5e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 20px; }

    /* =========================================================
       MOBILE / ANDROID STYLE (Avatar Ungu, Kelas Biru, Status Pastel)
    ========================================================= */
    @media (max-width: 768px) {
        
        /* 1. Layout Wrapper */
        .riwayat-wrapper { padding: 10px; }
        .main-content-card { background: transparent; box-shadow: none; border: none; }
        
        /* 2. Header & Toolbar Compact */
        .page-header-section { margin-bottom: 15px; align-items: flex-start; }
        .header-text h1 { font-size: 1.4rem; }
        .sub-title { font-size: 0.85rem; }
        .toolbar-section { padding: 10px 0; border: none; }
        .search-wrapper { max-width: 100%; }

        /* 3. TABLE TO CARD TRANSFORMATION */
        .data-table-modern, .data-table-modern tbody, .data-table-modern tr, .data-table-modern td {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .data-table-modern thead { display: none; }
        .data-table-modern td:nth-child(1) { display: none; }

        /* 4. CARD DESIGN */
        .data-table-modern tr {
            background: white;
            margin-bottom: 16px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            position: relative;
            padding: 20px; 
        }

        /* 5. ELEMENTS INSIDE CARD */
        .data-table-modern td {
            padding: 0;
            margin-bottom: 8px; 
            width: 100%;
            text-align: left;
            font-size: 1rem; 
        }

        /* --- Avatar TAMPIL (Ungu) --- */
        .avatar-simple { 
            display: flex !important;
            width: 32px; height: 32px;
            font-size: 0.85rem;
        }
        .user-profile-card { gap: 12px; }

        /* --- Nama Siswa --- */
        .data-table-modern td:nth-child(2) { 
            margin-bottom: 12px; 
            padding-right: 80px; /* Space untuk status melayang */
            border-bottom: 1px solid #f0f0f0; 
            padding-bottom: 10px;
        }
        .user-info-text h4 { font-size: 1.1rem; font-weight: 700; color: #222; margin: 0; }

        /* --- Kelas (BADGE BIRU) --- */
        .data-table-modern td:nth-child(3) { margin-bottom: 10px; }
        .class-name { 
            display: inline-block; /* Bentuk kotak */
            background: #e0e7ff; /* Background Biru Muda */
            color: #4338ca;     /* Teks Biru Tua */
            font-weight: 700; 
            font-size: 0.8rem; 
            padding: 4px 12px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* --- Tanggal --- */
        .data-table-modern td:nth-child(4) { margin-bottom: 15px; }
        .date-display { flex-direction: row; gap: 8px; align-items: baseline; }
        .date-text { font-size: 1.1rem; font-weight: 800; color: #333; }
        .day-text { font-size: 0.9rem; color: #666; font-weight: 500; }

        /* --- Status Badge (Floating Top Right) --- */
        .data-table-modern td:nth-child(5) {
            position: absolute;
            top: 20px;
            right: 20px;
            margin: 0;
            padding: 0;
            width: auto;
            text-align: right;
        }
        
        .status-pill {
            font-size: 0.8rem;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 700;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* 6. Pagination Mobile */
        .pagination-modern {
            flex-direction: column;
            padding: 20px 0;
            gap: 15px;
            background: transparent;
        }
        .pagination-links ul { width: 100%; justify-content: center; }
        .pagination-links a, .pagination-links span { width: 34px; height: 34px; font-size: 0.85rem; }
        
        /* 7. Empty State Mobile */
        .empty-state-modern { padding: 40px 20px; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search Logic
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('#riwayatTable tbody tr');
        
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const term = this.value.toLowerCase();
                rows.forEach(row => {
                    const name = row.querySelector('.name-text').textContent.toLowerCase();
                    const kelas = row.querySelector('.class-name').textContent.toLowerCase();
                    const date = row.querySelector('.date-text').textContent.toLowerCase();
                    const status = row.querySelector('.status-pill').textContent.toLowerCase();
                    
                    if (name.includes(term) || kelas.includes(term) || date.includes(term) || status.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection