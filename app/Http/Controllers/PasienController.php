<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Ruangan;
use Carbon\Carbon;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::query();

        if ($request->has('NomorRekamMedis') && $request->NomorRekamMedis != '') {
            $query->where('NomorRekamMedis', 'like', '%' . $request->NomorRekamMedis . '%');
        }

        if ($request->has('namaPasien') && $request->namaPasien != '') {
            $query->where('namaPasien', 'like', '%' . $request->namaPasien . '%');
        }

        $pasiens = $query->latest()->paginate(5);
        $pasiens->appends($request->all());

        return view('pasien.index', compact('pasiens'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $dokters = Dokter::all();
        $ruangan = Ruangan::all();
        return view('pasien.create', compact('dokters', 'ruangan'));
    }

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

        $ruangan = Ruangan::find($request->nomorKamar);
        if ($ruangan->dayaTampung <= 0) {
            return redirect()->back()->withInput()->with('error', 'Ruangan yang dipilih sudah penuh, silakan pilih ruangan lain.');
        }

        $tanggalLahir = Carbon::parse($request->tanggalLahir);
        $usia = $tanggalLahir->diff(Carbon::now());
        $usiaPasien = "{$usia->y} Tahun, {$usia->m} Bulan, {$usia->d} Hari";
        $spesialisasi = Dokter::find($request->idDokter)->spesialisasi;
        $ruangan->decrement('dayaTampung');

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

    public function show(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.show', compact('pasien'));
    }

    public function edit(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        $dokters = Dokter::all();
        $ruangan = Ruangan::all(); // Ambil semua data ruangan
        return view('pasien.edit', compact('pasien', 'dokters', 'ruangan'));
    }

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
        $tanggalLahir = Carbon::parse($request->tanggalLahir);
        $usia = $tanggalLahir->diff(Carbon::now());
        $usiaPasien = "{$usia->y} Tahun, {$usia->m} Bulan, {$usia->d} Hari";
        $spesialisasi = Dokter::find($request->idDokter)->spesialisasi;

        if ($pasien->nomorKamar != $request->nomorKamar) {
            $ruanganLama = Ruangan::find($pasien->nomorKamar);
            if ($ruanganLama) {
                $ruanganLama->increment('dayaTampung');
            }
            $ruanganBaru = Ruangan::find($request->nomorKamar);
            if ($ruanganBaru && $ruanganBaru->dayaTampung > 0) {
                $ruanganBaru->decrement('dayaTampung');
            } else {
                return redirect()->back()->with('error', 'Ruangan sudah penuh!');
            }
        }
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

        if ($request->tanggalKeluar) {
            $ruangan = Ruangan::find($request->nomorKamar);
            if ($ruangan) {
                $ruangan->increment('dayaTampung');
            }
        }

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diupdate.');
    }
    
    public function destroy(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        $ruangan = Ruangan::find($pasien->nomorKamar);
        $ruangan->increment('dayaTampung');
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}