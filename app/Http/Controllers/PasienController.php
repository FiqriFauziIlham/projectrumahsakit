<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Ruangan;
use Carbon\Carbon;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pasien::query();

        // Filter berdasarkan Nomor Rekam Medis
        if ($request->has('NomorRekamMedis') && $request->NomorRekamMedis != '') {
            $query->where('NomorRekamMedis', 'like', '%' . $request->NomorRekamMedis . '%');
        }

        // Filter berdasarkan Nama Pasien
        if ($request->has('namaPasien') && $request->namaPasien != '') {
            $query->where('namaPasien', 'like', '%' . $request->namaPasien . '%');
        }

        // Paginasi hasil query
        $pasiens = $query->latest()->paginate(5);

        // Menambahkan parameter filter ke pagination links
        $pasiens->appends($request->all());

        return view('pasien.index', compact('pasiens'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $dokters = Dokter::all();
    $ruangan = Ruangan::all(); // Ambil semua ruangan, termasuk yang penuh
    return view('pasien.create', compact('dokters', 'ruangan'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'NomorRekamMedis' => 'required|unique:pasiens',
        'namaPasien' => 'required',
        'tanggalLahir' => 'required|date',
        'jenisKelamin' => 'required',
        'alamatPasien' => 'required',
        'kotaPasien' => 'required',
        'idDokter' => 'required|exists:dokters,id',
        'tanggalMasuk' => 'required|date',
        'nomorKamar' => 'required|exists:ruangan,id',
    ]);

    // Ambil ruangan yang dipilih
    $ruangan = Ruangan::find($request->nomorKamar);

    // Cek jika ruangan penuh
    if ($ruangan->dayaTampung <= 0) {
        return redirect()->back()->withInput()->with('error', 'Ruangan yang dipilih sudah penuh, silakan pilih ruangan lain.');
    }

    // Hitung usia pasien dalam tahun, bulan, dan hari
$tanggalLahir = Carbon::parse($request->tanggalLahir);
$usia = $tanggalLahir->diff(Carbon::now());
$usiaPasien = "{$usia->y} Tahun, {$usia->m} Bulan, {$usia->d} Hari";


    // Ambil spesialisasi dokter
    $spesialisasi = Dokter::find($request->idDokter)->spesialisasi;

    // Kurangi daya tampung ruangan
    $ruangan->decrement('dayaTampung');

    // Simpan data pasien
    Pasien::create([
        'NomorRekamMedis' => $request->NomorRekamMedis,
        'namaPasien' => $request->namaPasien,
        'tanggalLahir' => $request->tanggalLahir,
        'jenisKelamin' => $request->jenisKelamin,
        'alamatPasien' => $request->alamatPasien,
        'kotaPasien' => $request->kotaPasien,
        'usiaPasien' => $usiaPasien,
        'penyakitPasien' => $spesialisasi,
        'idDokter' => $request->idDokter,
        'tanggalMasuk' => $request->tanggalMasuk,
        'nomorKamar' => $request->nomorKamar,
    ]);

    return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.show', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        $dokters = Dokter::all();
        $ruangan = Ruangan::all(); // Ambil semua data ruangan
        return view('pasien.edit', compact('pasien', 'dokters', 'ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'NomorRekamMedis' => 'required|unique:pasiens,NomorRekamMedis,' . $id,
        'namaPasien' => 'required',
        'tanggalLahir' => 'required|date',
        'jenisKelamin' => 'required',
        'alamatPasien' => 'required',
        'kotaPasien' => 'required',
        'idDokter' => 'required|exists:dokters,id',
        'tanggalMasuk' => 'required|date',
        'tanggalKeluar' => 'nullable|date|after_or_equal:tanggalMasuk',
        'nomorKamar' => 'required|exists:ruangan,id',
    ]);

    $pasien = Pasien::findOrFail($id);

    // Hitung usia pasien dalam tahun, bulan, dan hari
    $tanggalLahir = Carbon::parse($request->tanggalLahir);
    $usia = $tanggalLahir->diff(Carbon::now());
    $usiaPasien = "{$usia->y} Tahun, {$usia->m} Bulan, {$usia->d} Hari";

    // Ambil spesialisasi dokter
    $spesialisasi = Dokter::find($request->idDokter)->spesialisasi;

    // Update dayaTampung ruangan jika nomorKamar berubah
    if ($pasien->nomorKamar != $request->nomorKamar) {
        // Kembalikan dayaTampung ruangan lama
        $ruanganLama = Ruangan::find($pasien->nomorKamar);
        if ($ruanganLama) {
            $ruanganLama->increment('dayaTampung');
        }

        // Kurangi dayaTampung ruangan baru
        $ruanganBaru = Ruangan::find($request->nomorKamar);
        if ($ruanganBaru && $ruanganBaru->dayaTampung > 0) {
            $ruanganBaru->decrement('dayaTampung');
        } else {
            return redirect()->back()->with('error', 'Ruangan sudah penuh!');
        }
    }

    // Update data pasien
    $pasien->update([
        'NomorRekamMedis' => $request->NomorRekamMedis,
        'namaPasien' => $request->namaPasien,
        'tanggalLahir' => $request->tanggalLahir,
        'jenisKelamin' => $request->jenisKelamin,
        'alamatPasien' => $request->alamatPasien,
        'kotaPasien' => $request->kotaPasien,
        'usiaPasien' => $usiaPasien,
        'penyakitPasien' => $spesialisasi,
        'idDokter' => $request->idDokter,
        'tanggalMasuk' => $request->tanggalMasuk,
        'tanggalKeluar' => $request->tanggalKeluar,
        'nomorKamar' => $request->nomorKamar,
    ]);

    // Tambahkan daya tampung ruangan jika pasien keluar
    if ($request->tanggalKeluar) {
        $ruangan = Ruangan::find($request->nomorKamar);
        if ($ruangan) {
            $ruangan->increment('dayaTampung'); // Tambah kapasitas ruangan
        }
    }

    return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diupdate.');
}
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pasien = Pasien::findOrFail($id);

        // Kembalikan dayaTampung ruangan
        $ruangan = Ruangan::find($pasien->nomorKamar);
        $ruangan->increment('dayaTampung');

        // Hapus data pasien
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}