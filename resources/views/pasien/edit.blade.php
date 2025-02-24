@extends('template')

@section('content')
<div class="row mt-5 mb-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Edit Data Pasien</h2>
            <a class="btn btn-secondary" href="{{ route('pasien.index') }}">Kembali</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Whoops!</strong> Terjadi kesalahan.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Nomor Rekam Medis -->
        <div class="col-12 mb-3">
            <label for="NomorRekamMedis" class="form-label"><strong>Nomor Rekam Medis:</strong></label>
            <input type="text" id="NomorRekamMedis" name="NomorRekamMedis" class="form-control" value="{{ $pasien->NomorRekamMedis }}">
        </div>

        <!-- Nama Pasien -->
        <div class="col-12 mb-3">
            <label for="namaPasien" class="form-label"><strong>Nama Pasien:</strong></label>
            <input type="text" id="namaPasien" name="namaPasien" class="form-control" value="{{ $pasien->namaPasien }}">
        </div>

        <!-- Tanggal Lahir -->
        <div class="col-12 mb-3">
            <label for="tanggalLahir" class="form-label"><strong>Tanggal Lahir:</strong></label>
            <input type="date" id="tanggalLahir" class="form-control" name="tanggalLahir" value="{{ $pasien->tanggalLahir }}">
        </div>

        <!-- Jenis Kelamin -->
        <div class="col-12 mb-3">
            <label for="jenisKelamin" class="form-label"><strong>Jenis Kelamin:</strong></label>
            <select id="jenisKelamin" class="form-select" name="jenisKelamin">
                <option value="Laki-laki" {{ $pasien->jenisKelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $pasien->jenisKelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <!-- Alamat Pasien -->
        <div class="col-12 mb-3">
            <label for="alamatPasien" class="form-label"><strong>Alamat Pasien:</strong></label>
            <textarea id="alamatPasien" class="form-control" name="alamatPasien">{{ $pasien->alamatPasien }}</textarea>
        </div>

        <!-- Kota Pasien -->
        <div class="col-12 mb-3">
            <label for="kotaPasien" class="form-label"><strong>Kota Pasien:</strong></label>
            <input type="text" id="kotaPasien" name="kotaPasien" class="form-control" value="{{ $pasien->kotaPasien }}">
        </div>

        <!-- Dokter -->
        <div class="col-12 mb-3">
            <label for="idDokter" class="form-label"><strong>Dokter:</strong></label>
            <select id="idDokter" class="form-select" name="idDokter">
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}" {{ $pasien->idDokter == $dokter->id ? 'selected' : '' }}>
                        {{ $dokter->namaDokter }} ({{ $dokter->spesialisasi }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Ruangan -->
        <div class="col-12 mb-3">
            <label for="nomorKamar" class="form-label"><strong>Ruangan:</strong></label>
            <select id="nomorKamar" class="form-select" name="nomorKamar">
                @foreach($ruangan as $r)
                    <option value="{{ $r->id }}" {{ $pasien->nomorKamar == $r->id ? 'selected' : '' }}>
                        {{ $r->namaRuangan }} (Daya Tampung: {{ $r->dayaTampung }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal Masuk -->
        <div class="col-12 mb-3">
            <label for="tanggalMasuk" class="form-label"><strong>Tanggal Masuk:</strong></label>
            <input type="date" id="tanggalMasuk" class="form-control" name="tanggalMasuk" value="{{ $pasien->tanggalMasuk }}">
        </div>

        <div class="mb-3">
                <label for="tanggalKeluar" class="form-label">Tanggal Keluar</label>
                <input type="date" name="tanggalKeluar" class="form-control" value="{{ $pasien->tanggalKeluar }}">
        </div>

        <!-- Tombol Simpan -->
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </div>
</form>
@endsection
