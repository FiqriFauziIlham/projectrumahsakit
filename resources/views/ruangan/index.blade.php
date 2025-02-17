@extends('template')

@section('content')

<div class="row mt-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>CRUD RUANGAN</h2>
            <div>
                <a class="btn btn-success" href="{{ route('ruangan.create') }}">Input Ruangan</a>
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

<table class="table table-bordered mt-3">
    <thead class="table-dark">
        <tr>
            <th width="50px" class="text-center">No</th>
            <th>Kode Ruangan</th>
            <th class="text-center">Nama Ruangan</th>
            <th class="text-center">Daya Tampung</th>
            <th class="text-center">Lokasi</th>
            <th width="200px" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ruangan as $index => $r)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $r->kodeRuangan }}</td>
            <td>{{ $r->namaRuangan }}</td>
            <td class="text-center">{{ $r->dayaTampung }}</td>
            <td>{{ $r->lokasi }}</td>
            <td class="text-center">
                <a class="btn btn-info btn-sm" href="{{ route('ruangan.show', $r->id) }}">Show</a>
                <a class="btn btn-primary btn-sm" href="{{ route('ruangan.edit', $r->id) }}">Edit</a>
                <form action="{{ route('ruangan.destroy', $r->id) }}" method="POST" class="d-inline">
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
    {!! $ruangan->links('pagination::bootstrap-5') !!}
</div>

@endsection
