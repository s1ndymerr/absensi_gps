@extends('layouts.Siswa')

@section('content')
<div class="container">
    <h3>Riwayat Absensi</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Jarak (m)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensis as $a)
            <tr>
                <td>{{ $a->tanggal }}</td>
                <td>{{ $a->jam_masuk ?? '-' }}</td>
                <td>{{ $a->jam_pulang ?? '-' }}</td>
                <td>{{ $a->jarak_meter ?? '-' }}</td>
                <td>{{ ucfirst($a->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $absensis->links() }}
</div>
@endsection
