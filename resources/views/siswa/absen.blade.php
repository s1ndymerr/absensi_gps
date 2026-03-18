@extends('layouts.siswa')

@section('content')
<div class="container mt-4">

    <h3>Absensi Siswa</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card p-4">

        <button class="btn btn-primary mb-3" onclick="getLocation()">Klik Lokasi</button>

        <form id="absenMasukForm" method="POST" action="{{ route('siswa.absensi.masuk') }}">
            @csrf
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <button class="btn btn-success" {{ $absen && $absen->jam_masuk ? 'disabled' : '' }}>
                Absen Masuk
            </button>
        </form>

        <form id="absenPulangForm" method="POST" action="{{ route('siswa.absensi.pulang') }}" class="mt-3">
            @csrf
            <input type="hidden" id="latitude2" name="latitude">
            <input type="hidden" id="longitude2" name="longitude">

            <button class="btn btn-danger" {{ !$absen || ($absen && $absen->jam_pulang) ? 'disabled' : '' }}>
                Absen Pulang
            </button>
        </form>

    </div>
</div>

<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {

            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;

            document.getElementById('latitude2').value = position.coords.latitude;
            document.getElementById('longitude2').value = position.coords.longitude;

            alert("Lokasi berhasil diambil!");

        }, function() {
            alert("Gagal mengambil lokasi, izinkan lokasi pada browser.");
        });
    }
}
</script>

@endsection
