@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Validasi Izin / Sakit Siswa</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Alasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($pengajuan as $p)
            <tr>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->tanggal }}</td>
                <td>{{ ucfirst($p->status) }}</td>
                <td>{{ $p->alasan }}</td>
                <td>
                    <form method="POST" action="{{ route('guru.validasi.setujui', $p->id) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Setujui</button>
                    </form>
                    <form method="POST" action="{{ route('guru.validasi.tolak', $p->id) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-danger btn-sm">Tolak</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada pengajuan</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
