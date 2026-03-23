@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('admin.siswa.index') }}"
       class="btn btn-secondary mb-3">
        ← Kembali
    </a>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Detail Siswa</strong>
        </div>
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr>
                    <th width="200">Nama</th>
                    <td>{{ $siswa->name }}</td>
                </tr>
                <tr>
                    <th>NIS</th>
                    <td>{{ $siswa->siswa->nis ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $siswa->email }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $siswa->siswa->kelas ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Riwayat Absensi</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr class="text-center">
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensis as $absen)
                        <tr class="text-center">
                            <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $absen->status == 'hadir' ? 'success' :
                                    ($absen->status == 'izin' ? 'warning' :
                                    ($absen->status == 'sakit' ? 'info' : 'secondary'))
                                }}">
                                    {{ ucfirst($absen->status) }}
                                </span>
                            </td>
                            <td>{{ $absen->jam_masuk ?? '-' }}</td>
                            <td>{{ $absen->jam_pulang ?? '-' }}</td>
                            <td>{{ $absen->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection