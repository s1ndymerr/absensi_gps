<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Absensi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Identik dengan Dashboard & Halaman Lain */
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
            --radius-xl: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        /* --- Animated Background Shapes --- */
        .bg-shape {
            position: absolute;
            background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
            border-radius: 50%;
            opacity: 0.05;
            z-index: 0;
            animation: float 20s infinite ease-in-out;
        }
        .shape-1 { top: 10%; left: 5%; width: 200px; height: 200px; }
        .shape-2 { bottom: 10%; right: 5%; width: 300px; height: 300px; animation-delay: 5s; }
        .shape-3 { bottom: 30%; left: 10%; width: 100px; height: 100px; animation-delay: 10s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(10deg); }
            66% { transform: translateY(20px) rotate(-10deg); }
        }

        /* --- Login Card Wrapper --- */
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            z-index: 10;
            animation: slideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: var(--bg-surface);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            padding: 0;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.02);
            position: relative;
        }

        /* --- Header --- */
        .login-header {
            padding: 30px 40px 20px 40px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
            color: white;
        }

        .login-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 10px 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        /* --- Role Selector (Modern Tiles) --- */
        .role-selector-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 25px;
            padding: 0 40px;
        }

        .role-tile {
            background: #f8fafc;
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 15px 5px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            box-shadow: var(--shadow-sm);
        }

        .role-tile:hover {
            border-color: #e0e7ff;
            background: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* --- ACTIVE STATE (PERBAIKAN) --- */
        .role-tile.active {
            background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft)); /* Background Berubah Full Gradient */
            color: white; /* Teks Putih Agar Terbaca */
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
            transform: translateY(-2px);
        }

        .role-tile i {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 5px;
            transition: transform 0.3s;
        }
        
        /* Warna Teks & Icon Saat Inactive (Abu Gelap) */
        .role-tile i { color: #94a3b8; }
        .role-tile span { color: #64748b; }

        /* Warna Teks & Icon Saat Hover (Biru Muda) */
        .role-tile:hover i { color: var(--primary-soft); }
        .role-tile:hover span { color: var(--primary-soft); }

        /* Warna Teks & Icon Saat Active (Putih & Kontras) */
        .role-tile.active i { 
            color: white !important; 
            transform: scale(1.1);
        }
        .role-tile.active span { 
            color: white !important; 
            text-shadow: 0 1px 2px rgba(0,0,0,0.1); /* Tulisannya tajam */
        }

        .role-tile span {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* --- Form Body --- */
        .login-body {
            padding: 10px 40px 40px 40px;
        }

        /* --- Alerts --- */
        .soft-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 5px solid;
            background: #fef2f2;
            color: #991b1b;
        }
        .soft-alert.error-alert { background: #fef2f2; border-color: #ef4444; color: #991b1b; }
        .alert-icon { font-size: 1.2rem; flex-shrink: 0; }
        .alert-body { flex: 1; }
        .alert-body strong { display: block; font-size: 0.85rem; }
        .alert-body span { font-size: 0.9rem; }

        /* --- Form Groups (Modern) --- */
        .form-group-modern {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group-modern label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .input-group-modern {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Icon Wrapper (Colored Background) */
        .input-icon-wrapper {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 45px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            z-index: 2;
        }

        /* Gradients for Icons */
        .icon-purple { background: linear-gradient(135deg, #a855f7, #d8b4fe); }
        .icon-indigo { background: linear-gradient(135deg, #6366f1, #818cf8); }
        .icon-blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
        .icon-teal { background: linear-gradient(135deg, #14b8a6, #2dd4bf); }

        .modern-input {
            width: 100%;
            padding: 12px 15px 12px 55px;
            background: #f8fafc;
            border: 1px solid var(--border-soft);
            border-radius: 10px;
            color: var(--text-main);
            font-size: 0.95rem;
            transition: all 0.3s;
            outline: none;
        }

        .modern-input:focus {
            background: white;
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* --- Buttons --- */
        .btn-modern {
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }

        /* --- Footer --- */
        .login-footer {
            margin-top: 25px;
            text-align: center;
        }

        .footer-link {
            color: var(--text-muted);
            font-size: 0.9rem;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .footer-link:hover {
            color: var(--primary-soft);
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-soft);
        }
        .divider span {
            padding: 0 10px;
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* --- Responsive (PERBAIKAN HANYA UNTUK ANDROID) --- */
        @media (max-width: 480px) {
            .login-wrapper {
                margin: 0 10px;
                width: auto;
            }

            /* 1. Menambah Jarak Header dengan Elemen di bawahnya */
            .login-header {
                padding: 30px 15px 35px 15px; /* Bottom padding diperbesar agar jarak ke Role lebih lega */
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            /* 2. Padding Body disesuaikan */
            .login-body {
                padding: 0 15px 30px 15px; 
            }

            /* 3. Role Selector Grid Disesuaikan Agar Ke Samping (Sejajar) */
            .role-selector-grid {
                grid-template-columns: repeat(3, 1fr); /* <--- Memaksa 3 kolom sejajar */
                gap: 6px; /* Jarak antar tombol dirapatkan agar muat */
                padding: 0 5px 20px 5px;
                margin-bottom: 20px;
                margin-top: 10px; /* Tambah margin atas dari grid untuk jarak ekstra */
            }

            /* 4. Menyesuaikan Ukuran Tombol Role agar Muat di Layar HP */
            .role-tile {
                padding: 12px 2px; /* Padding kiri kanan dikurangi */
                border-radius: 8px;
            }
            
            .role-tile i {
                font-size: 1.2rem; /* Icon dibuat lebih kecil */
                margin-bottom: 4px;
            }
            
            .role-tile span {
                font-size: 0.65rem; /* Font teks dibuat lebih kecil agar tidak turun baris */
                letter-spacing: 0;
                line-height: 1.2;
            }

            /* 5. Form adjustments */
            .form-group-modern {
                margin-bottom: 15px;
            }
            
            .modern-input {
                padding: 12px 10px 12px 45px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h1><i class="fas fa-graduation-cap"></i> E-Absensi</h1>
                <p>Sistem Absensi Digital Terpadu</p>
            </div>

            <div class="login-body">
                <!-- Error Alert -->
                @if(session('error'))
                    <div class="soft-alert error-alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <div class="alert-body">
                            <strong>Gagal!</strong>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <form action="/login" method="POST">
                    @csrf

                    <!-- Hidden Role -->
                    <input type="hidden" name="role" id="selected-role" value="admin">

                    <!-- Role Selector (Modern Tiles) -->
                    <div class="role-selector-grid">
                        <!-- 1. Admin -->
                        <div class="role-tile active" onclick="selectRole('admin')">
                            <i class="fas fa-user-shield"></i>
                            <span>Admin</span>
                        </div>
                        <!-- 2. Guru -->
                        <div class="role-tile" onclick="selectRole('guru')">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Guru</span>
                        </div>
                        <!-- 3. Siswa -->
                        <div class="role-tile" onclick="selectRole('siswa')">
                            <i class="fas fa-user-graduate"></i>
                            <span>Siswa</span>
                        </div>
                    </div>

                    <!-- Identifier Input -->
                    <div class="form-group-modern">
                        <label for="identifier" id="identifier-label">Email</label>
                        <div class="input-group-modern">
                            <div class="input-icon-wrapper icon-purple" id="identifier-icon-wrapper">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="text" id="identifier" name="identifier" class="modern-input" placeholder="contoh@admin.com" required>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="form-group-modern">
                        <label for="password">Password</label>
                        <div class="input-group-modern">
                            <div class="input-icon-wrapper" style="background: #cbd5e1;">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" id="password" name="password" class="modern-input" placeholder="Masukkan password" required>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn-modern">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </button>

                    <!-- Footer -->
                    <div class="login-footer">
                        <a href="https://wa.me/6285147618224" target="_blank" class="footer-link">
                                Lupa Password?
                        </a>

                        <div class="divider">
                            <span>Atau</span>
                        </div>
                        <span>Belum Punya Akun?</span>
                       <a href="https://wa.me/6285147618224" target="_blank" class="footer-link">
        Hubungi Administrator
    </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleOptions = document.querySelectorAll('.role-tile');
            const identifierInput = document.getElementById('identifier');
            const identifierLabel = document.getElementById('identifier-label');
            const iconWrapper = document.getElementById('identifier-icon-wrapper');
            const icon = iconWrapper.querySelector('i');
            const selectedRoleInput = document.getElementById('selected-role');

            // Set default active tile (Admin in HTML)
            // Pastikan 'admin' tile punya class active di HTML
            
            roleOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all
                    roleOptions.forEach(opt => opt.classList.remove('active'));
                    // Add active class to clicked
                    this.classList.add('active');

                    // Get role from onclick attribute
                    const match = this.getAttribute('onclick').match(/'([^']+)'/);
                    const selectedRole = match ? match[1] : 'admin';
                    
                    selectedRoleInput.value = selectedRole;

                    switch(selectedRole) {
                        case 'admin':
                            identifierLabel.textContent = 'Email Administrator';
                            identifierInput.type = 'email';
                            identifierInput.placeholder = 'contoh@admin.com';
                            icon.className = 'fas fa-envelope';
                            iconWrapper.className = 'input-icon-wrapper icon-purple';
                            break;
                        case 'guru':
                            identifierLabel.textContent = 'Nomor Induk Pegawai (NIP)';
                            identifierInput.type = 'text';
                            identifierInput.placeholder = 'Masukkan NIP';
                            icon.className = 'fas fa-id-badge';
                            iconWrapper.className = 'input-icon-wrapper icon-indigo';
                            break;
                        case 'siswa':
                            identifierLabel.textContent = 'Nomor Induk Siswa (NIS)';
                            identifierInput.type = 'text';
                            identifierInput.placeholder = 'Masukkan NIS';
                            icon.className = 'fas fa-user-graduate';
                            iconWrapper.className = 'input-icon-wrapper icon-blue';
                            break; 
                    }
                });
            });
        });
    </script>
</body>
</html>