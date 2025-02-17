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
    public function index()
    {
        $dktr = Dokter::latest()->paginate(5);
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