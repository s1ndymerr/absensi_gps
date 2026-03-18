@extends('layouts.app')

{{-- Section Styles (CSS Leaflet & Custom Android CSS) --}}
@push('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>

    <style>
        /* 
           CSS KHUSUS ANDROID / MOBILE VIEW 
           Tidak mempengaruhi tampilan desktop
        */
        @media (max-width: 768px) {
            /* Container & Card */
            .container {
                padding: 0 !important; /* Full width di mobile */
                max-width: 100%;
            }
            .card {
                border: none;
                border-radius: 0;
                box-shadow: none;
                margin-bottom: 0;
            }
            .card-header {
                background-color: #ffffff;
                padding: 20px 20px 10px 20px;
                border-bottom: none;
            }
            .card-header h4 {
                font-size: 1.4rem;
                font-weight: 800;
                margin: 0;
                color: #1e293b;
            }
            .card-body {
                padding: 20px;
                padding-bottom: 40px; /* Ruang ekstra di bawah */
            }

            /* Inner Card (Map Wrapper) */
            .card.mt-4 {
                border-radius: 16px !important; /* Rounded card untuk map */
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                border: 1px solid #e2e8f0;
                margin-top: 20px;
            }
            .card.mt-4 .card-header {
                padding: 15px 20px;
                background: transparent;
            }
            .card.mt-4 .card-header h5 {
                font-size: 1rem;
                font-weight: 700;
                margin: 0;
            }
            .card.mt-4 .card-body {
                padding: 0 15px 20px 15px;
            }

            /* Input Styling */
            .form-label {
                font-weight: 600;
                font-size: 0.9rem;
                color: #64748b;
                margin-bottom: 8px;
            }
            .form-control {
                font-size: 16px !important; /* Mencegah zoom saat input di Android */
                padding: 12px 15px !important;
                border-radius: 10px !important;
                border: 1px solid #cbd5e1 !important;
                background-color: #fff;
                height: auto; /* Reset default height bootstrap */
                line-height: 1.5;
            }
            
            /* Readonly input style (Nama Lokasi) */
            .form-control[readonly] {
                background-color: #f1f5f9;
                color: #475569;
                cursor: not-allowed;
                font-weight: 500;
            }

            /* Map Styling */
            #map {
                height: 300px; /* Tinggi map yang nyaman di HP */
                width: 100%;
                border-radius: 12px;
                border: 1px solid #cbd5e1;
                z-index: 1;
            }

            /* Button Styling */
            .btn-primary {
                width: 100%; /* Full width tombol */
                padding: 14px;
                font-size: 1rem;
                font-weight: 700;
                border-radius: 12px;
                box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-top: 10px;
            }

            /* Row Margin di Mobile */
            .row {
                margin-left: -10px;
                margin-right: -10px;
            }
            .col-md-6 {
                padding-left: 10px;
                padding-right: 10px;
                margin-bottom: 15px; /* Jarak antar lat/long */
            }
        }
    </style>
@endpush

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-header">
                    <h4>Tambah Lokasi GPS</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.lokasi.store')}}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" id="nama_lokasi"
       class="form-control @error('nama_lokasi') is-invalid @enderror"
       value="{{ old('nama_lokasi') }}" readonly required>
                            @error('nama_lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h5>Pilih Titik Lokasi di Map</h5>
                            </div>

                            <div class="card-body">

                                <!-- MAP -->
                                <div id="map"></div>

                                <!-- LAT LONG -->
                                <div class="row mt-3">

                                    <div class="col-md-6">
                                        <label>Latitude</label>
                                        <input type="text" name="latitude" id="latitude"
                                               class="form-control @error('latitude') is-invalid @enderror" 
                                               value="{{ old('latitude') }}" required>
                                               @error('latitude')
                                                   <div class="invalid-feedback">{{ $message }}</div>
                                               @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label>Longitude</label>
                                        <input type="text" name="longitude" id="longitude"
                                               class="form-control @error('longitude') is-invalid @enderror" 
                                               value="{{ old('longitude') }}" required>
                                               @error('longitude')
                                                   <div class="invalid-feedback">{{ $message }}</div>
                                               @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-4" type="submit">
                            Simpan
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

{{-- Section Scripts (JS Leaflet) --}}
@section('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {

        let latInput = document.getElementById('latitude');
        let lngInput = document.getElementById('longitude');
        let namaLokasiInput = document.getElementById('nama_lokasi');

        // Biar field nama lokasi bisa diketik (tanpa ubah HTML)
namaLokasiInput.removeAttribute('readonly');

// ===============================
// SEARCH LOKASI DARI INPUT TEXT
// ===============================
let typingTimer;
const doneTypingInterval = 600; // delay 0.6 detik setelah berhenti ngetik

namaLokasiInput.addEventListener('input', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
        const query = namaLokasiInput.value.trim();
        if (query.length < 3) return; // minimal 3 huruf

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    const result = data[0]; // ambil hasil pertama
                    const lat = parseFloat(result.lat);
                    const lon = parseFloat(result.lon);

                    // Pindahkan map & marker
                    map.setView([lat, lon], 15);
                    marker.setLatLng([lat, lon]);

                    // Set input lat long
                    latInput.value = lat;
                    lngInput.value = lon;
                }
            })
            .catch(err => console.error('Search error:', err));
    }, doneTypingInterval);
});


        let lat = latInput.value;
        let lng = lngInput.value;

        if (!lat || !lng) {
            lat = -7.304599;
            lng = 108.269771;
        }

        const map = L.map('map', {
            dragging: true,
            scrollWheelZoom: true,
            doubleClickZoom: true,
            touchZoom: true
        }).setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        // 🔥 FIX MAP SIZE (Penting agar map tidak abu-abu di layout CSS yang rumit)
        setTimeout(() => {
            map.invalidateSize();
        }, 300);

        function getAddress(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    if (data.display_name) {
                        namaLokasiInput.value = data.display_name;
                    }
                });
        }

        getAddress(lat, lng);

        marker.on('dragend', function () {
            const pos = marker.getLatLng();
            latInput.value = pos.lat;
            lngInput.value = pos.lng;
            getAddress(pos.lat, pos.lng);
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat;
            lngInput.value = e.latlng.lng;
            getAddress(e.latlng.lat, e.latlng.lng);
        });

    });
    </script>
@endsection