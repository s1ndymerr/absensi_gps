<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #e0e7ff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9; /* Latar belakang abu-abu soft */
            margin: 0;
            padding: 20px;
            color: var(--text-dark);
            -webkit-print-color-adjust: exact;
        }

        /* --- Paper Container (A4 Style) --- */
        .paper-container {
            background: white;
            max-width: 210mm; /* Lebar A4 */
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-radius: 4px;
            min-height: 297mm; /* Tinggi A4 minimum */
        }

        /* --- Report Header --- */
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 20px;
        }

        .report-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary);
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .report-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        /* --- Info / Metadata Box --- */
        .info-box {
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .info-item {
            font-size: 14px;
            color: var(--text-dark);
        }

        .info-item strong {
            color: var(--text-muted);
            margin-right: 8px;
            font-weight: 600;
        }

        /* --- Table Styling --- */
        h4.section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 25px 0 15px 0;
            padding-left: 10px;
            border-left: 4px solid var(--primary);
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px; /* Font size standar cetak */
        }

        thead tr {
            background-color: var(--primary-light);
            color: var(--text-dark);
        }

        th {
            padding: 12px 10px;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            border-bottom: 2px solid var(--primary);
        }

        th.text-center, td.text-center {
            text-align: center;
        }
        
        th.text-right, td.text-right {
            text-align: right;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid var(--border);
            color: var(--text-dark);
            vertical-align: middle;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa; /* Zebra striping halus */
        }
        
        tbody tr:hover {
            background-color: #f1f5f9;
        }

        /* --- Status Badges in Print --- */
        .status-hadir { color: var(--success); font-weight: 700; }
        .status-izin { color: var(--warning); font-weight: 700; }
        .status-alpha { color: var(--danger); font-weight: 700; }

        /* --- Footer --- */
        .report-footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* --- PRINT MEDIA QUERY --- */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .paper-container {
                box-shadow: none;
                margin: 0;
                width: 100%;
                max-width: 100%;
                padding: 0;
                min-height: auto;
            }
            .info-box {
                border: 1px solid #ccc; /* Pasti terlihat saat print */
                background: transparent;
            }
            /* Pastikan warna teks tetap tercetak dengan baik */
            thead tr {
                background-color: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            tbody tr:nth-child(even) {
                background-color: #f9f9f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

<div class="paper-container">

    <!-- Report Header -->
    <div class="report-header">
        <h1 class="report-title">Laporan Kehadiran</h1>
        <p class="report-subtitle">Sistem Absensi Sekolah</p>
    </div>

    <!-- Info Filter -->
    <div class="info-box">
        <div class="info-item">
            <strong>Tanggal:</strong> {{ $tanggal }}
        </div>
        <div class="info-item">
            <strong>Jenis:</strong> {{ strtoupper($tipe) }}
        </div>
        @if($tipe == 'siswa')
            @if(isset($jurusan) && $jurusan)
            <div class="info-item">
                <strong>Jurusan:</strong> {{ $jurusan }}
            </div>
            @endif
            @if(isset($kelas) && $kelas)
            <div class="info-item">
                <strong>Kelas:</strong> {{ $kelas }}
            </div>
            @endif
        @endif
    </div>

    {{-- ===================== SISWA ===================== --}}
   @if($tipe == 'siswa')

    {{-- ================= RINGKASAN ================= --}}
    @if($mode !== 'detail')
    <h4 class="section-title">Ringkasan Per Kelas</h4>
    <table>
        <thead>
            <tr>
                <th>Kelas</th>
                <th class="text-center">Hadir</th>
                <th class="text-center">Izin</th>
                <th class="text-center">Alpha</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekap_per_kelas as $k => $v)
            <tr>
                <td>{{ $k }}</td>
                <td class="text-center">{{ $v['hadir'] }}</td>
                <td class="text-center">{{ $v['izin'] }}</td>
                <td class="text-center">{{ $v['alpha'] }}</td>
                <td class="text-center">{{ $v['total'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endif


    {{-- ================= DETAIL ================= --}}
    @if($mode !== 'ringkasan')
    <h4 class="section-title">Data Absensi Siswa</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekap_siswa as $i => $s)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $s['nama'] }}</td>
                <td>{{ $s['kelas'] }}</td>
                <td>{{ $s['jurusan'] }}</td>
                <td>{{ ucfirst($s['status']) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endif

@endif


{{-- ===================== GURU ===================== --}}
@if($tipe == 'guru')

    <h4 class="section-title">Data Absensi Guru</h4>
    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama Guru</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekap_guru as $i => $g)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $g['nama'] }}</td>
                <td class="text-center">{{ ucfirst($g['status']) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">
                    Tidak ada data absensi guru
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

@endif


    <!-- Footer Tanda Tangan -->
    <div class="report-footer">
        <div>
            <p>Mengetahui,</p>
            <br><br>
            <p>_________________</p>
            <p>Kepala Sekolah</p>
        </div>
        <div style="text-align: right;">
            <p>Dicetak Tanggal,</p>
            <p>{{ now()->format('d F Y') }}</p>
        </div>
    </div>

</div>

</body>
</html>