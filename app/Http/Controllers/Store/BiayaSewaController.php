<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\BiayaSewa;
use App\Models\BiayaOperasional;
use App\Models\KebutuhanAlat;
use App\Models\TipeAlat;
use App\Models\JenisAlat;

class BiayaSewaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $allProyek = Proyek::all();
        return view('store.biaya_sewa.index',compact('allProyek'));
    }

    public function listBiayaSewa(){
        $allBiayaSewa = BiayaSewa::select('biaya_sewa.*','tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                ->join('tipe_alat', 'biaya_sewa.id_tipe_alat', '=', 'tipe_alat.id')
                ->get();

        return $allBiayaSewa;
    }

    public function filterBiayaSewa($id){
        $allBiayaSewa = BiayaSewa::select('biaya_sewa.*','tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                        ->join('tipe_alat', 'biaya_sewa.id_tipe_alat', '=', 'tipe_alat.id')
                        ->where('biaya_sewa.id_tipe_alat','=',$id)
                        ->get();

        return $allBiayaSewa;
    }

    public function filterBiayaSewabyJenisAlat($id){
        $allBiayaSewa = BiayaSewa::select('biaya_sewa.*','tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                ->join('tipe_alat', 'biaya_sewa.id_tipe_alat', '=', 'tipe_alat.id')
                ->where('biaya_sewa.id_jenis_alat','=',$id)
                ->get();

        return $allBiayaSewa;
    }

    public function store(Request $request){
        $idTipeAlat = $request->id_tipe_alat;
        $idJenisAlat = $request->id_jenis_alat[0];

        $biayaSewaAlat = TipeAlat::find($idTipeAlat)->sewa_bulanan; 

        $kebutuhanAlat = KebutuhanAlat::where('id_tipe_alat',$idTipeAlat)->first();
        $parameterKebutuhanAlat = json_decode($kebutuhanAlat->parameter);
        $jumlahUnit = $parameterKebutuhanAlat->jumlah_alat;


        $biayaOperasional = BiayaOperasional::where('id_tipe_alat',$idTipeAlat)->first(); 
        $parameterDetail = json_decode($biayaOperasional->parameter);
        $biayaOperator = preg_replace('/,.*|[^0-9]/', '', $parameterDetail->koefisienGajiOperator);
        $biayaBahanBakar =preg_replace('/,.*|[^0-9]/', '', $parameterDetail->koefisienBahanBakar);

        $totalBiayaSewa = $biayaSewaAlat * (58*8) * $jumlahUnit;
        $totalBiayaOperator = $biayaOperator * (58*8) * $jumlahUnit;
        $totalBiayaBahanBakar = $biayaBahanBakar * (58*8) * $jumlahUnit;
        $biayaMod = preg_replace('/,.*|[^0-9]/', '', $request->biaya_mod);

        $totalBiaya = $totalBiayaSewa + $totalBiayaOperator + $totalBiayaBahanBakar + $biayaMod;
        
        $biayaSewa = new BiayaSewa;
        $biayaSewa->id_tipe_alat = $idTipeAlat;
        $biayaSewa->id_proyek = $request->id_proyek;
        $biayaSewa->biaya_mod =  $request->biaya_mod;
        $biayaSewa->hasil = $totalBiaya;
        $biayaSewa->save();

        return $biayaSewa;
    }

    public function update(Request $request, $id){
        $biayaSewa = BiayaSewa::find($id);

        $idTipeAlat = $biayaSewa->id_tipe_alat;
        $idJenisAlat = $biayaSewa->id_jenis_alat;

        $biayaSewaAlat = TipeAlat::find($idTipeAlat)->sewa_bulanan; 

        $kebutuhanAlat = KebutuhanAlat::where('id_tipe_alat',$idTipeAlat)->first();
        $parameterKebutuhanAlat = json_decode($kebutuhanAlat->parameter);
        $jumlahUnit = $parameterKebutuhanAlat->jumlah_alat;

        $biayaOperasional = BiayaOperasional::where('id_tipe_alat',$idTipeAlat)->first(); 
        $parameterDetail = json_decode($biayaOperasional->parameter);
        $biayaOperator = preg_replace('/,.*|[^0-9]/', '', $parameterDetail->koefisienGajiOperator);
        $biayaBahanBakar =preg_replace('/,.*|[^0-9]/', '', $parameterDetail->koefisienBahanBakar);

        $totalBiayaSewa = $biayaSewaAlat * (58*8) * $jumlahUnit;
        $totalBiayaOperator = $biayaOperator * (58*8) * $jumlahUnit;
        $totalBiayaBahanBakar = $biayaBahanBakar * (58*8) * $jumlahUnit;
        $biayaMod = preg_replace('/,.*|[^0-9]/', '', $request->biaya_mod);

        $totalBiaya = $totalBiayaSewa + $totalBiayaOperator + $totalBiayaBahanBakar + $biayaMod;
        
        $biayaSewa->biaya_mod =  $request->biaya_mod;
        $biayaSewa->hasil = $totalBiaya;
        $biayaSewa->update();

        return $biayaSewa;
    }

    public function destroy($id){
        return BiayaSewa::find($id)->delete();
    }
}
