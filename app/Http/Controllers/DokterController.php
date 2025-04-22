<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Ruangan;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokter::query();
        if ($request->has('idDokter') && $request->idDokter != '') {
            $query->where('idDokter', 'like', '%' . $request->idDokter . '%');
        }

        if ($request->has('namaDokter') && $request->namaDokter != '') {
            $query->where('namaDokter', 'like', '%' . $request->namaDokter . '%');
        }
    
        if ($request->has('tanggalLahir') && $request->tanggalLahir != '') {
            $query->where('tanggalLahir', $request->tanggalLahir);
        }
    
        if ($request->has('spesialisasi') && $request->spesialisasi != '') {
            $query->where('spesialisasi', 'like', '%' . $request->spesialisasi . '%');
        }
    
        if ($request->has('lokasiPraktik') && $request->lokasiPraktik != '') {
            $query->where('lokasiPraktik', 'like', '%' . $request->lokasiPraktik . '%');
        }

        $dktr = $query->latest()->paginate(5);
        $dktr->appends($request->all());
    
        return view('dktr.index', compact('dktr'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $ruangan = Ruangan::all();
        return view('dktr.create', compact('ruangan'));
    }

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

    public function show(string $id)
    {
        $dktr = Dokter::findOrFail($id);
        return view('dktr.show', compact('dktr'));
    }

    public function edit(string $id)
    {
        $dktr = Dokter::findOrFail($id);
        $ruangan = Ruangan::all();
        return view('dktr.edit', compact('dktr', 'ruangan'));
    }    

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

    public function destroy(string $id)
    {
        $dktr = Dokter::findOrFail($id);
        $dktr->delete();                  
        return redirect()->route('dktr.index')->with('succes', 'Data berhasil di hapus');
    }
}