@extends('layouts.app')

@section('title', 'Absensi Siswa')

@section('content')
<div class="absensi-compact-wrapper">

    <!-- GPS Widget (Compact) -->
    <div class="gps-ribbon" id="gps-status">
        <div class="gps-icon-bg">
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
        <div class="gps-text">
            Mencari lokasi...
        </div>
    </div>

    <!-- Main Card -->
    <div class="absensi-main-card">
        
        <!-- Header -->
        <div class="card-header-grad">
            <div class="header-title">
                <h2><i class="fas fa-map-marker-alt"></i> Absensi Siswa</h2>
                <p>Sistem Presensi GPS</p>
            </div>
            <div class="header-date">
                <span class="day">{{ now()->format('d') }}</span>
                <span class="month">{{ now()->format('M') }}</span>
            </div>
        </div>
        {{-- ALERT ERROR --}}
        @if (session('error'))
            <div class="soft-alert error-alert">
                <div class="alert-body">
                    <strong>Gagal Absen</strong>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- ALERT SUCCESS --}}
        @if (session('success'))
            <div class="soft-alert success-alert">
                <div class="alert-body">
                    <strong>Berhasil</strong>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="card-body-scroll">
            
            <!-- Status Hari Ini (LOGIKA DATA TIDAK DIUBAH) -->
            @if($absen)
                <div class="status-hero-card present">
                    <div class="status-avatar-bg">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="status-info">
                       <h4>
    @if($absen->status === 'hadir' && $absen->jam_pulang)
        Sudah Pulang
    @elseif($absen->status === 'hadir')
        Hadir
    @else
        {{ ucfirst($absen->status) }}
    @endif
</h4>

                        <p class="sub-status">Jam Masuk: <b>{{ $absen->jam_masuk }}</b></p>
                        

                        {{-- Jam Pulang --}}
                        @if($absen->jam_pulang)
                            <p class="pulang-info">Pulang: <b>{{ $absen->jam_pulang }}</b></p>
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
                        <h4>Belum Absen Hari Ini</h4>
                        <p class="sub-status">Silakan pilih aksi di bawah.</p>
                    </div>
                </div>
            @endif

            <!-- Actions Grid (Kompak 2x2) -->
            <div class="actions-grid-compact">

                <!-- 1. Masuk -->
                <div class="action-tile-wrapper">
                    <form method="POST" action="{{ route('siswa.absensi.masuk') }}" id="form-masuk" class="form-full">
                        @csrf
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                        
                        <button type="submit" class="action-tile tile-primary" id="btn-masuk"
                            {{ $absen ? 'disabled' : '' }}
                        >
                            <div class="tile-icon">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <span class="tile-title">Masuk</span>
                            <div class="tile-footer">{{ $absen ? 'Selesai' : 'Tekan' }}</div>
                        </button>
                    </form>
                </div>

                <!-- 2. Pulang -->
                <div class="action-tile-wrapper">
                    <form method="POST" action="{{ route('siswa.absensi.pulang') }}" id="form-pulang" class="form-full">
                        @csrf
                        <input type="hidden" id="latitude2" name="latitude">
                        <input type="hidden" id="longitude2" name="longitude">

                        <button type="submit" class="action-tile tile-warning"
                            {{ !$absen || $absen->jam_pulang || $absen->status !== 'hadir' ? 'disabled' : '' }}
                        >
                            <div class="tile-icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <span class="tile-title">Pulang</span>
                            <div class="tile-footer">{{ $absen && $absen->jam_pulang ? 'Selesai' : 'Selesai' }}</div>
                        </button>
                    </form>
                </div>

                <!-- 3. Izin (PERBAIKAN: DISAMAKAN DENGAN GURU) -->
                <div class="action-tile-wrapper">
                    @if(!$absen)
                        <!-- Menggunakan ATRIBUT GANDA (BS4 & BS5) agar PASTI jalan -->
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

                <!-- 4. Sakit (PERBAIKAN: DISAMAKAN DENGAN GURU) -->
                <div class="action-tile-wrapper">
                    @if(!$absen)
                        <!-- Menggunakan ATRIBUT GANDA (BS4 & BS5) agar PASTI jalan -->
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

        </div>
    </div>

</div>

<!-- Modal Izin (PERBAIKAN: DISAMAKAN DENGAN GURU) -->
<div class="modal fade" id="izinModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content-modern">
            <div class="modal-header-modern">
                <h5 class="modal-title">
                    <i class="fas fa-file-contract text-indigo"></i> Absen Izin
                </h5>
                <!-- Atribut Ganda Close -->
                <button type="button" class="close" data-bs-dismiss="modal" >
                    &times;
                </button>
            </div>

            <form method="POST" action="{{ route('siswa.absensi.izin') }}">
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
                    <!-- Atribut Ganda Batal -->
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

<!-- Modal Sakit (PERBAIKAN: DISAMAKAN DENGAN GURU) -->
<div class="modal fade" id="sakitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content-modern">
            <div class="modal-header-modern">
                <h5 class="modal-title">
                    <i class="fas fa-notes-medical text-red"></i> Absen Sakit
                </h5>
                <!-- Atribut Ganda Close -->
                    <button type="button" class="close" data-bs-dismiss="modal">
                    &times;
                </button>
            </div>

            <form method="POST" action="{{ route('siswa.absensi.izin') }}">
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
                    <!-- Atribut Ganda Batal -->
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
    /* --- CSS UTAMA (DISAMAKAN DENGAN GURU) --- */
    :root {
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
        --color-secondary: #64748b;
        
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

    /* --- GPS Ribbon --- */
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

    /* --- Status Hero --- */
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

    /* Approval Badges */
    .status-badge {
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(0,0,0,0.1);
        margin-left: auto;
    }
    .badge-warning { background: #fffbeb; color: #92400e; border-color: #fcd34d; }
    .badge-success { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .badge-danger { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

    .status-info .pulang-info { font-size: 0.8rem; font-weight: 600; color: var(--text-main); padding: 4px 8px; background: white; border-radius: 6px; border: 1px solid var(--border-soft); display: inline-block; margin-top: 10px;}
    .status-info .pulang-info.muted { color: var(--text-muted); background: transparent; border: none; }

    .status-hero-card.empty {
        border-style: dashed;
        background: white;
    }

    /* --- Actions Grid --- */
    .actions-grid-compact {
        display: grid;
        /* Default Desktop: 4 kolom sejajar */
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

    /* Tile Content */
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
    .disabled-hint { display: block; margin-top: 5px; text-align: center; font-size: 0.7rem; color: #94a3b8; font-weight: 600; }

    /* --- Modals (FIX CSS DARI GURU) --- */
    .modal { 
        z-index: 1050 !important; /* Paksa palig atas */
        position: fixed;
        outline: none;
    }
    
    .modal-backdrop { 
        z-index: 1045 !important;
    }

    .modal-dialog {
        pointer-events: none; 
        z-index: 1050 !important;
    }

    .modal-content-modern { 
        pointer-events: auto; /* Konten bisa menerima klik/ketikan */
        background: #ffffff; 
        border-radius: var(--radius-lg); 
        box-shadow: var(--shadow-lg); 
        border: 1px solid rgba(0,0,0,0.05); 
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
        z-index: 1070; /* Input paling atas agar bisa diketik */
    }
    
    .modern-textarea:focus { 
        outline: none; 
        border-color: var(--primary-soft); 
        background: #ffffff; 
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* --- Responsive --- */
    @media (max-width: 992px) {
        .card-header-grad { text-align: center; flex-direction: column; padding: 20px; }
        /* Tablet: 2 kolom */
        .actions-grid-compact { grid-template-columns: 1fr 1fr; gap: 15px; }
    }

    @media (max-width: 480px) {
        .absensi-compact-wrapper { padding: 0 10px; }
        
        /* HP/ANDROID: 2 kolom (Grid 2x2) */
        .actions-grid-compact { 
            grid-template-columns: 1fr 1fr; 
            gap: 10px; /* Jarak dikurangi sedikit agar muat */
        }
        
        .action-tile { height: 100px; }
        .status-hero-card { flex-direction: column; text-align: center; padding: 15px; }
        .status-avatar-bg { margin: 0 auto 10px auto; }
        .status-info { margin-top: 15px; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!navigator.geolocation) {
        const gpsWidget = document.getElementById('gps-status');
        gpsWidget.style.background = '#fef2f2';
        gpsWidget.style.borderLeftColor = '#ef4444';
        gpsWidget.style.color = '#991b1b';
        gpsWidget.innerHTML = '<div class="gps-icon-bg" style="background:#fee2e2; color:#991b1b;"><i class="fas fa-times-circle"></i></div><div class="gps-text">Browser tidak mendukung GPS</div>';
        
        ['form-masuk', 'form-pulang'].forEach(id => {
            const form = document.getElementById(id);
            if(form) {
                const btn = form.querySelector('button');
                if(btn) btn.disabled = true;
            }
        });
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
            
            ['form-masuk', 'form-pulang'].forEach(id => {
                const form = document.getElementById(id);
                if(form) {
                    const btn = form.querySelector('button');
                    if(btn) btn.disabled = true;
                }
            });
        }
    );

    // SCRIPT FALLBACK (DISAMAKAN DENGAN GURU AGAR MODAL PASTI JALAN)
    const btnSakit = document.getElementById('btn-sakit');
    const modalSakit = document.getElementById('sakitModal');

    if(btnSakit && modalSakit) {
        btnSakit.addEventListener('click', function(e) {
            e.preventDefault();
            // Coba pakai Bootstrap 5
            if (typeof bootstrap !== 'undefined') {
                var myModal = new bootstrap.Modal(modalSakit);
                myModal.show();
            } 
            // Fallback ke Bootstrap 4/JQuery
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