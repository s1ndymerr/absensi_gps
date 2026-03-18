@extends('layouts.app')

@section('content')
<div class="guru-page-wrapper">

    <!-- Header Section -->
    <div class="page-header-section">
        <div class="header-text">
            <h1 class="main-title">Data Guru</h1>
            <p class="sub-title">Kelola seluruh data guru dan staf pengajar sekolah.</p>
        </div>
        <div class="header-action">
            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary-gradient">
                <i class="fas fa-plus"></i>
                <span>Tambah Guru</span>
            </a>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="soft-alert success-alert">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-content">
                <strong>Berhasil!</strong>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="stat-card-modern">
            <div class="stat-icon-box icon-blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info-box">
                <h3>{{ $totalGuru }}</h3>
                <p class="stat-desc">Total Guru</p>
            </div>
        </div>

        <div class="stat-card-modern">
            <div class="stat-icon-box icon-green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info-box">
                <h3>{{ $jumlahGuruAktif }}</h3>
                <p class="stat-desc">Guru Aktif</p>
            </div>
        </div>

        <div class="stat-card-modern">
            <div class="stat-icon-box icon-orange">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-info-box">
               <h3>{{ $guruBaru }}</h3>
                <p class="stat-desc">Guru Baru</p>
            </div>
        </div>
    </div>

    <!-- Main Content: Table & Filters -->
    <div class="main-content-card">
        
        <!-- Toolbar (Search & Filter) -->
        <div class="toolbar-section">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Cari nama atau email guru..." id="searchInput" class="search-input-modern">
            </div>
            <form method="GET" action="{{ route('admin.guru.index') }}">
    <div class="filter-group">
        <select name="status" class="custom-select-modern">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        <button type="submit" class="btn btn-outline-soft">
            <i class="fas fa-filter"></i> Filter
        </button>
    </div>
</form>

        </div>

        <!-- Data Table -->
        @if(count($gurus) > 0)
            <!-- Container Table: Margin bawah 0 agar nempel pagination -->
            <div class="table-container-modern">
                <table class="data-table-modern" id="guruTable">
                    <thead>
                        <tr>
<th width="80">No</th>
                            <th width="35%">Informasi Guru</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gurus as $guru)
                        <tr>
<td class="text-id">
    {{ $gurus->firstItem() + $loop->index }}
</td>
                            <td>
                                <div class="user-profile-card">
                                    <div class="avatar-circle avatar-purple">
                                        {{ substr($guru->name, 0, 1) }}
                                    </div>
                                    <div class="user-info-text">
                                        <h4 class="name-text">{{ $guru->name }}</h4>
                                        <span class="user-sub">ID: {{ $guru->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="email-text">
                                <i class="fas fa-envelope text-muted-icon"></i> {{ $guru->email }}
                            </td>
                            <td>
                                <span class="status-pill {{ $guru->status_akun === 'aktif' ? 'pill-success' : 'pill-danger' }}">
                                    {{ $guru->status_akun === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="date-text">
                                <i class="far fa-calendar-alt text-muted-icon"></i> 
                                {{ $guru->created_at->format('d M Y') ?? '-' }}
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn-icon-modern btn-edit-soft" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-modern btn-delete-soft" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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

<!-- Pagination (DISAMAIN DENGAN SISWA) -->
<div class="pagination-modern">
    <div class="page-info-text">
    Menampilkan 
    <strong>{{ $gurus->firstItem() }}</strong>
    –
    <strong>{{ $gurus->lastItem() }}</strong>
    dari 
    <strong>{{ $gurus->total() }}</strong>
    data guru
</div>
    <div class="pagination-links">
        {{ $gurus->links('pagination::bootstrap-4') }}
    </div>
</div>



        @else
            <!-- Empty State -->
            <div class="empty-state-modern">
                <div class="empty-icon-circle">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3>Belum Ada Data</h3>
                <p>Sistem belum memiliki data guru. Silakan tambahkan guru baru untuk memulai.</p>
                <a href="{{ route('admin.guru.create') }}" class="btn btn-primary-gradient">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        @endif

    </div>
</div>

<style>
    :root {
        /* Warna Identik dengan Dashboard */
        --primary-soft: #6366f1;
        --bg-body: #f1f5f9;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --card-bg: #ffffff;
        --border-soft: #e2e8f0;
        
        /* Shadows */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.08);

        /* Radius */
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-full: 9999px;
    }

    .guru-page-wrapper {
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
        background: linear-gradient(135deg, var(--primary-soft), #a855f7);
        color: white;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(99, 102, 241, 0.4);
    }

    .btn-outline-soft {
        background: white;
        color: var(--text-muted);
        border: 1px solid var(--border-soft);
        background: #f8fafc;
    }

    .btn-outline-soft:hover {
        border-color: var(--primary-soft);
        color: var(--primary-soft);
        background: #f1f5f9;
    }

    /* --- Stats Cards --- */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card-modern {
        background: var(--card-bg);
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
    .icon-orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }

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

    /* --- Alert --- */
    .soft-alert {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border-left: 5px solid;
        animation: slideIn 0.4s ease-out;
    }

    .success-alert {
        background: #f0fdf4;
        border-color: #22c55e;
        color: #15803d;
    }

    .alert-icon { font-size: 1.4rem; }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- Main Card & Toolbar --- */
    .main-content-card {
        background: var(--card-bg);
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
        flex-wrap: wrap;
        gap: 15px;
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
        transition: all 0.3s;
        background: #f8fafc;
    }

    .search-input-modern:focus {
        outline: none;
        border-color: var(--primary-soft);
        background: white;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .filter-group {
        display: flex;
        gap: 10px;
    }

    .custom-select-modern {
        padding: 11px 15px;
        border: 1px solid var(--border-soft);
        border-radius: 10px;
        background: white;
        color: var(--text-main);
        font-size: 0.95rem;
        cursor: pointer;
        outline: none;
        transition: all 0.3s;
    }

    /* --- Table Styling --- */
    .table-container-modern {
        overflow-x: auto;
        border-radius: 12px; 
        border: 1px solid var(--border-soft);
        /* PENTING: Margin bawah 0 agar nempel pagination */
        margin: 20px 24px 0 24px; 
        background: #fff;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        /* PENTING: Radius bawah 0 agar menyatu */
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom: none; 
    }

    .data-table-modern {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .data-table-modern thead {
        background-color: #f8fafc;
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
        background-color: #fff;
    }

    .data-table-modern tbody tr {
        transition: background 0.2s;
    }

    .data-table-modern tbody tr:hover {
        background-color: #fdfdfd;
    }
    
    .data-table-modern tr:last-child td {
        border-bottom: none;
    }

    .text-id { color: var(--text-muted); font-family: monospace; }
    
    .user-profile-card {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        background: linear-gradient(135deg, var(--primary-soft), #a855f7);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .avatar-purple {
        background: linear-gradient(135deg, #a855f7, #d8b4fe);
    }

    .user-info-text h4 {
        margin: 0;
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-main);
    }

    .user-sub {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .text-muted-icon { color: #cbd5e1; margin-right: 6px; font-size: 0.8rem; }
    .email-text, .date-text { color: var(--text-muted); font-size: 0.9rem; }

    .status-pill {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }

    .pill-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .pill-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .action-group {
        display: flex;
        gap: 8px;
    }

    .btn-icon-modern {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-edit-soft {
        background: #fbbf24;
        color: #fff;
    }
    .btn-edit-soft:hover { background: #f59e0b; transform: translateY(-2px); }

    .btn-delete-soft {
        background: #f43f5e;
        color: #fff;
    }
    .btn-delete-soft:hover { background: #e11d48; transform: translateY(-2px); }

    /* =========================================
       PERBAIKAN PAGINATION (1 2 3) - SEJAJAR TABEL
       ========================================= */
    
    .pagination-modern {
        /* PENTING: Padding Kiri/Kanan disamakan dengan tabel (24px) */
        padding: 18px 24px; 
        margin: 0;
        border-top: 1px solid var(--border-soft); /* Garis pemisah */
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        /* Radius bawah untuk menutup kartu */
        border-bottom-left-radius: var(--radius-lg);
        border-bottom-right-radius: var(--radius-lg);
    }

    .page-info-text {
        color: var(--text-muted);
        font-size: 0.85rem;
        line-height: 1.5;
    }

    .page-info-text strong {
        color: var(--text-main);
        font-weight: 700;
    }

    /* --- Tombol Angka (1, 2, 3, Next) --- */
    .pagination-links {
        display: flex;
        align-items: center;
    }

    /* Reset UL Laravel */
    .pagination-links ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .pagination-links li {
        display: inline-flex;
    }

    /* Styling Link & Span Tombol */
    .pagination-links a, 
    .pagination-links span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: 8px;
        border: 1px solid var(--border-soft);
        background: white;
        color: var(--text-main);
        text-decoration: none !important;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        user-select: none;
    }

    /* Efek Hover */
    .pagination-links a:hover {
        border-color: var(--primary-soft);
        color: var(--primary-soft);
        background-color: #fefeff;
        box-shadow: 0 4px 6px rgba(99, 102, 241, 0.1);
        transform: translateY(-1px);
    }

    /* Halaman Aktif (Berwarna Ungu) */
    .pagination-links span.active {
        background: linear-gradient(135deg, var(--primary-soft), #a855f7);
        color: white;
        border-color: transparent;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }
    
    /* Halaman Disabled (Abu-abu) */
    .pagination-links span.disabled {
        background: #f8fafc;
        color: #cbd5e1;
        border-color: #f1f5f9;
        cursor: not-allowed;
        box-shadow: none;
    }

    /* --- Empty State --- */
    .empty-state-modern {
        text-align: center;
        padding: 60px 24px; 
        background: #fff;
    }

    .empty-icon-circle {
        width: 90px;
        height: 90px;
        background: #f8fafc;
        color: var(--primary-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.8rem;
        margin: 0 auto 24px;
        border: 2px dashed var(--border-soft);
    }

    .empty-state-modern h3 {
        color: var(--text-main);
        margin-bottom: 10px;
        font-size: 1.25rem;
        font-weight: 700;
    }

    .empty-state-modern p {
        color: var(--text-muted);
        margin-bottom: 30px;
        max-width: 450px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .empty-state-modern .btn {
        padding: 12px 24px;
        font-size: 0.95rem;
    }

    /* --- Responsive Mobile --- */
    @media (max-width: 768px) {
        
        body {
            -webkit-tap-highlight-color: transparent;
            -webkit-font-smoothing: antialiased;
        }

        .guru-page-wrapper {
            padding: 0 0 80px 0;
        }

        .page-header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
            padding: 0 16px;
        }

        .header-action {
            width: 100%;
        }

        .header-action .btn {
            width: 100%;
            justify-content: center;
            padding: 12px;
        }

        /* Stats Mobile */
        .stats-container {
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            padding: 0 16px;
            margin-bottom: 24px;
        }

        .stat-card-modern {
            flex-direction: column; 
            text-align: center;
            padding: 12px 4px; 
            gap: 10px; 
            align-items: center;
            justify-content: center;
        }

        .stat-icon-box {
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
            border-radius: 10px;
        }

        .stat-info-box h3 {
            font-size: 1.1rem; 
            margin: 0;
            line-height: 1.2;
        }

        .stat-desc {
            font-size: 0.65rem; 
            margin: 0;
            line-height: 1.1;
        }

        /* Main Card Mobile */
        .main-content-card {
            margin: 0 16px;
            border-radius: 16px;
        }

        .toolbar-section {
            flex-direction: column;
            align-items: stretch;
            padding: 16px;
            gap: 12px;
        }

        .search-wrapper {
            max-width: 100%;
            width: 100%;
        }

        .search-input-modern {
            padding: 12px 15px 12px 40px;
            font-size: 15px;
        }

        .filter-group {
            width: 100%;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 10px;
        }

        .custom-select-modern, .btn-outline-soft {
            width: 100%;
        }

        /* Table Mobile */
        .table-container-modern {
            margin: 0 16px 0 16px; 
            border-radius: 12px 12px 0 0;
        }

        .data-table-modern {
            min-width: 600px;
        }

        .data-table-modern th, .data-table-modern td {
            padding: 14px 16px;
            font-size: 0.85rem;
        }

        .btn-icon-modern {
            width: 40px;
            height: 40px;
            border-radius: 10px;
        }

        /* Pagination Mobile */
        .pagination-modern {
            flex-direction: column;
            gap: 15px;
            padding: 20px 16px; 
            border-radius: 0 0 16px 16px;
        }

        .page-info-text {
            text-align: center;
            font-size: 0.8rem;
        }

        .pagination-links ul {
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
        }
        
        .pagination-links a, .pagination-links span {
            width: 36px;
            height: 36px;
            font-size: 0.8rem;
            padding: 0;
        }

        /* Empty State Mobile */
        .empty-state-modern {
            padding: 40px 16px;
        }

        .empty-icon-circle {
            width: 70px;
            height: 70px;
            font-size: 2rem;
        }

        .empty-state-modern .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#guruTable tbody tr');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const term = this.value.toLowerCase();

                tableRows.forEach(row => {
                    const name = row.querySelector('.user-info-text h4').textContent.toLowerCase();
                    const email = row.querySelector('.email-text').textContent.toLowerCase();
                    
                    if (name.includes(term) || email.includes(term)) {
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