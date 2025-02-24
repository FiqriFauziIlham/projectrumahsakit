@extends('template')

@section('content')

<div class="row mt-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Detail Pasien</h2>
            <a class="btn btn-secondary" href="{{ route('pasien.index') }}">Kembali</a>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">{{ $pasien->namaPasien }}</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200px">Nomor Rekam Medis</th>
                <td>{{ $pasien->NomorRekamMedis }}</td>
            </tr>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $pasien->namaPasien }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $pasien->tanggalLahir }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $pasien->jenisKelamin }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $pasien->alamatPasien }}</td>
            </tr>
            <tr>
                <th>Kota</th>
                <td>{{ $pasien->kotaPasien }}</td>
            </tr>
            <tr>
                <th>Usia</th>
                <td>{{ $pasien->usiaPasien }}</td>
            </tr>
            <tr>
                <th>Penyakit</th>
                <td>{{ $pasien->penyakitPasien }}</td>
            </tr>
            <tr>
                <th>Dokter Penanggung Jawab</th>
                <td>{{ $pasien->dokter->namaDokter ?? '-' }}</td>
            </tr>
            <tr>
                <th>Ruangan</th>
                <td>{{ $pasien->ruangan->namaRuangan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{ $pasien->tanggalMasuk }}</td>
            </tr>
            <tr>
                <th>Tanggal Keluar</th>
                <td>{{ $pasien->tanggalKeluar ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection
