@extends('template')

@section('content')

<div class="row mt-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>CRUD PASIEN</h2>
            <div>
                <a class="btn btn-success btn-sm" href="{{ route('pasien.create') }}">Input Pasien</a>
                <a class="btn btn-danger btn-sm" href="{{ route('home') }}">Kembali</a>
            </div>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <p class="mb-0">{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Filter Form -->
<form method="GET" action="{{ route('pasien.index') }}">
    <div class="row mt-3">
        <div class="col">
            <input type="number" name="NomorRekamMedis" class="form-control form-control-sm" placeholder="Filter Nomor Rekam Medis" value="{{ request('NomorRekamMedis') }}">
        </div>
        <div class="col">
            <input type="text" name="namaPasien" class="form-control form-control-sm" placeholder="Filter Nama Pasien" value="{{ request('namaPasien') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </div>
    </div>
</form>

<!-- Tabel Pasien -->
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped table-sm text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>No. Rekam Medis</th>
                <th>Nama</th>
                <th>Tgl Lahir</th>
                <th>Usia</th>
                <th>Gender</th>
                <th>Penyakit</th>
                <th>Dokter</th>
                <th>Ruangan</th>
                <th>Tgl Masuk</th>
                <th>Tgl Keluar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pasiens as $pasien)
            <tr>
                <td>{{ $pasien->NomorRekamMedis }}</td>
                <td>{{ $pasien->namaPasien }}</td>
                <td>{{ $pasien->tanggalLahir }}</td>
                <td>{{ $pasien->usiaPasien }}</td>
                <td>{{ $pasien->jenisKelamin }}</td>
                <td>{{ $pasien->penyakitPasien }}</td>
                <td>{{ $pasien->dokter->namaDokter }}</td>
                <td>{{ $pasien->ruangan->namaRuangan }}</td>
                <td>{{ $pasien->tanggalMasuk }}</td>
                <td>{{ $pasien->tanggalKeluar }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-1">
                        <a class="btn btn-info btn-sm" href="{{ route('pasien.show', $pasien->id) }}">Show</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('pasien.edit', $pasien->id) }}">Edit</a>
                        <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {!! $pasiens->links('pagination::bootstrap-5') !!}
</div>

@endsection
