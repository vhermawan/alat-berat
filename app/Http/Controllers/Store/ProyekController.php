<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyek;

class ProyekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        return view('store.proyek.index');
    }

    public function listProyek(){
        $allProyek = Proyek::all();
        return $allProyek;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'sumber_dana' => 'required',
            'budget' => 'required',
            'retensi' => 'required',
            'jenis_kontrak' => 'required',
            'jaminan_pelaksana' => 'required',
            'konsultan_perencana' => 'required',
            'konsultan_supervisi' => 'required',
            'pemilik_proyek' => 'required',
            'masa_pelaksanaan' => 'required',
            'masa_pemeliharaan' => 'required',
        ]);

        $proyek = New Proyek;
        $proyek->id_admin = auth()->user()->id;
        $proyek->nama = $request->nama;
        $proyek->lokasi = $request->lokasi;
        $proyek->sumber_dana = $request->sumber_dana;
        $proyek->budget =  preg_replace('/,.*|[^0-9]/', '', $request->budget);
        $proyek->retensi = $request->retensi;
        $proyek->jenis_kontrak = $request->jenis_kontrak;
        $proyek->jaminan_pelaksana = $request->jaminan_pelaksana;
        $proyek->konsultan_perencana = $request->konsultan_perencana;
        $proyek->konsultan_supervisi = $request->konsultan_supervisi;
        $proyek->pemilik_proyek = $request->pemilik_proyek;
        $proyek->masa_pelaksanaan = $request->masa_pelaksanaan;
        $proyek->masa_pemeliharaan = $request->masa_pemeliharaan;
        $proyek->save();

        return $proyek;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'sumber_dana' => 'required',
            'budget' => 'required',
            'retensi' => 'required',
            'jenis_kontrak' => 'required',
            'jaminan_pelaksana' => 'required',
            'konsultan_perencana' => 'required',
            'konsultan_supervisi' => 'required',
            'pemilik_proyek' => 'required',
            'masa_pelaksanaan' => 'required',
            'masa_pemeliharaan' => 'required',
        ]);

        $proyek = Proyek::find($id);
        $proyek->nama = $request->nama;
        $proyek->lokasi = $request->lokasi;
        $proyek->sumber_dana = $request->sumber_dana;
        $proyek->budget =  preg_replace('/,.*|[^0-9]/', '', $request->budget);
        $proyek->retensi = $request->retensi;
        $proyek->jenis_kontrak = $request->jenis_kontrak;
        $proyek->jaminan_pelaksana = $request->jaminan_pelaksana;
        $proyek->konsultan_perencana = $request->konsultan_perencana;
        $proyek->konsultan_supervisi = $request->konsultan_supervisi;
        $proyek->pemilik_proyek = $request->pemilik_proyek;
        $proyek->masa_pelaksanaan = $request->masa_pelaksanaan;
        $proyek->masa_pemeliharaan = $request->masa_pemeliharaan;
        $proyek->save();

        return $proyek;
    }

    public function destroy($id)
    {
       return Proyek::find($id)->delete();
    }
}
