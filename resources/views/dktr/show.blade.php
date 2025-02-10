@extends('template')

@section('content')

<div class="row mt-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Detail Dokter</h2>
            <a class="btn btn-secondary" href="{{ route('dktr.index') }}">Kembali</a>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">{{ $dktr->namaDokter }}</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200px">ID Dokter</th>
                <td>{{ $dktr->idDokter }}</td>
            </tr>
            <tr>
                <th>Nama Dokter</th>
                <td>{{ $dktr->namaDokter }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $dktr->tanggalLahir }}</td>
            </tr>
            <tr>
                <th>Spesialisasi</th>
                <td>{{ $dktr->spesialisasi }}</td>
            </tr>
            <tr>
                <th>Lokasi Praktik</th>
                <td>{{ $dktr->lokasiPraktik }}</td>
            </tr>
            <tr>
                <th>Jam Praktik</th>
                <td>{{ $dktr->jamPraktik }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection
