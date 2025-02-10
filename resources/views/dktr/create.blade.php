@extends('template')

@section('content')
<div class="row mt-5 mb-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Tambah Dokter Baru</h2>
            <a class="btn btn-secondary" href="{{ route('dktr.index') }}">Kembali</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Whoops!</strong> Input gagal.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('dktr.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-12 mb-3">
            <label for="idDokter" class="form-label"><strong>ID Dokter:</strong></label>
            <input type="text" id="idDokter" name="idDokter" class="form-control" placeholder="ID DOKTER">
        </div>

        <div class="col-12 mb-3">
            <label for="namaDokter" class="form-label"><strong>Nama Dokter:</strong></label>
            <input type="text" id="namaDokter" name="namaDokter" class="form-control" placeholder="NAMA DOKTER">
        </div>

        <div class="col-12 mb-3">
            <label for="tanggalLahir" class="form-label"><strong>Tanggal Lahir:</strong></label>
            <input type="date" id="tanggalLahir" class="form-control" name="tanggalLahir">
        </div>

        <div class="col-12 mb-3">
            <label for="spesialisasi" class="form-label"><strong>Spesialisasi:</strong></label>
            <select id="spesialisasi" class="form-select" name="spesialisasi">
                <option>- Spesialisasi -</option>
                <option value="Poli Umum">Poli Umum</option>
                <option value="Poli Anak">Poli Anak</option>
                <option value="Poli Gigi">Poli Gigi</option>
                <option value="Poli Mata">Poli Mata</option>
                <option value="Poli Kulit">Poli Kulit</option>
                <option value="Poli Penyakit Dalam">Poli Penyakit Dalam</option>
                <option value="Poli Konseling">Poli Konseling</option>
                <option value="Poli Saraf">Poli Saraf</option>
                <option value="Poli THT">Poli THT</option>
                <option value="Poli Bedah">Poli Bedah</option>
                <option value="Poli Paru">Poli Paru</option>
                <option value="Poli Jantung">Poli Jantung</option>
            </select>
        </div>

        <div class="col-12 mb-3">
            <label for="lokasiPraktik" class="form-label"><strong>Lokasi Praktik:</strong></label>
            <select id="lokasiPraktik" class="form-select" name="lokasiPraktik">
                <option>- Lokasi -</option>
                <option value="Jatiwaringin">Jatiwaringin</option>
                <option value="Cipayung">Cipayung</option>
                <option value="Cilangkap">Cilangkap</option>
                <option value="MunJul">MunJul</option>
                <option value="Cibubur">Cibubur</option>
                <option value="Jatinegara">Jatinegara</option>
                <option value="Matraman">Matraman</option>
                <option value="Kebon Jeruk">Kebon Jeruk</option>
                <option value="Tangerang">Tangerang</option>
                <option value="Bekasi">Bekasi</option>
                <option value="Depok">Depok</option>
                <option value="Tambun">Tambun</option>
                <option value="Cikarang">Cikarang</option>
            </select>
        </div>

        <div class="col-12 mb-3">
            <label for="jamPraktik" class="form-label"><strong>Jam Praktik:</strong></label>
            <input type="time" id="jamPraktik" class="form-control" name="jamPraktik">
        </div>

        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>
@endsection
