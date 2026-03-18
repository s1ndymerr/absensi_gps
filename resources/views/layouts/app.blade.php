<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        #map {
            height: 350px;
            width: 100%;
            border-radius: 16px;
            z-index: 1;
        }

        :root {
            /* Soft Palette Colors */
            --bg-body: #f1f5f9; /* Very light blue-grey */
            --bg-sidebar: #ffffff;
            --primary-soft: #6366f1; /* Soft Indigo */
            --primary-light: #e0e7ff; /* Very light indigo for bg active */
            --accent-soft: #f43f5e; /* Soft Rose for Logout */
            --text-dark: #1e293b; /* Slate 800 */
            --text-muted: #64748b; /* Slate 500 */
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px;
            --shadow-soft: 4px 0 24px rgba(0, 0, 0, 0.02);
            --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-body);
            min-height: 100vh;
            display: flex;
            color: var(--text-dark);
        }

        /* --- Sidebar Styling --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-sidebar);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: var(--shadow-soft);
            border-right: 1px solid rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
        }

        /* Scrollbar Halus */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: #e2e8f0;
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-header h3 {
            margin: 0;
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary-soft);
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .sidebar-header h3 i {
            margin-right: 12px;
            font-size: 1.4rem;
            background: var(--primary-light);
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: var(--primary-soft);
        }

        .toggle-sidebar {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 1.1rem;
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-sidebar:hover {
            background: var(--bg-body);
            color: var(--primary-soft);
            transform: rotate(90deg);
        }

        .sidebar-menu {
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .sidebar-menu a {
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 14px 16px;
            transition: all 0.3s ease;
            position: relative;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 12px;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-menu a i {
            margin-right: 14px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            transition: all 0.3s;
        }

        /* Hover Effect */
        .sidebar-menu a:hover {
            color: var(--primary-soft);
            background: rgba(99, 102, 241, 0.05); /* Very transparent indigo */
        }
        
        .sidebar-menu a:hover i {
            transform: scale(1.1);
        }

        /* Active State - Soft Pill Style */
        .sidebar-menu a.active {
            color: var(--primary-soft);
            background: var(--primary-light);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        }

        .sidebar-menu a.active i {
            color: var(--primary-soft);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(0,0,0,0.03);
            margin-top: auto;
        }

        .sidebar-footer button {
            background: #fff1f2; /* Soft Rose background */
            border: 1px solid #fecdd3; /* Soft Rose border */
            color: var(--accent-soft);
            padding: 12px 15px;
            cursor: pointer;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .sidebar-footer button:hover {
            background: #ffe4e6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(244, 63, 94, 0.1);
        }

        .sidebar-footer button i {
            margin-right: 10px;
        }

        /* --- Content Area --- */
        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            padding: 15px 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            background: white;
            padding: 6px;
            border-radius: 50px;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(0,0,0,0.03);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #818cf8, #c084fc); /* Soft Purple Gradient */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 12px;
            font-size: 0.9rem;
        }

        .user-details {
            margin-right: 15px;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.2;
        }

        .user-role {
            color: var(--text-muted);
            font-size: 0.75rem;
            margin: 0;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .content {
            padding: 30px;
            flex: 1;
        }

        /* --- Card Styles --- */
        .dashboard-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(0,0,0,0.03);
            padding: 25px;
            margin-bottom: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .card-title i {
            margin-right: 12px;
            color: var(--primary-soft);
            background: var(--primary-light);
            padding: 10px;
            border-radius: 10px;
            font-size: 0.9rem;
        }

        /* --- Table Styles --- */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table th {
            background: #f8fafc;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .data-table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-dark);
            vertical-align: middle;
        }

        .data-table tr:hover td {
            background: #f8fafc;
        }

        /* --- Buttons --- */
        .btn-primary-custom {
            background: var(--primary-soft);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-primary-custom:hover {
            background: #4f46e5;
            transform: translateY(-2px);
        }

        /* --- Animations --- */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .content > * {
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* --- Responsive Logic (CSS for JS Toggle) --- */
        
        /* Logic: When sidebar has width 80px (Collapsed) */
        .sidebar[style*="width: 80px"] .sidebar-header h3 span,
        .sidebar[style*="width: 80px"] .sidebar-menu a span,
        .sidebar[style*="width: 80px"] .sidebar-footer button span {
            display: none;
            opacity: 0;
        }

        .sidebar[style*="width: 80px"] .toggle-sidebar {
            transform: rotate(180deg);
            margin: 0 auto; /* Center button if needed, or keep right */
        }

        .sidebar[style*="width: 80px"] .sidebar-header {
            justify-content: center;
            padding: 24px 0;
        }

        .sidebar[style*="width: 80px"] .sidebar-header h3 i {
            margin-right: 0;
            width: 40px;
            height: 40px;
        }

        .sidebar[style*="width: 80px"] .sidebar-menu {
            padding: 20px 10px;
            align-items: center;
        }

        .sidebar[style*="width: 80px"] .sidebar-menu a {
            justify-content: center;
            padding: 14px 0;
            width: 50px; /* Fixed width for icon area to look like a circle icon button */
            height: 50px;
        }

        .sidebar[style*="width: 80px"] .sidebar-menu a i {
            margin-right: 0;
            font-size: 1.3rem;
        }
        
        /* Tooltip hint for mobile collapsed */
        .sidebar[style*="width: 80px"] .sidebar-footer {
            padding: 20px 10px;
        }

        .sidebar[style*="width: 80px"] .sidebar-footer button {
            width: 50px;
            height: 50px;
            padding: 0;
            justify-content: center;
            border-radius: 12px;
        }

        .sidebar[style*="width: 80px"] .sidebar-footer button i {
            margin-right: 0;
        }

        /* Mobile Media Queries */
        @media (max-width: 768px) {
            .user-details {
                display: none;
            }
            
            .content {
                padding: 15px;
            }

            .page-title {
                font-size: 1.1rem;
            }
            
            #map {
                height: 250px;
            }
        }
    </style>
    @stack('styles')
</head>


<body>

    {{-- Sidebar --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-graduation-cap"></i> <span>E-Absensi</span></h3>
            <button class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            @if(Auth::user()->role == 'admin')
                <a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
                <a href="{{ url('/admin/guru') }}" class="{{ request()->is('admin/guru*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i> <span>Data Guru</span>
                </a>
                <a href="{{ url('/admin/siswa') }}" class="{{ request()->is('admin/siswa*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i> <span>Data Siswa</span>
                </a>
                <a href="{{ url('/admin/lokasi') }}" class="{{ request()->is('admin/lokasi*') ? 'active' : '' }}">
                    <i class="fas fa-map-marked-alt"></i> <span>Titik Lokasi GPS</span>
                </a>
                <a href="{{ url('/admin/rekap-absensi') }}" class="{{ request()->is('admin/rekap-absensi*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> <span>Rekap Absensi</span>
                </a>

            @elseif(Auth::user()->role == 'guru')
                <a href="{{ url('/guru/dashboard') }}" class="{{ request()->is('guru/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
                <a href="{{ url('/guru/absen') }}" class="{{ request()->is('guru/absen*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> <span>Absensi</span>
                </a>
                <a href="{{ url('/guru/profil') }}" class="{{ request()->is('guru/profil*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i> <span>Profil Guru</span>
                </a>
                <a href="{{ url('/guru/absensi-siswa') }}" class="{{ request()->is('guru/absensi-siswa*') ? 'active' : '' }}">
                    <i class="fas fa-user-check"></i> <span>Absensi Siswa</span>
                </a>
                <a href="{{ url('/guru/rekap-absensi') }}" class="{{ request()->is('guru/rekap-absensi*') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> <span>Rekap Absensi</span>
                </a>

            @elseif(Auth::user()->role == 'siswa')
                <a href="{{ url('/siswa/dashboard') }}" class="{{ request()->is('siswa/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
                <a href="{{ url('/siswa/profil') }}" class="{{ request()->is('siswa/profil*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i> <span>Profil Siswa</span>
                </a>
                <a href="{{ url('/siswa/absen') }}" class="{{ request()->is('siswa/absen*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> <span>Absensi</span>
                </a>
                <a href="{{ url('/siswa/riwayat-absen') }}" class="{{ request()->is('siswa/riwayat-absen*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> <span>Riwayat Absensi</span>
                </a>
            @endif
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></button>
            </form>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="content-wrapper" id="contentWrapper">
        <div class="top-header">
            <h1 class="page-title">{{ $title ?? 'Dashboard' }}</h1>
            <div class="user-info">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="user-details">
                    <p class="user-name">{{ Auth::user()->name }}</p>
                    <p class="user-role">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
        </div>
        
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script>
        // Toggle sidebar functionality
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('contentWrapper');
            
            if (window.innerWidth > 768) {
                if (sidebar.style.width === '80px') {
                    sidebar.style.width = '260px';
                    contentWrapper.style.marginLeft = '260px';
                } else {
                    sidebar.style.width = '80px';
                    contentWrapper.style.marginLeft = '80px';
                }
            }
        });

        // Handle mobile responsiveness
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('contentWrapper');
            
            if (window.innerWidth <= 768) {
                sidebar.style.width = '80px';
                contentWrapper.style.marginLeft = '80px';
            } else {
                sidebar.style.width = '260px';
                contentWrapper.style.marginLeft = '260px';
            }
        }

        // Initial call and add event listener
        handleResize();
        window.addEventListener('resize', handleResize);
    </script>
    @yield('scripts')
</body>
</html>