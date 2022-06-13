<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VolumePekerjaan;
use App\Models\KebutuhanAlat;
use App\Models\Produktivitas;
use App\Models\TipeAlat;
use App\Models\JenisAlat;
use DB;

class VolumeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        return view('store.volume.index');
    }

    public function listVolumePekerjaan(){
        $allVolumePekerjaan = VolumePekerjaan::all();
        return $allVolumePekerjaan;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nilai' => 'required',
        ]);

        $volumePekerjaan = New VolumePekerjaan;
        $volumePekerjaan->nama = $request->nama;
        $volumePekerjaan->nilai = $request->nilai; 
        $volumePekerjaan->save();

        return $volumePekerjaan;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nilai' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $volumePekerjaan = VolumePekerjaan::find($id);
            $volumePekerjaan->nama = $request->nama;
            $volumePekerjaan->nilai = $request->nilai; 
            $volumePekerjaan->save();
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'Update Volume Fail', 'message' => $e->getMessage()]);
        }

        $jamKerja = 8;
        $totalHari = 240;
        $waktuPelaksanaan = 58;

        $kebutuhanAlat = KebutuhanAlat::where('id_volume_pekerjaan', $id)->get();
        if(sizeof($kebutuhanAlat) !== 0){
            for($i=0; $i < sizeof($kebutuhanAlat); $i++){

                $produktivitas = Produktivitas::where('id_tipe_alat', $kebutuhanAlat[$i]->id_tipe_alat)->first();

                $tipeAlat = TipeAlat::where('id',$kebutuhanAlat[$i]->id_tipe_alat)->first();

                $jenisAlat = JenisAlat::where('id',$tipeAlat->id_jenis_alat)->first();

                
                if($jenisAlat->nama != "Dump Truck"){
                    $produktivitasPerHari = $produktivitas->hasil * $jamKerja;
                    $produktivitasMinHari = $request->nilai/$waktuPelaksanaan;

                    $jumlahAlat = round($produktivitasMinHari,2)/round($produktivitasPerHari,2);

                    $biayaSewaPerJam = round($jumlahAlat,0) * round($tipeAlat->sewa_bulanan/$totalHari,0);
                    
                    $parameter = [
                        'volume_pekerjaan' => $request->nilai,
                        'produktivitas_per_jam' => $produktivitas->hasil,
                        'jam_kerja_per_hari' => $jamKerja,
                        'waktu_pelaksanaan' => $waktuPelaksanaan,
                        'produktivitas_alat_per_hari' => round($produktivitasPerHari,2),
                        'produktivitas_min_per_hari' => round($produktivitasMinHari,2),
                        'harga_sewa' => round($tipeAlat->sewa_bulanan/$totalHari,0),
                        'jumlah_alat' => round($jumlahAlat,0),
                    ];

                    $hasil[] = $biayaSewaPerJam;
                    $parameters[] = $parameter;
                    $ids[]= $kebutuhanAlat[$i]->id;
                }
            }
            try{
                for ($i = 0; $i < sizeof($ids); $i++) {
                    KebutuhanAlat::where(['id' => $ids[$i]])
                      ->update([
                          'hasil' => $hasil[$i],
                          'parameter' =>$parameters[$i],
                      ]);
                }
            }catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status' => 'Update Volume Fail', 'message' => $e->getMessage()]);
            }

            //next update biaya operasional
            DB::commit();
            return $kebutuhanAlat;
            
        }else{
            DB::commit();
            return $volumePekerjaan;
        }
    }

    public function destroy($id)
    {
       return VolumePekerjaan::find($id)->delete();
    }
}
