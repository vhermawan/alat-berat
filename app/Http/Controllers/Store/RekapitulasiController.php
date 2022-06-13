<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Produktivitas;
use App\Models\KebutuhanAlat;
use App\Models\BiayaOperasional;
use App\Models\BiayaSewa;
use App\Models\Proyek;
use Auth;

class RekapitulasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $allProduktivitas = Produktivitas::select('produktivitas.*','jenis_alat.nama as nama_jenis_alat',
                            'jenis_alat.id as id_jenis_alat', 'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                            ->join('tipe_alat', 'produktivitas.id_tipe_alat', '=', 'tipe_alat.id')
                            ->join('jenis_alat','tipe_alat.id_jenis_alat','=','jenis_alat.id')
                            ->get();

        $allKebutuhanAlat = KebutuhanAlat::select('kebutuhan_alat.*','jenis_alat.nama as nama_jenis_alat',
                            'jenis_alat.id as id_jenis_alat', 'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                            ->join('tipe_alat', 'kebutuhan_alat.id_tipe_alat', '=', 'tipe_alat.id')
                            ->join('jenis_alat','tipe_alat.id_jenis_alat','=','jenis_alat.id')
                            ->get();
    
        $allBiayaOperasional = BiayaOperasional::select('biaya_operasional.*','biaya_operasional.parameter as parameter_biaya_operasional',
                            'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat',
                            'jenis_alat.nama as nama_jenis_alat','kebutuhan_alat.parameter as parameter_kebutuhan_alat')
                            ->join('tipe_alat', 'biaya_operasional.id_tipe_alat', '=', 'tipe_alat.id')
                            ->join('kebutuhan_alat', 'biaya_operasional.id_tipe_alat', '=', 'kebutuhan_alat.id_tipe_alat')
                            ->join('jenis_alat', 'tipe_alat.id_jenis_alat', '=', 'jenis_alat.id')
                            ->get();
   
        return view('store.rekapitulasi.index',compact('allProduktivitas','allKebutuhanAlat','allBiayaOperasional'));
    }

    public function rekapBiayaOperasional(){
        $allBiayaOperasional = BiayaOperasional::select('biaya_operasional.*','biaya_operasional.parameter as parameter_biaya_operasional',
                            'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat',
                            'jenis_alat.nama as nama_jenis_alat','kebutuhan_alat.parameter as parameter_kebutuhan_alat')
                            ->join('tipe_alat', 'biaya_operasional.id_tipe_alat', '=', 'tipe_alat.id')
                            ->join('kebutuhan_alat', 'biaya_operasional.id_tipe_alat', '=', 'kebutuhan_alat.id_tipe_alat')
                            ->join('jenis_alat', 'tipe_alat.id_jenis_alat', '=', 'jenis_alat.id')
                            ->get();
        return $allBiayaOperasional;
    }

    public function rekapKeuntungan(){
        $proyek = Proyek::where('id_admin',Auth::user()->id)->get();
        for($i=0; $i<sizeof($proyek); $i++){
            $biayaSewa = BiayaSewa::where('id_proyek',$proyek[$i]->id)->sum('hasil');
            $total[] = $biayaSewa;
        }
        return response()->json([
            'status' => 'Success',
            'data' => [
                'proyek' => $proyek,
                'total' => $total
            ],
        ],200);
    }
}
