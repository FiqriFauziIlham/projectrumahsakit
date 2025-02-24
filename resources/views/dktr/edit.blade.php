@extends('template')

@section('content')

<div class="row mt-5 mb-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Edit Data Dokter</h2>
            <a class="btn btn-secondary" href="{{ route('dktr.index') }}">Kembali</a>
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

<form action="{{ route('dktr.update', $dktr->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-12 mb-3">
            <label for="idDokter" class="form-label"><strong>ID Dokter:</strong></label>
            <input type="text" id="idDokter" name="idDokter" class="form-control" value="{{ $dktr->idDokter }}">
        </div>

        <div class="col-12 mb-3">
            <label for="namaDokter" class="form-label"><strong>Nama Dokter:</strong></label>
            <input type="text" id="namaDokter" name="namaDokter" class="form-control" value="{{ $dktr->namaDokter }}">
        </div>

        <div class="col-12 mb-3">
            <label for="tanggalLahir" class="form-label"><strong>Tanggal Lahir:</strong></label>
            <input type="date" id="tanggalLahir" class="form-control" name="tanggalLahir" value="{{ $dktr->tanggalLahir }}">
        </div>

        <div class="col-12 mb-3">
            <label for="spesialisasi" class="form-label"><strong>Spesialisasi:</strong></label>
            <select id="spesialisasi" class="form-select" name="spesialisasi">
                <option>- Pilih Spesialisasi -</option>
                @foreach (['Poli Umum', 'Poli Anak', 'Poli Gigi', 'Poli Mata', 'Poli Kulit', 'Poli Penyakit Dalam', 'Poli Konseling', 'Poli Saraf', 'Poli THT', 'Poli Bedah', 'Poli Paru', 'Poli Jantung'] as $spesialisasi)
                    <option value="{{ $spesialisasi }}" {{ $dktr->spesialisasi == $spesialisasi ? 'selected' : '' }}>{{ $spesialisasi }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 mb-3">
    <label for="lokasiPraktik" class="form-label"><strong>Lokasi Praktik:</strong></label>
    <select id="lokasiPraktik" class="form-select" name="lokasiPraktik">
        <option>- Pilih Lokasi -</option>
        @foreach ($ruangan as $room)
            <option value="{{ $room->namaRuangan }}" {{ isset($dktr) && $dktr->lokasiPraktik == $room->namaRuangan ? 'selected' : '' }}>{{ $room->namaRuangan }}</option>
        @endforeach
    </select>
</div>

        <div class="col-12 mb-3">
            <label for="jamPraktik" class="form-label"><strong>Jam Praktik:</strong></label>
            <input type="time" id="jamPraktik" class="form-control" name="jamPraktik" value="{{ $dktr->jamPraktik }}">
        </div>

        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>
</form>

@endsection
