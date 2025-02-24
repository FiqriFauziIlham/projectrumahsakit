<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Ruangan;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dokter::query();
    
        // Filter berdasarkan ID Dokter
        if ($request->has('idDokter') && $request->idDokter != '') {
            $query->where('idDokter', 'like', '%' . $request->idDokter . '%');
        }
    
        // Filter berdasarkan Nama Dokter
        if ($request->has('namaDokter') && $request->namaDokter != '') {
            $query->where('namaDokter', 'like', '%' . $request->namaDokter . '%');
        }
    
        // Filter berdasarkan Tanggal Lahir
        if ($request->has('tanggalLahir') && $request->tanggalLahir != '') {
            $query->where('tanggalLahir', $request->tanggalLahir);
        }
    
        // Filter berdasarkan Spesialisasi
        if ($request->has('spesialisasi') && $request->spesialisasi != '') {
            $query->where('spesialisasi', 'like', '%' . $request->spesialisasi . '%');
        }
    
        // Filter berdasarkan Lokasi Praktik
        if ($request->has('lokasiPraktik') && $request->lokasiPraktik != '') {
            $query->where('lokasiPraktik', 'like', '%' . $request->lokasiPraktik . '%');
        }
    
        // Paginasi hasil query
        $dktr = $query->latest()->paginate(5);
    
        // Menambahkan parameter filter ke pagination links
        $dktr->appends($request->all());
    
        return view('dktr.index', compact('dktr'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ruangan = Ruangan::all(); // Ambil semua data ruangan
        return view('dktr.create', compact('ruangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idDokter' => 'required',
            'namaDokter' => 'required',
            'tanggalLahir' => 'required',
            'spesialisasi' => 'required',
            'lokasiPraktik' => 'required',
            'jamPraktik' => 'required',
        ]);
        Dokter::create($request->all());
        return redirect()->route('dktr.index')->with('succes', 'Data Berhasil di input');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dktr = Dokter::findOrFail($id);
        return view('dktr.show', compact('dktr'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dktr = Dokter::findOrFail($id);
        $ruangan = Ruangan::all(); // Mengambil semua data ruangan
        return view('dktr.edit', compact('dktr', 'ruangan'));
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'idDokter' => 'required',
            'namaDokter' => 'required',
            'tanggalLahir' => 'required',
            'spesialisasi' => 'required',
            'lokasiPraktik' => 'required',
            'jamPraktik' => 'required',
        ]);
        
        $dktr = Dokter::findOrFail($id);
        $dktr->update($request->all());
        return redirect()->route('dktr.index')->with('succes', 'Data Berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dktr = Dokter::findOrFail($id);  // Temukan data dokter berdasarkan ID
        $dktr->delete();                  // Hapus data dokter
        return redirect()->route('dktr.index')->with('succes', 'Data berhasil di hapus');
    }
}