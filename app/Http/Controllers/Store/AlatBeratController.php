<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JenisAlat;
use App\Models\TipeAlat;
use App\Models\Proyek;
use App\Models\KebutuhanAlat;
use App\Models\VolumePekerjaan;
use App\Models\Produktivitas;
use DB;

class AlatBeratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexJenis(){
        $allProyek = Proyek::all();
        return view('store.alat_berat.jenis.index',compact('allProyek'));
    }

    public function listJenisAlat(){
        $allJenisAlat = JenisAlat::select('jenis_alat.*', 'proyek.nama as nama_proyek','proyek.id as id_proyek')
                        ->leftJoin('proyek', 'jenis_alat.id_proyek', '=', 'proyek.id')
                        ->get();
        return $allJenisAlat;
    }

    public function filterJenisAlat($id){
        $allJenisAlat = JenisAlat::select('jenis_alat.*', 'proyek.nama as nama_proyek','proyek.id as id_proyek')
                        ->leftJoin('proyek', 'jenis_alat.id_proyek', '=', 'proyek.id')
                        ->where('jenis_alat.id_proyek','=',$id)
                        ->get();
        return $allJenisAlat;
    }

    public function storeJenisAlat(Request $request)
    {
        $request->validate([
            'id_proyek' => 'required',
            'nama' => 'required',
        ]);

        $jenisAlat = New JenisAlat;
        $jenisAlat->id_proyek = $request->id_proyek;
        $jenisAlat->nama = $request->nama; 
        $jenisAlat->save();

        return $jenisAlat;
    }

    public function updateJenisAlat(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        return JenisAlat::find($id)->update($request->all());
    }

    public function destroyJenisAlat($id)
    {
       return JenisAlat::find($id)->delete();
    }
    
    public function indexTipe(){
        $allJenisAlat= JenisAlat::all();
        return view('store.alat_berat.tipe.index',compact('allJenisAlat'));
    }

    public function listTipeAlat(){
        $allTipeAlat = TipeAlat::select('tipe_alat.*', 'jenis_alat.nama as nama_jenis_alat','jenis_alat.id as id_jenis_alat')
                    ->leftJoin('jenis_alat', 'tipe_alat.id_jenis_alat', '=', 'jenis_alat.id')
                    ->get();
        return $allTipeAlat;
    }

    public function filterTipeAlat($id){
        $allTipeAlat = TipeAlat::select('tipe_alat.*', 'jenis_alat.nama as nama_jenis_alat','jenis_alat.id as id_jenis_alat')
                    ->leftJoin('jenis_alat', 'tipe_alat.id_jenis_alat', '=', 'jenis_alat.id')
                    ->where('tipe_alat.id_jenis_alat','=',$id)
                    ->get();
        return $allTipeAlat;
    }

    public function storeTipeAlat(Request $request)
    {
        $request->validate([
            'id_jenis_alat' => 'required',
            'nama' => 'required',
            'merk' => 'required',
            'kapasitas_bucket' => 'required',
            'sewa_bulanan' => 'required',
        ]);

        $tipeAlat = New TipeAlat;
        $tipeAlat->id_jenis_alat = $request->id_jenis_alat;
        $tipeAlat->nama = $request->nama; 
        $tipeAlat->merk = $request->merk; 
        $tipeAlat->kapasitas_bucket = $request->kapasitas_bucket; 
        $tipeAlat->sewa_bulanan = preg_replace('/,.*|[^0-9]/', '', $request->sewa_bulanan); 
        $tipeAlat->save();

        return $tipeAlat;
    }

    public function updateTipeAlat(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'merk' => 'required',
            'kapasitas_bucket' => 'required',
            'sewa_bulanan' => 'required',
        ]);

        DB::beginTransaction();

        $tipeAlat = TipeAlat::find($id);
        try {
            $tipeAlat->nama = $request->nama;
            $tipeAlat->merk = $request->merk;
            $tipeAlat->kapasitas_bucket = $request->kapasitas_bucket;
            $tipeAlat->sewa_bulanan = $tipeAlat->sewa_bulanan = preg_replace('/,.*|[^0-9]/', '', $request->sewa_bulanan);
            $tipeAlat->save();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'Update Tipe Alat Fail', 'message' => $e->getMessage()], 404);
        }
        $kebutuhanAlat = KebutuhanAlat::where('id_tipe_alat',$id)->first();
        if($kebutuhanAlat != null){
            $volumePekerjaan = VolumePekerjaan::where('id', $kebutuhanAlat->id_volume_pekerjaan)->first();
           
            $produktivitas = Produktivitas::where('id_tipe_alat', $id)->first();

            $jenisAlat = JenisAlat::where('id',$tipeAlat->id_jenis_alat)->first();

            $jamKerja = 8;
            $totalHari = 240;
            $waktuPelaksanaan = 58;

            if($jenisAlat->nama == "Dump Truck"){
                $parameterDetail = json_decode($kebutuhanAlat->parameter);
                
                $parameter = [
                    'volume_pekerjaan' => $volumePekerjaan->nilai,
                    'produktivitas_per_jam' => $produktivitas->hasil,
                    'jam_kerja_per_hari' => $jamKerja,
                    'waktu_pelaksanaan' => $waktuPelaksanaan,
                    'jumlah_fleet' => $parameterDetail->jumlah_fleet,
                    'harga_sewa' => $request->sewa_bulanan,
                    'jumlah_alat' => $parameterDetail->jumlah_alat,
                ];
    
                $biayaSewaPerJam = $parameterDetail->jumlah_alat * $request->sewa_bulanan;
    
                try {
                    $kebutuhanAlat->hasil = $biayaSewaPerJam;
                    $kebutuhanAlat->parameter = json_encode($parameter);
                    $kebutuhanAlat->save();
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['status' => 'Update Tipe Alat Fail', 'message' => $e->getMessage()], 404);
                }

                DB::commit();
                return $tipeAlat;
            }else{
                $produktivitasPerHari = $produktivitas->hasil * $jamKerja;
                $produktivitasMinHari = $volumePekerjaan->nilai/$waktuPelaksanaan;
                $jumlahAlat = round($produktivitasMinHari,2)/round($produktivitasPerHari,2);

                $biayaSewaPerJam = round($jumlahAlat,0) * round($request->sewa_bulanan/$totalHari,0);

                $parameter = [
                    'volume_pekerjaan' => $volumePekerjaan->nilai,
                    'produktivitas_per_jam' => $produktivitas->hasil,
                    'jam_kerja_per_hari' => $jamKerja,
                    'waktu_pelaksanaan' => $waktuPelaksanaan,
                    'produktivitas_alat_per_hari' => round($produktivitasPerHari,2),
                    'produktivitas_min_per_hari' => round($produktivitasMinHari,2),
                    'harga_sewa' => round($tipeAlat->sewa_bulanan/$totalHari,0),
                    'jumlah_alat' => round($jumlahAlat,0),
                ];
    
                try {
                    $kebutuhanAlat->hasil = $biayaSewaPerJam;
                    $kebutuhanAlat->parameter = json_encode($parameter);
                    $kebutuhanAlat->save();
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['status' => 'Update Tipe Alat Fail', 'message' => $e->getMessage()], 404);
                }

                //next update biaya operasional
               
                DB::commit();
                return $tipeAlat;
            }

        }
        DB::commit();
        return $tipeAlat;
    }

    public function destroyTipeAlat($id)
    {
       return TipeAlat::find($id)->delete();
    }
   
}
