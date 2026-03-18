@extends('layouts.app')

{{-- CSS Styles --}}
@push('styles')
    <!-- Leaflet CSS (Wajib agar map muncul) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>

    <style>
        /* CSS Umum (Fix Tinggi Map Desktop) */
        #map {
            height: 400px;
            width: 100%;
            z-index: 1;
        }

        /* Style Tombol Umum */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px; /* Padding standar (tidak full/besar) */
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
            text-align: center;
        }

        /* Tombol Utama (Update) */
        .btn-primary {
            background-color: #3b82f6;
            color: white;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
        }
        .btn-primary:hover { background-color: #2563eb; }

        /* Tombol Sekunder (Batal) */
        .btn-secondary {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }
        .btn-secondary:hover { background-color: #e2e8f0; color: #475569; }

        /* Wrapper Tombol agar berdampingan */
        .button-actions {
            display: flex;
            gap: 10px; /* Jarak antara tombol */
            margin-top: 15px;
        }

        /* 
           CSS KHUSUS ANDROID / MOBILE VIEW
        */
        @media (max-width: 768px) {
            /* Layout Full Width */
            .container {
                padding: 0 !important;
                max-width: 100%;
            }

            /* Styling Judul */
            h2 {
                font-size: 1.5rem;
                font-weight: 800;
                padding: 20px 20px 10px 20px;
                margin: 0;
                color: #1e293b;
                background: #fff;
                border-bottom: 1px solid #f1f5f9;
            }

            /* Styling Form Wrapper */
            form {
                padding: 20px;
                padding-bottom: 40px; /* Ruang ekstra di bawah */
                background: #fff;
            }

            /* Label Input */
            label {
                font-weight: 600;
                font-size: 0.9rem;
                color: #64748b;
                margin-bottom: 8px;
                display: block;
            }

            /* Input Fields */
            .form-control {
                font-size: 16px !important; /* Mencegah zoom saat input di Android */
                padding: 12px 15px !important;
                border-radius: 10px !important;
                border: 1px solid #cbd5e1 !important;
                background-color: #fff;
                margin-bottom: 15px;
                width: 100%;
                box-sizing: border-box;
            }

            /* Styling Peta (Map) */
            #map {
                height: 300px !important; /* Tinggi ideal untuk HP */
                border-radius: 12px !important;
                border: 1px solid #e2e8f0;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                margin-bottom: 15px;
            }

            /* Paragraf Keterangan Map */
            p b {
                display: block;
                font-size: 0.9rem;
                color: #475569;
                margin-bottom: 10px;
            }

            /* Styling Wrapper Tombol (Mobile) */
            .button-actions {
                /* Buttons tetap berdampingan (flex row) tapi ukurannya kecil */
                display: flex;
                flex-direction: row;
                gap: 10px;
                justify-content: flex-start; /* Rata Kiri */
            }
        }
    </style>
@endpush

@section('content')
<div class="container">
    <h2>Edit Lokasi</h2>

    <form action="{{ route('admin.lokasi.update', $lokasi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Lokasi</label>
            <input type="text" name="nama_lokasi" class="form-control" value="{{ $lokasi->nama_lokasi }}" required>
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input id="latitude" type="text" name="latitude" class="form-control" value="{{ $lokasi->latitude }}" required>
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input id="longitude" type="text" name="longitude" class="form-control" value="{{ $lokasi->longitude }}" required>
        </div>

        <p><b>Klik pada map untuk mengubah titik lokasi:</b></p>
        <div id="map"></div>

        <!-- Wrapper Tombol (Kecil & Berdampingan) -->
        <div class="button-actions">
            <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

@endsection

{{-- Scripts JS --}}
@section('scripts')
    <!-- Leaflet JS (Wajib agar map berfungsi) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
    // Map mulai dari titik lokasi yg sudah tersimpan
    var map = L.map('map').setView([{{ $lokasi->latitude }}, {{ $lokasi->longitude }}], 15);

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    // Marker awal
    var marker = L.marker([{{ $lokasi->latitude }}, {{ $lokasi->longitude }}]).addTo(map);

    // Saat map diklik
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
    });

    // 🔥 FIX MAP SIZE (Penting untuk layout CSS mobile)
    setTimeout(() => {
        map.invalidateSize();
    }, 300);
    </script>
@endsection