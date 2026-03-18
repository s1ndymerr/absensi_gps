@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
@php
    // Ambil mode dari request (URL Parameter)
    $mode = request()->input('mode'); 
@endphp

<div class="rekap-wrapper">

    <!-- Header & Filter (Hanya tampil di Normal View) -->
    @if(!$mode)
        <div class="page-header-section">
            <div class="header-text">
                <h1 class="main-title">Laporan Kehadiran</h1>
                <p class="sub-title">Analisis data presensi siswa dan guru berdasarkan tanggal.</p>
            </div>
        </div>

        <div class="tab-segment-wrapper">
            <a href="{{ route('admin.rekap_absensi.index', array_merge(request()->all(), ['tipe'=>'siswa'])) }}" 
               class="segment-item {{ $tipe=='siswa' ? 'active' : '' }}">
                <span class="icon-box"><i class="fas fa-user-graduate"></i></span>
                <span class="label">Rekap Siswa</span>
            </a>
            <a href="{{ route('admin.rekap_absensi.index', array_merge(request()->all(), ['tipe'=>'guru'])) }}" 
               class="segment-item {{ $tipe=='guru' ? 'active' : '' }}">
                <span class="icon-box"><i class="fas fa-chalkboard-teacher"></i></span>
                <span class="label">Rekap Guru</span>
            </a>
        </div>

        <div class="filter-card">
            <div class="filter-title">
                <i class="fas fa-sliders-h"></i> Parameter Filter
            </div>
            <form method="GET">
                <input type="hidden" name="tipe" value="{{ $tipe }}">
                
                <div class="filter-grid-layout">
                    <div class="input-wrapper">
                        <label>Pilih Tanggal</label>
                        <div class="custom-input-group">
                            <i class="far fa-calendar-alt"></i>
                            <input type="date" name="tanggal" class="modern-input" value="{{ $tanggal }}">
                        </div>
                    </div>

                    @if($tipe=='siswa')
                        <div class="input-wrapper">
                            <label>Tingkat Kelas</label>
                            <select name="tingkat" class="modern-select">
                                <option value="">Semua Tingkat</option>
                                @foreach($listTingkat as $t)
                                    <option value="{{ $t }}" {{ old('tingkat', $tingkat)==$t?'selected':'' }}>Kelas {{ $t }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-wrapper">
                            <label>Jurusan</label>
                            <select name="jurusan_kelas" class="modern-select">
                                <option value="">Semua Jurusan</option>
                                @foreach($listJurusanKelas as $j)
                                    <option value="{{ $j }}" {{ old('jurusan_kelas', $jurusan_kelas)==$j?'selected':'' }}>
                                        {{ $j }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="input-wrapper action-wrapper">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary-gradient w-100">
                            <i class="fas fa-search"></i> Cari Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif


    <!-- Content Area -->
    @if($tipe=='siswa')
        
        <!-- 1. Summary Per Kelas -->
        <!-- LOGIKA: Tampilkan KECUALI Mode SAMA DENGAN 'detail' -->
        @if($mode !== 'detail')
        <div class="content-card mb-4">
            <div class="card-head">
                <h3 class="title">Statistik Per Kelas</h3>
                
                <!-- Tombol Cetak Hanya muncul di Mode Normal -->
                @if(!$mode)
                <a href="{{ route('admin.rekap_absensi.export.pdf', array_merge(request()->all(), ['mode' => 'ringkasan'])) }}"
                   class="btn-icon-print" title="Cetak Hanya Ringkasan" target="_blank">
                    <i class="fas fa-print"></i> Cetak Ringkasan
                </a>
                @endif
            </div>
            <div class="table-responsive">
                <table class="clean-table">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th class="text-center">Hadir</th>
                            <th class="text-center">Izin/Sakit</th>
                            <th class="text-center">Alpha</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap_per_kelas as $k=>$v)
                        <tr>
                            <td class="font-semibold">{{ $k }}</td>
                            <td class="text-center">
                                <span class="status-stat success-stat">{{ $v['hadir'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="status-stat warning-stat">{{ $v['izin'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="status-stat danger-stat">{{ $v['alpha'] }}</span>
                            </td>
                            <td class="text-center text-muted">{{ $v['total'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-cell">Data ringkasan tidak tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- 2. Detail Absensi Siswa -->
        <!-- LOGIKA: Tampilkan KECUALI Mode SAMA DENGAN 'ringkasan' -->
        @if($mode !== 'ringkasan')
        <div class="content-card">
            <div class="card-head">
                <h3 class="title">Daftar Kehadiran Siswa</h3>
                
                <!-- Tombol Cetak Hanya muncul di Mode Normal -->
                @if(!$mode)
                <a href="{{ route('admin.rekap_absensi.export.pdf', array_merge(request()->all(), ['mode' => 'detail'])) }}"
                   class="btn-icon-print" title="Cetak Hanya Detail" target="_blank">
                    <i class="fas fa-print"></i> Cetak Detail
                </a>
                @endif
            </div>
            <div class="table-responsive">
                <table class="clean-table">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Informasi Siswa</th>
                            <th>Kelas</th>
                            <th width="150">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap_siswa as $i=>$s)
                        <tr>
                            <td class="text-muted num-cell">{{ $i+1 }}</td>
                            <td>
                                <div class="user-info-inline">
                                    <div class="avatar-simple avatar-purple">
                                        {{ substr($s['nama'], 0, 1) }}
                                    </div>
                                    <span class="user-name">{{ $s['nama'] }}</span>
                                </div>
                            </td>
                            <td class="text-muted">{{ $s['kelas'] }}</td>
                            <td>
                                @php
                                    $status = ucfirst($s['status']);
                                    $color = 'neutral';
                                    if(strtolower($s['status']) == 'hadir') $color = 'success';
                                    elseif(strtolower($s['status']) == 'izin' || strtolower($s['status']) == 'sakit') $color = 'warning';
                                    elseif(strtolower($s['status']) == 'alpha') $color = 'danger';
                                @endphp
                                <span class="status-pill pill-{{ $color }}">
                                    <i class="fas fa-circle status-dot"></i> {{ $status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="empty-cell">Tidak ada data absensi siswa untuk filter ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    @elseif($tipe == 'guru')


        <!-- Absensi Guru -->
        <!-- Jika mode bukan apa-apa atau detail, maka tampilkan -->
         @if($mode !== 'ringkasan')
    <div class="content-card">
            <div class="card-head">
                <h3 class="title">Daftar Kehadiran Guru</h3>
                @if(!$mode)
                <a href="{{ route('admin.rekap_absensi.export.pdf', array_merge(request()->all(), ['mode' => 'detail'])) }}"
                   class="btn-icon-print" title="Cetak Data Guru" target="_blank">
                    <i class="fas fa-print"></i> Cetak Data Guru
                </a>
                @endif
            </div>
            <div class="table-responsive">
                <table class="clean-table">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Guru</th>
                            <th width="150">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap_guru as $i=>$g)
                        <tr>
                            <td class="text-muted num-cell">{{ $i+1 }}</td>
                            <td>
                                <div class="user-info-inline">
                                    <div class="avatar-simple avatar-purple">
                                        {{ substr($g['nama'], 0, 1) }}
                                    </div>
                                    <span class="user-name">{{ $g['nama'] }}</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $status = ucfirst($g['status']);
                                    $color = 'neutral';
                                    if(strtolower($g['status']) == 'hadir') $color = 'success';
                                    elseif(strtolower($g['status']) == 'izin' || strtolower($g['status']) == 'sakit') $color = 'warning';
                                    elseif(strtolower($g['status']) == 'alpha') $color = 'danger';
                                @endphp
                                <span class="status-pill pill-{{ $color }}">
                                    <i class="fas fa-circle status-dot"></i> {{ $status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="empty-cell">Tidak ada data absensi guru untuk filter ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    @endif

</div>

<style>
    :root {
        /* Identik dengan Data Siswa & Data Guru */
        --primary-soft: #6366f1;
        --primary-dark: #4f46e5;
        --secondary-soft: #a855f7;
        --bg-body: #f1f5f9;
        --bg-card: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-soft: #e2e8f0;
        
        /* Status Colors */
        --color-success: #10b981;
        --color-warning: #f59e0b;
        --color-danger: #ef4444;
        --color-neutral: #94a3b8;

        /* Radius & Shadows */
        --radius: 12px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .rekap-wrapper {
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* --- Header --- */
    .page-header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .header-text h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 5px 0;
    }
    .sub-title { color: var(--text-muted); margin: 0; font-size: 0.95rem; }

    /* --- Tombol Cetak Kecil (Card Head) --- */
    .btn-icon-print {
        color: var(--text-muted);
        background: #f1f5f9;
        padding: 8px 16px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.3s;
        font-size: 0.85rem;
        font-weight: 600;
        margin-left: auto;
        white-space: nowrap;
    }
    .btn-icon-print:hover {
        background: var(--primary-soft);
        color: white;
    }

    /* --- Tab Segmented --- */
    .tab-segment-wrapper {
        display: inline-flex;
        background: white;
        padding: 5px;
        border-radius: 12px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-soft);
        margin-bottom: 25px;
    }
    .segment-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        border-radius: 9px;
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    .segment-item:hover { color: var(--primary-soft); background: #f8fafc; }
    .segment-item.active {
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
        color: white;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }

    /* --- Filter Card --- */
    .filter-card {
        background: white;
        padding: 25px;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 30px;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .filter-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .filter-grid-layout {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        align-items: end;
    }

    .input-wrapper label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    /* Inputs */
    .custom-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }
    .custom-input-group i {
        position: absolute;
        left: 14px;
        color: var(--text-muted);
        z-index: 1;
    }
    .modern-input, .modern-select {
        width: 100%;
        padding: 11px 14px 11px 40px;
        border: 1px solid var(--border-soft);
        border-radius: 10px;
        background: #f8fafc;
        color: var(--text-main);
        font-size: 0.9rem;
        transition: all 0.3s;
        outline: none;
    }
    .modern-select { padding-left: 14px; cursor: pointer; }
    .modern-input:focus, .modern-select:focus {
        background: white;
        border-color: var(--primary-soft);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
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

    /* --- Content Cards --- */
    .content-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 0;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
        margin-bottom: 25px;
        break-inside: avoid; 
    }
    .card-head {
        padding: 20px 25px;
        border-bottom: 1px solid var(--border-soft);
        display: flex; 
        align-items: center;
        justify-content: space-between;
    }
    .card-head .title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* --- Tables --- */
    .table-responsive { 
        overflow-x: auto; 
        -webkit-overflow-scrolling: touch; 
    }
    .clean-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px; 
    }
    .clean-table th {
        text-align: left;
        padding: 16px 25px;
        font-weight: 700;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f8fafc;
        border-bottom: 2px solid var(--border-soft);
    }
    .clean-table td {
        padding: 16px 25px;
        border-bottom: 1px solid #f1f5f9;
        color: var(--text-main);
        font-size: 0.9rem;
        vertical-align: middle;
    }
    .clean-table tbody tr:hover { background: #f8fafc; }
    .clean-table tr:last-child td { border-bottom: none; }
    
    .text-center { text-align: center; }
    .text-muted { color: var(--text-muted); }
    .font-semibold { font-weight: 700; color: var(--text-main); }

    /* Status Stat for Summary Table */
    .status-stat {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .success-stat { background: #dcfce7; color: #166534; }
    .warning-stat { background: #fef3c7; color: #92400e; }
    .danger-stat { background: #fee2e2; color: #991b1b; }

    /* User Info in Table */
    .user-info-inline {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .avatar-simple {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0; 
    }
    .avatar-purple {
        background: linear-gradient(135deg, #a855f7, #d8b4fe);
    }
    .user-name { font-weight: 600; color: var(--text-main); font-size: 0.95rem; }

    /* Status Badge with Dot */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-dot { font-size: 0.5rem; }

    .pill-success { background: #dcfce7; color: #166534; }
    .pill-warning { background: #fef3c7; color: #92400e; }
    .pill-danger { background: #fee2e2; color: #991b1b; }
    .pill-neutral { background: #f1f5f9; color: #64748b; }

    .empty-cell {
        text-align: center !important;
        padding: 30px !important;
        color: var(--text-muted);
        font-style: italic;
    }

    /* --- RESPONSIVE MOBILE / ANDROID OPTIMIZATION --- */
    @media (max-width: 768px) {
        body { padding: 10px; } 
        
        .page-header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }
        .header-text h1 { font-size: 1.5rem; }
        
        .tab-segment-wrapper {
            display: flex; 
            width: 100%;
            overflow-x: auto; 
            padding: 5px;
        }
        .segment-item {
            flex: 1; 
            justify-content: center;
            padding: 10px;
            font-size: 0.85rem;
        }

        .filter-card { padding: 20px 15px; }
        .filter-grid-layout {
            grid-template-columns: 1fr; 
            gap: 15px;
        }
        
        .modern-input, .modern-select {
            padding: 12px 14px; 
            font-size: 16px !important; 
        }

        .content-card { border-radius: 8px; margin-bottom: 20px; }
        
        .card-head {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .btn-icon-print {
            width: 100%; 
            justify-content: center;
            margin-left: 0;
            padding: 12px;
        }

        .clean-table th { padding: 12px 15px; font-size: 0.7rem; }
        .clean-table td { padding: 12px 15px; font-size: 0.85rem; }
        
        .avatar-simple { width: 30px; height: 30px; font-size: 0.8rem; } 
        .user-info-inline { gap: 8px; }
        .user-name { font-size: 0.9rem; }
    }

    /* --- CSS KHUSUS PRINT (PDF) --- */
    @media print {
        body {
            background-color: white;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .content-card {
            box-shadow: none;
            border: 1px solid #000;
            margin-bottom: 0;
            break-inside: avoid; 
        }

        .rekap-wrapper {
            max-width: 100%;
            padding: 0;
            margin: 0;
        }

        table, th, td {
            border: 1px solid #000 !important;
        }
        
        th, td {
            color: black !important;
        }
        
        .clean-table th {
            background-color: #f0f0f0 !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>
@endsection