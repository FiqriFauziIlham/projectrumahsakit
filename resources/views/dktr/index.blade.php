@extends('template')

@section('content')

<div class="row mt-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>CRUD DOCTOR</h2>
            <div>
                <a class="btn btn-success" href="{{ route('dktr.create') }}">Input Dokter</a>
                <a class="btn btn-danger" href="{{ route('home') }}">Kembali</a>
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
<form method="GET" action="{{ route('dktr.index') }}">
    <div class="row mt-3">
        <div class="col">
            <input type="text" name="idDokter" class="form-control" placeholder="Filter ID Dokter" value="{{ request('idDokter') }}">
        </div>
        <div class="col">
            <input type="text" name="namaDokter" class="form-control" placeholder="Filter Nama Dokter" value="{{ request('namaDokter') }}">
        </div>
        <div class="col">
            <input type="date" name="tanggalLahir" class="form-control" placeholder="Filter Tanggal Lahir" value="{{ request('tanggalLahir') }}">
        </div>
        <div class="col">
            <input type="text" name="spesialisasi" class="form-control" placeholder="Filter Spesialisasi" value="{{ request('spesialisasi') }}">
        </div>
        <div class="col">
            <input type="text" name="lokasiPraktik" class="form-control" placeholder="Filter Lokasi" value="{{ request('lokasiPraktik') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<table class="table table-bordered mt-3">
    <thead class="table-dark">
        <tr>
            <th>ID Dokter</th>
            <th class="text-center">Nama Dokter</th>
            <th class="text-center">Tanggal Lahir</th>
            <th class="text-center">Spesialisasi</th>
            <th class="text-center">Lokasi</th>
            <th width="200px" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dktr as $index => $dokter)
        <tr>
            <td>{{ $dokter->idDokter }}</td>
            <td>{{ $dokter->namaDokter }}</td>
            <td>{{ $dokter->tanggalLahir }}</td>
            <td>{{ $dokter->spesialisasi }}</td>
            <td>{{ $dokter->lokasiPraktik }}</td>
            <td class="text-center">
                <a class="btn btn-info btn-sm" href="{{ route('dktr.show', $dokter->id) }}">Show</a>
                <a class="btn btn-primary btn-sm" href="{{ route('dktr.edit', $dokter->id) }}">Edit</a>
                <form action="{{ route('dktr.destroy', $dokter->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Bootstrap 5 Pagination -->
<div class="d-flex justify-content-center">
    {!! $dktr->links('pagination::bootstrap-5') !!}
</div>

@endsection
