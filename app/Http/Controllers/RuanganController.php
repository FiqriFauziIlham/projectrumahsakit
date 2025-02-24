<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mulai query builder
        $query = Ruangan::query();
    
        // Filter berdasarkan Kode Ruangan
        if ($request->has('kodeRuangan') && $request->kodeRuangan != '') {
            $query->where('kodeRuangan', 'like', '%' . $request->kodeRuangan . '%');
        }
    
        // Filter berdasarkan Nama Ruangan
        if ($request->has('namaRuangan') && $request->namaRuangan != '') {
            $query->where('namaRuangan', 'like', '%' . $request->namaRuangan . '%');
        }
    
        // Filter berdasarkan Daya Tampung
        if ($request->has('dayaTampung') && $request->dayaTampung != '') {
            $query->where('dayaTampung', $request->dayaTampung);
        }
    
        // Filter berdasarkan Lokasi
        if ($request->has('lokasi') && $request->lokasi != '') {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }
    
        // Paginasi hasil query
        $ruangan = $query->latest()->paginate(5);
    
        // Menambahkan parameter filter ke pagination links
        $ruangan->appends($request->all());
    
        return view('ruangan.index', compact('ruangan'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ruangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kodeRuangan' => 'required|unique:ruangan',
            'namaRuangan' => 'required',
            'dayaTampung' => 'required|integer',
            'lokasi' => 'required',
        ]);

        Ruangan::create($request->all());
        return redirect()->route('ruangan.index')->with('success', 'Data Ruangan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.show', compact('ruangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.edit', compact('ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kodeRuangan' => 'required|unique:ruangan,kodeRuangan,' . $id,
            'namaRuangan' => 'required',
            'dayaTampung' => 'required|integer',
            'lokasi' => 'required',
        ]);

        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update($request->all());

        return redirect()->route('ruangan.index')->with('success', 'Data Ruangan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('ruangan.index')->with('success', 'Data Ruangan Berhasil Dihapus');
    }
}
