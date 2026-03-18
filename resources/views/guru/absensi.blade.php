@extends('layouts.app')

@section('title','Absensi Guru')

@section('content')
@php
    use Carbon\Carbon;
    $jamSekarang = Carbon::now()->format('H:i');
@endphp

<div class="absensi-compact-wrapper">

    <!-- GPS Widget (Compact) -->
    <div class="gps-ribbon" id="gps-status">
        <div class="gps-icon-loading">
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <div class="gps-text">
            Mencari lokasi...
        </div>
    </div>

    <!-- Alerts (Disamakan dengan Siswa) -->
    @if(session('success'))
        <div class="soft-alert success-alert">
            <i class="fas fa-check-circle"></i>
            <div class="alert-body">
                <strong>Berhasil!</strong>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="soft-alert error-alert">
            <i class="fas fa-exclamation-circle"></i>
            <div class="alert-body">
                <strong>Gagal!</strong>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Card -->
    <div class="absensi-main-card">
        
        <!-- Header (Compact) -->
        <div class="card-header-grad">
            <div class="header-title">
                <h2><i class="fas fa-map-marker-alt"></i> Absensi Guru</h2>
                <p>GPS Attendance System</p>
            </div>
            <div class="header-date">
                <span class="day">{{ now()->format('d') }}</span>
                <span class="month">{{ now()->format('M') }}</span>
            </div>
        </div>

        <div class="card-body-scroll">
            
            <!-- Status (Compact) -->
            @if($absenHariIni)
                <div class="status-hero-card present">
                    <div class="status-avatar-bg">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="status-info">
                        <h4>Hadir</h4>
                        <p class="sub-status">Jam Masuk: <b>{{ $absenHariIni->jam_masuk }}</b></p>
                        @if($absenHariIni->jam_pulang)
                            <p class="pulang-info">Pulang: <b>{{ $absenHariIni->jam_pulang }}</b></p>
                        @else
                            <p class="pulang-info muted">Belum Absen Pulang</p>
                        @endif
                    </div>
                </div>
            @else
                <div class="status-hero-card empty">
                    <div class="status-avatar-bg gray">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="status-info">
                        <h4>Belum Absen</h4>
                        <p class="sub-status">Silakan pilih aksi di bawah.</p>
                    </div>
                </div>
            @endif

            <!-- Actions Grid (Compact) -->
            <div class="actions-grid-compact">

                <!-- 1. Masuk -->
                <div class="action-tile-wrapper">
                    <form method="POST" action="{{ route('guru.absensi.masuk') }}" id="form-masuk" class="form-full">
                        @csrf
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        
                        <button type="submit" class="action-tile tile-primary" id="btn-masuk"
                            @if($absenHariIni) disabled @endif
                        >
                            <div class="tile-icon">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <span class="tile-title">Masuk</span>
                            <div class="tile-footer">{{ $absenHariIni ? 'Selesai' : 'Tekan' }}</div>
                        </button>
                    </form>
                </div>

                <!-- 2. Pulang -->
                <div class="action-tile-wrapper">
                    @if($absenHariIni && $absenHariIni->status === 'hadir')
                        <form method="POST" action="{{ route('guru.absensi.pulang') }}" id="form-pulang" class="form-full">
                            @csrf
                            <input type="hidden" name="latitude" id="latitude2">
                            <input type="hidden" name="longitude" id="longitude2">

                            <button type="submit" class="action-tile tile-warning"
                                @if($absenHariIni->jam_pulang || $jamSekarang < '16:00') disabled @endif
                            >
                                <div class="tile-icon">
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <span class="tile-title">Pulang</span>
                                <div class="tile-footer">{{ $absenHariIni->jam_pulang ? 'Selesai' : 'Selesai' }}</div>
                            </button>
                        </form>
                    @else
                        <button class="action-tile tile-disabled" disabled>
                            <div class="tile-icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <span class="tile-title">Pulang</span>
                        </button>
                        @if(!$absenHariIni)
                            <small class="disabled-hint">Absen masuk dulu</small>
                        @endif
                    @endif
                </div>

                <!-- 3. Izin -->
                <div class="action-tile-wrapper">
                    @if(!$absenHariIni)
                        <!-- Disamakan dengan Siswa: Dual Attributes -->
                        <button type="button" class="action-tile tile-secondary" 
                                data-bs-toggle="modal"
                                data-bs-target="#izinModal"
                                id="btn-izin">
                            <div class="tile-icon">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            <span class="tile-title">Izin</span>
                        </button>
                    @else
                        <button class="action-tile tile-disabled" disabled>
                            <div class="tile-icon">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            <span class="tile-title">Izin</span>
                        </button>
                    @endif
                </div>

                <!-- 4. Sakit -->
                <div class="action-tile-wrapper">
                    @if(!$absenHariIni)
                        <!-- Disamakan dengan Siswa: Dual Attributes -->
                        <button type="button" class="action-tile tile-danger" 
                                data-bs-toggle="modal" data-toggle="modal" 
                                data-bs-target="#sakitModal" data-target="#sakitModal" 
                                id="btn-sakit">
                            <div class="tile-icon">
                                <i class="fas fa-notes-medical"></i>
                            </div>
                            <span class="tile-title">Sakit</span>
                        </button>
                    @else
                        <button class="action-tile tile-disabled" disabled>
                            <div class="tile-icon">
                                <i class="fas fa-notes-medical"></i>
                            </div>
                            <span class="tile-title">Sakit</span>
                        </button>
                    @endif
                </div>

            </div>

            <!-- Footer Link -->
            <div class="card-footer-custom">
                <a href="{{ route('guru.absensi.riwayat') }}" class="btn-link-history">
                    Lihat Riwayat Absen
                </a>
            </div>

        </div>
    </div>

</div>

<!-- Modal Izin -->
<div class="modal fade" id="izinModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content-modern">
            <div class="modal-header-modern">
                <h5 class="modal-title">
                    <i class="fas fa-file-contract text-indigo"></i> Absen Izin
                </h5>
                <!-- Disamakan dengan Siswa: Dual Attributes -->
                <button type="button" class="close" data-bs-dismiss="modal">
                    &times;
                </button>
            </div>

            <form method="POST" action="{{ route('guru.absensi.izin') }}">
                @csrf
                <input type="hidden" name="status" value="izin">

                <div class="modal-body-modern">
                    <div class="form-group-modern">
                        <label for="alasanIzin">Alasan Izin</label>
                        <textarea
                            name="alasan"
                            id="alasanIzin"
                            class="modern-textarea"
                            rows="3"
                            placeholder="Tuliskan alasan..."
                            required></textarea>
                    </div>
                </div>

                <div class="modal-footer-modern">
                    <button type="button"
                            class="btn btn-secondary-soft"
                            data-bs-dismiss="modal" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit"
                            class="btn btn-primary-gradient">
                        Kirim
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Sakit -->
<div class="modal fade" id="sakitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content-modern">
            <div class="modal-header-modern">
                <h5 class="modal-title">
                    <i class="fas fa-notes-medical text-red"></i> Absen Sakit
                </h5>
                <!-- Disamakan dengan Siswa: Dual Attributes -->
                    <button type="button" class="close" data-bs-dismiss="modal">
                    &times;
                </button>
            </div>

            <form method="POST" action="{{ route('guru.absensi.izin') }}">
                @csrf
                <input type="hidden" name="status" value="sakit">

                <div class="modal-body-modern">
                    <div class="form-group-modern">
                        <label for="alasanSakit">Keterangan Sakit</label>
                        <textarea
                            name="alasan"
                            id="alasanSakit"
                            class="modern-textarea"
                            rows="3"
                            placeholder="Tuliskan keterangan..."
                            required></textarea>
                    </div>
                </div>

                <div class="modal-footer-modern">
                    <button type="button" class="btn btn-secondary-soft" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit"
                            class="btn btn-danger-gradient">
                        Kirim
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    /* --- CSS UTAMA (DISAMAKAN DENGAN SISWA --- RAPIH --- */
    :root {
        /* Palette Identik */
        --primary-soft: #6366f1;
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
    }

    .absensi-compact-wrapper {
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 100%;
        max-width: 800px; 
        margin: 0 auto;
    }

    /* --- GPS Ribbon (Compact) --- */
    .gps-ribbon {
        background: white;
        padding: 10px 15px; 
        border-radius: 10px;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        border-left: 4px solid var(--color-info);
        position: sticky;
        top: 0;
        z-index: 50;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-main);
    }
    .gps-icon-bg { width: 32px; height: 32px; background: #e0f2fe; color: var(--color-info); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    
    /* --- Alerts --- */
    .soft-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border-radius: var(--radius-md);
        margin-bottom: 15px;
        border-left: 4px solid;
    }
    .success-alert { background: #f0fdf4; border-color: var(--color-success); color: #166534; }
    .error-alert { background: #fef2f2; border-color: var(--color-danger); color: #991b1b; }
    .alert-body { flex: 1; }
    .alert-body strong { display: block; font-size: 0.85rem; }
    .alert-body p { margin: 0; font-size: 0.9rem; }

    /* --- Main Card --- */
    .absensi-main-card {
        background: var(--bg-surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
        margin-bottom: 20px;
    }

    .card-header-grad {
        background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
        padding: 20px 25px; 
        color: white;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-title h2 {
        margin: 0;
        font-size: 1.2rem; 
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .header-title p { margin: 2px 0 0 0; opacity: 0.9; font-size: 0.8rem; }

    .header-date {
        background: rgba(255,255,255,0.2);
        padding: 5px 10px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.3);
    }
    .day { font-size: 1rem; font-weight: 700; line-height: 1; display: block; }
    .month { font-size: 0.65rem; text-transform: uppercase; font-weight: 600; display: block; }

    .card-body-scroll { padding: 25px; }

    /* --- Status Hero (Compact) --- */
    .status-hero-card {
        background: #f8fafc;
        border: 1px solid var(--border-soft);
        border-radius: var(--radius-md);
        padding: 15px 20px; 
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px; 
        transition: all 0.3s;
    }

    .status-avatar-bg {
        width: 50px; 
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        flex-shrink: 0;
    }
    .present .status-avatar-bg { background: linear-gradient(135deg, #34d399, #10b981); }

    .status-info { flex: 1; }
    .status-info h4 { margin: 0 0 4px 0; font-size: 1rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 6px; }
    .status-info .sub-status { font-size: 0.8rem; color: var(--text-muted); font-weight: 500; margin: 0; }
    .status-info .pulang-info { font-size: 0.8rem; font-weight: 600; color: var(--text-main); padding: 4px 8px; background: white; border-radius: 6px; border: 1px solid var(--border-soft); display: inline-block; }
    .status-info .pulang-info.muted { color: var(--text-muted); background: transparent; border: none; }

    /* --- Actions Grid (Compact Tiles) --- */
    .actions-grid-compact {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px; 
        margin-bottom: 25px;
    }

    .action-tile-wrapper { width: 100%; }
    .form-full { width: 100%; height: 100%; display: block; }

    .action-tile {
        width: 100%;
        height: 110px; 
        border-radius: 12px;
        border: none;
        color: white;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .action-tile:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }

    /* Tile Types */
    .tile-primary { background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft)); box-shadow: 0 4px 10px rgba(99, 102, 241, 0.2); }
    .tile-warning { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2); }
    .tile-secondary { background: linear-gradient(135deg, #64748b, #475569); box-shadow: 0 4px 10px rgba(100, 116, 139, 0.2); }
    .tile-danger { background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2); }

    /* Tile Content (Compact) */
    .tile-icon { font-size: 1.6rem; transition: transform 0.3s; margin-bottom: 2px; }
    .action-tile:hover .tile-icon { transform: scale(1.1); }
    
    .tile-title { font-size: 0.9rem; font-weight: 700; letter-spacing: 0.2px; z-index: 2; }
    .tile-footer { font-size: 0.65rem; font-weight: 600; opacity: 0.8; text-transform: uppercase; z-index: 2; }

    /* Disabled State */
    .tile-disabled {
        background: #f1f5f9;
        color: #cbd5e1;
        cursor: not-allowed;
        box-shadow: none !important;
        pointer-events: none;
        transform: none !important;
    }

    .disabled-hint {
        display: block;
        margin-top: 5px;
        text-align: center;
        font-size: 0.7rem;
        color: #94a3b8;
        font-weight: 600;
    }

    /* --- Footer Link --- */
    .card-footer-custom { padding-top: 15px; border-top: 1px solid var(--border-soft); text-align: center; }
    .btn-link-history {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: white;
        color: var(--text-main);
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        font-size: 0.9rem;
        border: 1px solid var(--border-soft);
        transition: all 0.3s;
    }
    .btn-link-history:hover { background: #f8fafc; border-color: var(--primary-soft); color: var(--primary-soft); }

    /* --- Modals (Clean CSS from Siswa) --- */
    .modal { 
        z-index: 1050 !important; 
        position: fixed;
        outline: none;
    }
    
    .modal-backdrop { 
        z-index: 1045 !important; 
    }

    .modal-dialog {
        pointer-events: auto;
    }

    .modal-content-modern { 
        pointer-events: auto;
        background: #ffffff; 
        border-radius: var(--radius-lg); 
        box-shadow: var(--shadow-lg); 
        border: 1px solid var(--border-soft); 
        overflow: hidden; 
        display: flex; 
        flex-direction: column; 
        position: relative;
        z-index: 1060;
    }
    .modal-header-modern { 
        padding: 15px 20px; 
        border-bottom: 1px solid var(--border-soft); 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        background: #ffffff; 
    }
    .modal-title { margin: 0; font-size: 1rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 8px; }
    .modal-title i { font-size: 0.9rem; }
    .modal-body-modern { 
        padding: 20px; 
        background: #ffffff; 
        position: relative;
        z-index: 1061;
    }
    .modal-footer-modern { 
        padding: 15px 20px; 
        border-top: 1px solid var(--border-soft); 
        display: flex; 
        justify-content: flex-end; 
        gap: 8px; 
        background: #ffffff; 
    }
    .close { background: none; border: none; font-size: 1.2rem; color: var(--text-muted); cursor: pointer; }
    
    .form-group-modern label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main); font-size: 0.9rem; }
    
    .modern-textarea { 
        width: 100%; 
        padding: 10px; 
        border: 1px solid var(--border-soft); 
        border-radius: 8px; 
        background: #ffffff; 
        font-family: inherit; 
        font-size: 0.9rem; 
        resize: vertical; 
        transition: all 0.3s; 
        color: var(--text-main); 
        position: relative;
        z-index: 1070; 
    }
    .modern-textarea:focus { 
        outline: none; 
        border-color: var(--primary-soft); 
        background: #ffffff; 
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* ----------------------------------------------------------------
       ANDROID / MOBILE RESPONSIVE VIEW (SEIMBANG & KOMPAK)
    ---------------------------------------------------------------- */
    @media (max-width: 768px) {
        /* Wrapper & Spacing */
        .absensi-compact-wrapper {
            padding: 10px;
        }

        /* 1. GPS Ribbon */
        .gps-ribbon {
            padding: 8px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }
        .gps-icon-bg {
            width: 28px; height: 28px; font-size: 0.8rem;
        }

        /* 2. Main Card */
        .absensi-main-card {
            border-radius: 12px;
            overflow: hidden;
        }
        
        .card-header-grad {
            padding: 15px 20px;
            flex-direction: row; /* Tetap row agar kompak */
            align-items: center;
            justify-content: space-between;
        }
        .header-title h2 {
            font-size: 1.1rem;
        }
        .header-title p {
            font-size: 0.75rem;
        }
        .header-date {
            padding: 4px 8px;
        }

        .card-body-scroll {
            padding: 15px; /* Padding body dikurangi */
        }

        /* 3. Status Hero Card */
        .status-hero-card {
            padding: 12px 15px; /* Compact padding */
            margin-bottom: 20px;
            flex-direction: row; /* Horizontal layout */
            align-items: center;
        }
        
        /* Icon & Text Size Scaling */
        .status-avatar-bg {
            width: 40px; height: 40px;
            font-size: 1rem;
            border-radius: 10px;
        }
        
        .status-info h4 {
            font-size: 0.95rem;
            margin-bottom: 2px;
        }
        .status-info .sub-status, 
        .status-info .pulang-info {
            font-size: 0.75rem;
        }

        /* 4. Action Grid (Kunci Keseimbangan: 2x2 Grid) */
        .actions-grid-compact {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 Kolom agar Seimbang */
            gap: 10px; /* Jarak rapat */
            margin-bottom: 20px;
        }

        /* Tile Size */
        .action-tile {
            height: 90px; /* Tinggi tetap agar semua kartu sama tinggi */
            border-radius: 10px;
            padding: 10px;
        }

        /* Tile Content Scaling */
        .tile-icon {
            font-size: 1.4rem; /* Ikon lebih kecil */
            margin-bottom: 4px;
        }
        
        .tile-title {
            font-size: 0.9rem; /* Font judul pas */
        }

        .tile-footer {
            font-size: 0.6rem;
            margin-top: 2px;
            /* Optional: Hide footer text if too crowded, but here we keep it small */
            /* display: none; */ 
        }

        /* 5. Footer Link */
        .card-footer-custom {
            padding-top: 10px;
        }
        .btn-link-history {
            width: 100%; /* Lebar penuh */
            padding: 12px;
            font-size: 0.9rem;
            justify-content: center;
        }

        /* 6. Modals */
        .modal-dialog {
            margin: 15px; /* Jarak dari tepi */
            max-width: calc(100% - 30px);
        }
        .modal-content-modern {
            border-radius: 12px;
        }
        .modal-header-modern,
        .modal-body-modern,
        .modal-footer-modern {
            padding: 15px;
        }
        .modern-textarea {
            min-height: 80px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!navigator.geolocation) {
        updateGPSStatus(false, 'Browser tidak mendukung GPS');
        disableForms();
        return;
    }

    function updateGPSStatus(success, msg) {
        const gpsWidget = document.getElementById('gps-status');
        if (success) {
            gpsWidget.style.background = '#f0fdf4';
            gpsWidget.style.borderLeftColor = '#10b981';
            gpsWidget.style.color = '#166534';
            gpsWidget.innerHTML = '<div class="gps-icon-bg" style="background:#dcfce7; color:#166534;"><i class="fas fa-check-circle"></i></div><div class="gps-text">GPS Aktif: ' + msg + '</div>';
        } else {
            gpsWidget.style.background = '#fef2f2';
            gpsWidget.style.borderLeftColor = '#ef4444';
            gpsWidget.style.color = '#991b1b';
            gpsWidget.innerHTML = '<div class="gps-icon-bg" style="background:#fee2e2; color:#991b1b;"><i class="fas fa-times-circle"></i></div><div class="gps-text">' + msg + '</div>';
        }
    }

    function disableForms() {
        ['form-masuk', 'form-pulang'].forEach(id => {
            const form = document.getElementById(id);
            if(form) {
                const btn = form.querySelector('button');
                if(btn) btn.disabled = true;
            }
        });
    }

    navigator.geolocation.getCurrentPosition(
        function (position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            const msg = lat.toFixed(5) + ', ' + lon.toFixed(5);
            updateGPSStatus(true, msg);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;

            const lat2 = document.getElementById('latitude2');
            if (lat2) {
                document.getElementById('latitude2').value = lat;
                document.getElementById('longitude2').value = lon;
            }
        },
        function (error) {
            let msg = 'Gagal mendapatkan lokasi';
            if(error.code == error.PERMISSION_DENIED) msg = 'Akses GPS ditolak.';
            updateGPSStatus(false, msg);
            disableForms();
        }
    );

    // SCRIPT FALLBACK (Disamakan dengan Siswa agar Modal Pasti Jalan)
   

    if(btnSakit && modalSakit) {
        btnSakit.addEventListener('click', function(e) {
            e.preventDefault();
            // Coba Bootstrap 5
            if (typeof bootstrap !== 'undefined') {
                var myModal = new bootstrap.Modal(modalSakit);
                myModal.show();
            } 
            // Fallback Bootstrap 4
            else if (typeof $ !== 'undefined' && $.fn.modal) {
                $(modalSakit).modal('show');
            }
        });
    }
});
document.addEventListener('hidden.bs.modal', function () {
    document.body.classList.remove('modal-open');
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
});

</script>
@endsection