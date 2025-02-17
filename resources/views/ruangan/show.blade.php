@extends('template')

@section('content')

<div class="row mt-5">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Detail Ruangan</h2>
            <a class="btn btn-secondary" href="{{ route('ruangan.index') }}">Kembali</a>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">{{ $ruangan->namaRuangan }}</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200px">Kode Ruangan</th>
                <td>{{ $ruangan->kodeRuangan }}</td>
            </tr>
            <tr>
                <th>Nama Ruangan</th>
                <td>{{ $ruangan->namaRuangan }}</td>
            </tr>
            <tr>
                <th>Daya Tampung</th>
                <td>{{ $ruangan->dayaTampung }}</td>
            </tr>
            <tr>
                <th>Lokasi</th>
                <td>{{ $ruangan->lokasi }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection