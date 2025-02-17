@extends('template')

@section('content')

<div class="row mt-5 mb-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Edit Data Ruangan</h2>
            <a class="btn btn-secondary" href="{{ route('ruangan.index') }}">Kembali</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Whoops!</strong> Terjadi kesalahan saat input data.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('ruangan.update', $ruangan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-12 mb-3">
            <label for="kodeRuangan" class="form-label"><strong>Kode Ruangan:</strong></label>
            <input type="text" id="kodeRuangan" name="kodeRuangan" class="form-control" value="{{ $ruangan->kodeRuangan }}">
        </div>

        <div class="col-12 mb-3">
            <label for="namaRuangan" class="form-label"><strong>Nama Ruangan:</strong></label>
            <input type="text" id="namaRuangan" name="namaRuangan" class="form-control" value="{{ $ruangan->namaRuangan }}">
        </div>

        <div class="col-12 mb-3">
            <label for="dayaTampung" class="form-label"><strong>Daya Tampung:</strong></label>
            <input type="number" id="dayaTampung" name="dayaTampung" class="form-control" value="{{ $ruangan->dayaTampung }}">
        </div>

        <div class="col-12 mb-3">
            <label for="lokasi" class="form-label"><strong>Lokasi:</strong></label>
            <input type="text" id="lokasi" name="lokasi" class="form-control" value="{{ $ruangan->lokasi }}">
        </div>

        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>
</form>

@endsection
