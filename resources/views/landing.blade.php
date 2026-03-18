<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi GPS | SMKN 1 Kawali</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            /* Palette Identik dengan Dashboard */
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
            --color-teal: #14b8a6;
            
            /* Shadows */
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);

            /* Radius */
            --radius-lg: 24px;
            --radius-xl: 32px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        /* --- Background Decorations (Orbs) --- */
        .bg-orb {
            position: absolute;
            border-radius: 50%;
            z-index: 0;
            opacity: 0.6;
            filter: blur(60px);
            animation: float 6s ease-in-out infinite;
        }
        .orb-1 {
            width: 400px;
            height: 400px;
            background: var(--secondary-soft);
            top: -100px;
            left: -100px;
        }
        .orb-2 {
            width: 300px;
            height: 300px;
            background: var(--primary-soft);
            bottom: -50px;
            right: -50px;
            animation-delay: 2s;
        }

        /* --- Main Container (Glass Card) --- */
        .landing-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1000px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-2xl);
            padding: 60px;
            display: flex;
            align-items: center;
            gap: 60px;
            width: 100%;
            overflow: hidden;
        }

        /* --- Left Content (Text) --- */
        .content-left {
            flex: 1;
        }

        .school-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .main-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.1;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--text-main), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sub-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 30px;
        }

        .description {
            font-size: 1.1rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 500px;
        }

        /* --- Features Grid (Inside Landing) --- */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 10px;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            background: var(--bg-body);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .feat-blue { background: linear-gradient(135deg, #6366f1, #818cf8); }
        .feat-teal { background: linear-gradient(135deg, #14b8a6, #2dd4bf); }
        .feat-purple { background: linear-gradient(135deg, #a855f7, #d8b4fe); }

        .feature-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
        }

        /* --- Button --- */
        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 40px;
            background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(99, 102, 241, 0.5);
        }

        /* --- Right Content (Visual Graphic) --- */
        .content-right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .mockup-card {
            width: 280px;
            height: 520px;
            background: white;
            border-radius: 32px;
            border: 8px solid #1e293b;
            position: relative;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            z-index: 2;
            animation: float 5s ease-in-out infinite;
        }

        /* Header Mockup */
        .mockup-header {
            height: 60px;
            background: var(--bg-body);
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border-soft);
        }
        .mockup-notch {
            width: 100px;
            height: 20px;
            background: #1e293b;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        /* Body Mockup */
        .mockup-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .mockup-line {
            height: 12px;
            background: var(--bg-body);
            border-radius: 6px;
            width: 100%;
        }
        .mockup-line.short { width: 60%; }
        
        .mockup-map-placeholder {
            height: 150px;
            background: #e0e7ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-soft);
            font-size: 2rem;
        }

        /* Circle behind mockup */
        .deco-circle {
            position: absolute;
            z-index: 1;
            border-radius: 50%;
        }
        .deco-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7); /* Green Tealish */
            top: 50px;
            right: -50px;
        }
        .deco-2 {
            width: 100px;
            height: 100px;
            background: #fef3c7; /* Yellow */
            bottom: 100px;
            left: 20px;
        }

        /* --- Animations --- */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* --- Responsive --- */
        @media (max-width: 992px) {
            .glass-card {
                flex-direction: column;
                text-align: center;
                padding: 40px 30px;
                max-width: 600px;
            }
            .content-left {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .features-grid {
                width: 100%;
            }
            .content-right {
                display: none; /* Hide mockup on tablets */
            }
        }

        @media (max-width: 480px) {
            .landing-wrapper {
                padding: 15px;
            }
            .glass-card {
                padding: 30px 20px;
            }
            .main-title {
                font-size: 2.5rem;
            }
            .sub-title {
                font-size: 1.2rem;
            }
            .features-grid {
                grid-template-columns: 1fr; /* Stack features */
                gap: 30px;
            }
            .feature-item {
                flex-direction: row;
                justify-content: flex-start;
                text-align: left;
            }
            .btn-login {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- Background Decorations -->
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>

    <div class="landing-wrapper">
        <div class="glass-card">
            
            <!-- Left Side: Content -->
            <div class="content-left">
                <div class="school-badge">
                    <i class="fas fa-graduation-cap"></i> SMKN 1 Kawali
                </div>
                
                <h1 class="main-title">Sistem Absensi GPS</h1>
                <h2 class="sub-title">Digitalisasi Kehadiran Sekolah</h2>
                
                <p class="description">
                    Solusi cerdas berbasis lokasi (GPS) dan Waktu Real-time untuk meningkatkan akurasi presensi, kedisiplinan siswa, dan memudahkan monitoring guru secara efektif.
                </p>

                <!-- Features Grid -->
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon feat-blue">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span class="feature-text">Lokasi Akurat</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon feat-teal">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="feature-text">Waktu Real-time</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon feat-purple">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="feature-text">Laporan Otomatis</span>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk ke Sistem</span>
                </a>
            </div>

            <!-- Right Side: Visual Mockup (Pure CSS) -->
            <div class="content-right">
                <div class="deco-circle deco-1"></div>
                <div class="deco-circle deco-2"></div>
                
                <!-- Phone Mockup Representation -->
                <div class="mockup-card">
                    <div class="mockup-header">
                        <div class="mockup-notch"></div>
                    </div>
                    <div class="mockup-body">
                        <div class="mockup-map-placeholder">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div class="mockup-line"></div>
                        <div class="mockup-line short"></div>
                        <div class="mockup-line"></div>
                        <div class="mockup-line short"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>