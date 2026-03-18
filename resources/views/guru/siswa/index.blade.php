@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3">Daftar Siswa</h4>

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswas as $siswa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $siswa->name }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->email }}</td>
                        <td>
                <a href="{{ route('admin.guru.siswa.show', $siswa->id) }}"
   class="btn btn-info btn-sm">
   Detail
</a>


                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
