@extends('template')

@section('content')
<div class="row mt-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>CRUD Ruangan</h2>
            <div>
            <a class="btn btn-success" href="{{ route('ruangan.create') }}">Tambah Ruangan</a>
                <a class="btn btn-danger" href="{{ route('home') }}">Kembali</a>
            </div>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p class="mb-0">{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Form Filter -->
<form method="GET" action="{{ route('ruangan.index') }}">
    <div class="row mt-3 mb-3">
        <div class="col">
            <input type="text" name="kodeRuangan" class="form-control" placeholder="Filter Kode Ruangan" value="{{ request('kodeRuangan') }}">
        </div>
        <div class="col">
            <input type="text" name="namaRuangan" class="form-control" placeholder="Filter Nama Ruangan" value="{{ request('namaRuangan') }}">
        </div>
        <div class="col">
            <input type="number" name="dayaTampung" class="form-control" placeholder="Filter Daya Tampung" value="{{ request('dayaTampung') }}">
        </div>
        <div class="col">
            <input type="text" name="lokasi" class="form-control" placeholder="Filter Lokasi" value="{{ request('lokasi') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<!-- Tabel Ruangan -->
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th width="50px" class="text-center">No</th>
            <th>Kode Ruangan</th>
            <th>Nama Ruangan</th>
            <th>Daya Tampung</th>
            <th>Lokasi</th>
            <th width="200px" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ruangan as $index => $item)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $item->kodeRuangan }}</td>
            <td>{{ $item->namaRuangan }}</td>
            <td>{{ $item->dayaTampung }}</td>
            <td>{{ $item->lokasi }}</td>
            <td class="text-center">
                <a class="btn btn-info btn-sm" href="{{ route('ruangan.show', $item->id) }}">Show</a>
                <a class="btn btn-primary btn-sm" href="{{ route('ruangan.edit', $item->id) }}">Edit</a>
                <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {!! $ruangan->links('pagination::bootstrap-5') !!}
</div>
@endsection