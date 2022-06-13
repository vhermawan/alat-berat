<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\TipeAlat;
use App\Models\JenisAlat;
use App\Models\VolumePekerjaan;
use App\Models\Produktivitas;
use App\Models\KebutuhanAlat;


class KebutuhanAlatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $allProyek = Proyek::all();
        $allVolumePekerjaan = VolumePekerjaan::all();
        return view('store.kebutuhan_alat.index',compact('allProyek','allVolumePekerjaan'));
    }

    public function listKebutuhanAlat(){
        $allKebutuhanAlat = KebutuhanAlat::select('kebutuhan_alat.*','jenis_alat.nama as nama_jenis_alat',
                            'jenis_alat.id as id_jenis_alat', 'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                            ->join('tipe_alat', 'kebutuhan_alat.id_tipe_alat', '=', 'tipe_alat.id')
                            ->join('jenis_alat','tipe_alat.id_jenis_alat','=','jenis_alat.id')
                            ->get();
        return $allKebutuhanAlat;
    }

    public function filterKebutuhanAlat($id){
        $allKebutuhanAlat = KebutuhanAlat::select('kebutuhan_alat.*','jenis_alat.nama as nama_jenis_alat',
                'jenis_alat.id as id_jenis_alat', 'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                ->join('tipe_alat', 'kebutuhan_alat.id_tipe_alat', '=', 'tipe_alat.id')
                ->join('jenis_alat','tipe_alat.id_jenis_alat','=','jenis_alat.id')
                ->where('jenis_alat.id', '=', $id)
                ->get();
        return $allKebutuhanAlat;
    }

    public function filterKebutuhanAlatbyTipeAlat($id){
        $allKebutuhanAlat = KebutuhanAlat::select('kebutuhan_alat.*','jenis_alat.nama as nama_jenis_alat',
                'jenis_alat.id as id_jenis_alat', 'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                ->join('tipe_alat', 'kebutuhan_alat.id_tipe_alat', '=', 'tipe_alat.id')
                ->join('jenis_alat','tipe_alat.id_jenis_alat','=','jenis_alat.id')
                ->where('tipe_alat.id', '=', $id)
                ->get();
        return $allKebutuhanAlat;
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tipe_alat' => 'required',
            'id_volume_pekerjaan' => 'required',
        ]);

        $volumePekerjaan = VolumePekerjaan::where('id', $request->id_volume_pekerjaan)->first();

        $produktivitas = Produktivitas::where('id_tipe_alat', $request->id_tipe_alat)->first();

        $tipeAlat = TipeAlat::where('id',$request->id_tipe_alat)->first();

        $jamKerja = 8;
        $totalHari = 240;
        $waktuPelaksanaan = 58;
        
        if($request->id_jenis_alat[1] == "Dump Truck"){
            $request->validate([
                'dump.jumlah_fleet' => 'required',
                'dump.jumlah_dt' => 'required',
            ]);

            $jumlahAlat = $request->dump["jumlah_fleet"] * $request->dump["jumlah_dt"];

            $parameter = [
                'volume_pekerjaan' => $volumePekerjaan->nilai,
                'produktivitas_per_jam' => $produktivitas->hasil,
                'jam_kerja_per_hari' => $jamKerja,
                'waktu_pelaksanaan' => $waktuPelaksanaan,
                'jumlah_fleet' => $request->dump["jumlah_fleet"],
                'harga_sewa' => $tipeAlat->sewa_bulanan,
                'jumlah_alat' => round($jumlahAlat,0),
            ];

            $biayaSewaPerJam = $jumlahAlat * $tipeAlat->sewa_bulanan;

            $kebutuhanAlat = New KebutuhanAlat;
            $kebutuhanAlat->id_tipe_alat = $request->id_tipe_alat;
            $kebutuhanAlat->id_volume_pekerjaan = $request->id_volume_pekerjaan;
            $kebutuhanAlat->hasil = $biayaSewaPerJam;
            $kebutuhanAlat->parameter = json_encode($parameter);
            $kebutuhanAlat->save();
            
            return $kebutuhanAlat;
        }else{
            $produktivitasPerHari = $produktivitas->hasil * $jamKerja;
            $produktivitasMinHari = $volumePekerjaan->nilai/$waktuPelaksanaan;
            $jumlahAlat = round($produktivitasMinHari,2)/round($produktivitasPerHari,2);

            $biayaSewaPerJam = round($jumlahAlat,0) * $tipeAlat->sewa_bulanan;
            
            $parameter = [
                'volume_pekerjaan' => $volumePekerjaan->nilai,
                'produktivitas_per_jam' => $produktivitas->hasil,
                'jam_kerja_per_hari' => $jamKerja,
                'waktu_pelaksanaan' => $waktuPelaksanaan,
                'produktivitas_alat_per_hari' => round($produktivitasPerHari,2),
                'produktivitas_min_per_hari' => round($produktivitasMinHari,2),
                'harga_sewa' => $tipeAlat->sewa_bulanan,
                'jumlah_alat' => round($jumlahAlat,0),
            ];

            $kebutuhanAlat = New KebutuhanAlat;
            $kebutuhanAlat->id_tipe_alat = $request->id_tipe_alat;
            $kebutuhanAlat->id_volume_pekerjaan = $request->id_volume_pekerjaan;
            $kebutuhanAlat->hasil = $biayaSewaPerJam;
            $kebutuhanAlat->parameter = json_encode($parameter);
            $kebutuhanAlat->save();

            return $kebutuhanAlat;
        }
    }

    public function update(Request $request, $id)
    {
        $volumePekerjaan = VolumePekerjaan::where('id', $request->id_volume_pekerjaan)->first();

        $produktivitas = Produktivitas::where('id_tipe_alat', $request->id_tipe_alat)->first();

        $tipeAlat = TipeAlat::where('id',$request->id_tipe_alat)->first();
        $jenisAlat = JenisAlat::where('id',$tipeAlat->id_jenis_alat)->first();
        $jamKerja = 8;
        $totalHari = 240;
        $waktuPelaksanaan = 58;

        if($jenisAlat->nama == "Dump Truck"){
            $request->validate([
                'dump.jumlah_fleet' => 'required',
                'dump.jumlah_dt' => 'required',
            ]);
    
            $jumlahAlat = $request->dump["jumlah_fleet"] * $request->dump["jumlah_dt"];
    
            $parameter = [
                'volume_pekerjaan' => $volumePekerjaan->nilai,
                'produktivitas_per_jam' => $produktivitas->hasil,
                'jam_kerja_per_hari' => $jamKerja,
                'waktu_pelaksanaan' => $waktuPelaksanaan,
                'jumlah_fleet' => $request->dump["jumlah_fleet"],
                'harga_sewa' => $tipeAlat->sewa_bulanan,
                'jumlah_alat' => round($jumlahAlat,0),
            ];
    
            $biayaSewaPerJam = $jumlahAlat * $tipeAlat->sewa_bulanan;
    
            $kebutuhanAlat = KebutuhanAlat::find($id);
            $kebutuhanAlat->id_tipe_alat = $request->id_tipe_alat;
            $kebutuhanAlat->id_volume_pekerjaan = $request->id_volume_pekerjaan;
            $kebutuhanAlat->hasil = $biayaSewaPerJam;
            $kebutuhanAlat->parameter = json_encode($parameter);
            $kebutuhanAlat->save();
            
            return $kebutuhanAlat;
        }else{
            $produktivitasPerHari = $produktivitas->hasil * $jamKerja;
            $produktivitasMinHari = $volumePekerjaan->nilai/$waktuPelaksanaan;
            $jumlahAlat = round($produktivitasMinHari,2)/round($produktivitasPerHari,2);

            $biayaSewaPerJam = round($jumlahAlat,0) * $tipeAlat->sewa_bulanan;
            
            $parameter = [
                'volume_pekerjaan' => $volumePekerjaan->nilai,
                'produktivitas_per_jam' => $produktivitas->hasil,
                'jam_kerja_per_hari' => $jamKerja,
                'waktu_pelaksanaan' => $waktuPelaksanaan,
                'produktivitas_alat_per_hari' => round($produktivitasPerHari,2),
                'produktivitas_min_per_hari' => round($produktivitasMinHari,2),
                'harga_sewa' => $tipeAlat->sewa_bulanan,
                'jumlah_alat' => round($jumlahAlat,0),
            ];

            $kebutuhanAlat = KebutuhanAlat::find($id);
            $kebutuhanAlat->id_volume_pekerjaan = $request->id_volume_pekerjaan;
            $kebutuhanAlat->hasil = $biayaSewaPerJam;
            $kebutuhanAlat->parameter = json_encode($parameter);
            $kebutuhanAlat->save();
        }
    }

    public function destroy($id)
    {
        return KebutuhanAlat::find($id)->delete();
    }
}
