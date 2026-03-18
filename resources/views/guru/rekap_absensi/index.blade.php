@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-3">Rekap Absensi Siswa</h4>

    {{-- Filter tanggal --}}
    <form method="GET" class="mb-3">
        <input type="date" name="tanggal" value="{{ $tanggal }}">
        <button class="btn btn-primary btn-sm">Tampilkan</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $no => $s)
                @php
                    $a = $absensi[$s->id] ?? null;
                @endphp
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->kelas ?? '-' }}</td>
                    <td>
                        @if($a)
                            {{ ucfirst($a->status) }}
                        @else
                            <span class="text-danger">Belum Absen</span>
                        @endif
                    </td>
                    <td>{{ $a->jam_masuk ?? '-' }}</td>
                    <td>{{ $a->jam_pulang ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection 