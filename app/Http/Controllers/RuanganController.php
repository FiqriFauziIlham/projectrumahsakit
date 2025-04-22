<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Ruangan::query();

        if ($request->has('kodeRuangan') && $request->kodeRuangan != '') {
            $query->where('kodeRuangan', 'like', '%' . $request->kodeRuangan . '%');
        }

        if ($request->has('namaRuangan') && $request->namaRuangan != '') {
            $query->where('namaRuangan', 'like', '%' . $request->namaRuangan . '%');
        }

        if ($request->has('dayaTampung') && $request->dayaTampung != '') {
            $query->where('dayaTampung', $request->dayaTampung);
        }

        if ($request->has('lokasi') && $request->lokasi != '') {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        $ruangan = $query->latest()->paginate(5);
        $ruangan->appends($request->all());
    
        return view('ruangan.index', compact('ruangan'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('ruangan.create');
    }

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

    public function show(string $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.show', compact('ruangan'));
    }

    public function edit(string $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.edit', compact('ruangan'));
    }

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

    public function destroy(string $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('ruangan.index')->with('success', 'Data Ruangan Berhasil Dihapus');
    }
}
