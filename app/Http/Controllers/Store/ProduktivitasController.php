<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Produktivitas;
use App\Models\Proyek;
use App\Models\TipeAlat;
use App\Models\KebutuhanAlat;
use DB;

class ProduktivitasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $allProyek = Proyek::all();
        return view('store.produktivitas.index',compact('allProyek'));
    }

    public function listProduktivitas(){
        $allProduktivitas = Produktivitas::select('produktivitas.*','jenis_alat.nama as nama_jenis_alat',
                            'jenis_alat.id as id_jenis_alat', 'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                            ->join('tipe_alat', 'produktivitas.id_tipe_alat', '=', 'tipe_alat.id')
                            ->join('jenis_alat','tipe_alat.id_jenis_alat','=','jenis_alat.id')
                            ->get();
        return $allProduktivitas;
    }

    public function filterProduktivitas($id){
        $allProduktivitas = Produktivitas::select('produktivitas.*','jenis_alat.nama as nama_jenis_alat',
                'jenis_alat.id as id_jenis_alat', 'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                ->join('tipe_alat', 'produktivitas.id_tipe_alat', '=', 'tipe_alat.id')
                ->join('jenis_alat','tipe_alat.id_jenis_alat','=','jenis_alat.id')
                ->where('jenis_alat.id', '=', $id)
                ->get();
        return $allProduktivitas;
    }

    public function filterProduktivitasbyTipeAlat($id){
        $allProduktivitas = Produktivitas::select('produktivitas.*','jenis_alat.nama as nama_jenis_alat',
                'jenis_alat.id as id_jenis_alat', 'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat')
                ->join('tipe_alat', 'produktivitas.id_tipe_alat', '=', 'tipe_alat.id')
                ->join('jenis_alat','tipe_alat.id_jenis_alat','=','jenis_alat.id')
                ->where('tipe_alat.id', '=', $id)
                ->get();
        return $allProduktivitas;
    }

    public function store(Request $request)
    {     

        $tipeAlat = TipeAlat::where('id',$request->id_tipe_alat)->first();

        if($request->id_jenis_alat[1] == "Hydraulic Excavator"){
            $request->validate([
                'hydraulic.waktu_putar' => 'required',
                'hydraulic.kecepatan_putar' => 'required',
                'hydraulic.conversion_factor' => 'required',
                'hydraulic.bucket_fill_factor' => 'required',
                'hydraulic.faktor_kedalaman' => 'required',
                'hydraulic.faktor_efisiensi_kerja' => 'required',
            ]);
            

            $standarCycleTime =$request->hydraulic["waktu_putar"] / $request->hydraulic["kecepatan_putar"];
            
            $cms = $request->hydraulic["conversion_factor"] * round($standarCycleTime,3);

            $hasil = $tipeAlat->kapasitas_bucket * (60/$cms) * $request->hydraulic["faktor_kedalaman"] * $request->hydraulic["bucket_fill_factor"] * $request->hydraulic["faktor_efisiensi_kerja"];
            
            $parameter = [
                'standart_cycle_time' => round($standarCycleTime,3),
                'waktu_putar' => $request->hydraulic["waktu_putar"],
                'kecepatan_putar' => $request->hydraulic["kecepatan_putar"],
                'cms' => $cms,
                'conversion_factor' =>$request->hydraulic["conversion_factor"],
                'kapasitas_bucket' => $tipeAlat->kapasitas_bucket,
                'bucket_fill_factor' => $request->hydraulic["bucket_fill_factor"],
                'faktor_kedalaman' => $request->hydraulic["faktor_kedalaman"],
                'faktor_efisiensi_kerja' => $request->hydraulic["faktor_efisiensi_kerja"]
            ];

            $produktivitas = New Produktivitas;
            $produktivitas->id_tipe_alat = $request->id_tipe_alat;
            $produktivitas->hasil = round($hasil,3);
            $produktivitas->parameter = json_encode($parameter);
            $produktivitas->save();
            
            return $produktivitas;
        }else if($request->id_jenis_alat[1] == "Dump Truck"){
            $request->validate([
                'dump.kapasitas_dump' => 'required',
                'dump.bucket_fill_factor' => 'required',
                'dump.cycle_time_excavator' => 'required',
                'dump.jarak_angkut' => 'required',
                'dump.loaded_speed' => 'required',
                'dump.empty_speed' => 'required',
                'dump.standby_dumping_time' => 'required',
                'dump.spot_delay_time' => 'required',
                'dump.job_efficiency' => 'required',
            ]);

            $siklus_pengisian = ($request->dump["kapasitas_dump"]/$request->dump["kapasitas_bucket"]) * $request->dump["bucket_fill_factor"];
            $produktivitas_per_siklus = round($siklus_pengisian,0) * $request->dump["kapasitas_bucket"] * $request->dump["bucket_fill_factor"];
            $waktu_siklus_dump_truck = round($siklus_pengisian,0) * $request->dump["cycle_time_excavator"] * 
                                       ($request->dump["jarak_angkut"]/$request->dump["loaded_speed"]) + $request->dump["standby_dumping_time"] + 
                                       ($request->dump["jarak_angkut"]/$request->dump["empty_speed"]) + $request->dump["spot_delay_time"];

            $jumlah_dump_truck = ($waktu_siklus_dump_truck/$siklus_pengisian) * $request->dump["cycle_time_excavator"];
            $hasil =  $produktivitas_per_siklus * 
                    (60/$waktu_siklus_dump_truck) * 
                    $request->dump["job_efficiency"] * round($jumlah_dump_truck,0);
            
            
            $parameter = [
                'kapasitas_dump' => $request->dump["kapasitas_dump"],
                'kapasitas_bucket' => $request->dump["kapasitas_bucket"],
                'bucket_fill_factor' => $request->dump["bucket_fill_factor"],
                'jumlah_siklus' => round($siklus_pengisian,0),
                'produktivitas_per_siklus' => round($produktivitas_per_siklus,1),
                'cycle_time_excavator' => $request->dump["cycle_time_excavator"],
                'jarak_angkut' => $request->dump["jarak_angkut"],
                'loaded_speed' => $request->dump["loaded_speed"],
                'empty_speed' => $request->dump["empty_speed"],
                'standby_dumping_time' => $request->dump["standby_dumping_time"],
                'spot_delay_time' => $request->dump["spot_delay_time"],
                'waktu_siklus' => round($waktu_siklus_dump_truck,2),
                'jumlah_dump_truck' => round($jumlah_dump_truck,0),
                'job_efficiency' => $request->dump["job_efficiency"],
            ];

            $produktivitas = New Produktivitas;
            $produktivitas->id_tipe_alat = $request->id_tipe_alat;
            $produktivitas->hasil = round($hasil,3);
            $produktivitas->parameter = json_encode($parameter);
            $produktivitas->save();

            return $produktivitas;
        }else if($request->id_jenis_alat[1] == "Bulldozer"){
            $request->validate([
                'bulldozer.kapasitas_blade' => 'required',
                'bulldozer.blade_factor' => 'required',
                'bulldozer.jarak_dorong' => 'required',
                'bulldozer.fordward_speed' => 'required',
                'bulldozer.reverse_speed' => 'required',
                'bulldozer.gear_shifting' => 'required',
                'bulldozer.grade_factor' => 'required',
                'bulldozer.job_efficiency' => 'required',
            ]);

            $produktivitas_per_siklus = $request->bulldozer["kapasitas_blade"] * $request->bulldozer["blade_factor"];
            $cycle_time = ($request->bulldozer["jarak_dorong"] / $request->bulldozer["fordward_speed"]) + ($request->bulldozer["jarak_dorong"] / $request->bulldozer["reverse_speed"]) + $request->bulldozer["gear_shifting"]; 
            
            $hasil = $produktivitas_per_siklus * (60/round($cycle_time,2)) * $request->bulldozer["grade_factor"] * $request->bulldozer["job_efficiency"]; 
            
            $parameter = [
                'kapasitas_blade' => $request->bulldozer["kapasitas_blade"],
                'blade_factor' => $request->bulldozer["blade_factor"],
                'produktivitas_per_siklus' => $produktivitas_per_siklus,
                'jarak_dorong' => $request->bulldozer["jarak_dorong"],
                'fordward_speed' => $request->bulldozer["fordward_speed"],
                'reverse_speed' => $request->bulldozer["reverse_speed"],
                'gear_shifting' => $request->bulldozer["gear_shifting"],
                'cycle_time' => round($cycle_time,2),
                'grade_factor' => $request->bulldozer["grade_factor"],
                'job_efficiency' => $request->bulldozer["job_efficiency"],
            ];
            
            $produktivitas = New Produktivitas;
            $produktivitas->id_tipe_alat = $request->id_tipe_alat;
            $produktivitas->hasil = round($hasil,3);
            $produktivitas->parameter = json_encode($parameter);
            $produktivitas->save();

            return $produktivitas;
        }else{ 
            $request->validate([
                'compactor.lebar_pemadatan' => 'required',
                'compactor.lebar_blade' => 'required',
                'compactor.lebar_overlap' => 'required',
                'compactor.number_of_trips' => 'required',
                'compactor.kecepatan_kerja' => 'required',
                'compactor.job_efficiency' => 'required',
                'compactor.tebal_lapisan_tanah' => 'required',
            ]);

            $parameter = [
                'lebar_pemadatan' => $request->compactor["lebar_pemadatan"],
                'lebar_blade' => $request->compactor["lebar_blade"],
                'lebar_overlap' => $request->compactor["lebar_overlap"],
                'number_of_trips' => $request->compactor["number_of_trips"],
                'kecepatan_kerja' => $request->compactor["kecepatan_kerja"],
                'job_efficiency' => $request->compactor["job_efficiency"],
                'tebal_lapisan_tanah' => $request->compactor["tebal_lapisan_tanah"],
            ];

            $hasil = (($request->compactor["lebar_blade"]/1000)-$request->compactor["lebar_overlap"]) * $request->compactor["kecepatan_kerja"] * $request->compactor["tebal_lapisan_tanah"] * ($request->compactor["job_efficiency"]/$request->compactor["number_of_trips"]);
            $produktivitas = New Produktivitas;
            $produktivitas->id_tipe_alat = $request->id_tipe_alat;
            $produktivitas->hasil = round($hasil,3);
            $produktivitas->parameter = json_encode($parameter);
            $produktivitas->save();

            return $produktivitas;
        }
    }

    public function update(Request $request, $id)
    {
        $tipeAlat = TipeAlat::where('id',$request->id_tipe_alat)->first();
        if($request->id_jenis_alat[1] == "Hydraulic Excavator"){
            $request->validate([
                'hydraulic.waktu_putar' => 'required',
                'hydraulic.kecepatan_putar' => 'required',
                'hydraulic.conversion_factor' => 'required',
                'hydraulic.bucket_fill_factor' => 'required',
                'hydraulic.faktor_kedalaman' => 'required',
                'hydraulic.faktor_efisiensi_kerja' => 'required',
            ]);
            

            $standarCycleTime =$request->hydraulic["waktu_putar"] / $request->hydraulic["kecepatan_putar"];
            
            $cms = $request->hydraulic["conversion_factor"] * round($standarCycleTime,3);

            $hasil = $tipeAlat->kapasitas_bucket * (60/$cms) * $request->hydraulic["faktor_kedalaman"] * $request->hydraulic["bucket_fill_factor"] * $request->hydraulic["faktor_efisiensi_kerja"];
            
            $parameter = [
                'standart_cycle_time' => round($standarCycleTime,3),
                'waktu_putar' => $request->hydraulic["waktu_putar"],
                'kecepatan_putar' => $request->hydraulic["kecepatan_putar"],
                'cms' => $cms,
                'conversion_factor' =>$request->hydraulic["conversion_factor"],
                'kapasitas_bucket' => $tipeAlat->kapasitas_bucket,
                'bucket_fill_factor' => $request->hydraulic["bucket_fill_factor"],
                'faktor_kedalaman' => $request->hydraulic["faktor_kedalaman"],
                'faktor_efisiensi_kerja' => $request->hydraulic["faktor_efisiensi_kerja"]
            ];

            DB::beginTransaction();

            try{
                $produktivitas = Produktivitas::find($id);
                $produktivitas->id_tipe_alat = $request->id_tipe_alat;
                $produktivitas->hasil = round($hasil,3);
                $produktivitas->parameter = json_encode($parameter);
                $produktivitas->save();
            }catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status' => 'Update Produktivitas Fail', 'message' => $e->getMessage()]);
            }
            

            /**update kebutuhan alat */
            $kebutuhanAlat = KebutuhanAlat::where('id_tipe_alat',$request->id_tipe_alat)->first();
            if($kebutuhanAlat != null){
                $parameterDetail = json_decode($kebutuhanAlat->parameter);
                $totalHari= 240;
                $jamKerja=8;
                $waktuPelaksanaan= 58;

                $produktivitasPerHari = round($hasil,3) * $parameterDetail->jam_kerja_per_hari;
                $produktivitasMinHari = $parameterDetail->produktivitas_min_per_hari;
                $jumlahAlat = round($produktivitasMinHari,2)/round($produktivitasPerHari,2);


                $biayaSewaPerJam = round($jumlahAlat,0) * $tipeAlat->sewa_bulanan;
            
                $parameter = [
                    'volume_pekerjaan' => $parameterDetail->volume_pekerjaan,
                    'produktivitas_per_jam' => $produktivitas->hasil,
                    'jam_kerja_per_hari' => $jamKerja,
                    'waktu_pelaksanaan' => $waktuPelaksanaan,
                    'produktivitas_alat_per_hari' => round($produktivitasPerHari,2),
                    'produktivitas_min_per_hari' => round($produktivitasMinHari,2),
                    'jumlah_alat' => round($jumlahAlat,0),
                    'harga_sewa' => $tipeAlat->sewa_bulanan,
                ];

                try{
                    $kebutuhanAlat->hasil = $biayaSewaPerJam;
                    $kebutuhanAlat->parameter = json_encode($parameter);
                    $kebutuhanAlat->save();
                }catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['status' => 'Update Produktivitas Fail', 'message' => $e->getMessage()]);
                }
                DB::commit();
                return $produktivitas;
            }
            
            DB::commit();
            return $produktivitas;
        }else if($request->id_jenis_alat[1] == "Dump Truck"){
            $request->validate([
                'dump.kapasitas_dump' => 'required',
                'dump.bucket_fill_factor' => 'required',
                'dump.cycle_time_excavator' => 'required',
                'dump.jarak_angkut' => 'required',
                'dump.loaded_speed' => 'required',
                'dump.empty_speed' => 'required',
                'dump.standby_dumping_time' => 'required',
                'dump.spot_delay_time' => 'required',
                'dump.job_efficiency' => 'required',
            ]);

            $siklus_pengisian = ($request->dump["kapasitas_dump"]/$request->dump["kapasitas_bucket"]) * $request->dump["bucket_fill_factor"];
            $produktivitas_per_siklus = round($siklus_pengisian,0) * $request->dump["kapasitas_bucket"] * $request->dump["bucket_fill_factor"];
            $waktu_siklus_dump_truck = round($siklus_pengisian,0) * $request->dump["cycle_time_excavator"] * 
                                       ($request->dump["jarak_angkut"]/$request->dump["loaded_speed"]) + $request->dump["standby_dumping_time"] + 
                                       ($request->dump["jarak_angkut"]/$request->dump["empty_speed"]) + $request->dump["spot_delay_time"];

            $jumlah_dump_truck = ($waktu_siklus_dump_truck/$siklus_pengisian) * $request->dump["cycle_time_excavator"];
            $hasil =  $produktivitas_per_siklus * 
                    (60/$waktu_siklus_dump_truck) * 
                    $request->dump["job_efficiency"] * round($jumlah_dump_truck,0);
            
            $parameter = [
                'kapasitas_dump' => $request->dump["kapasitas_dump"],
                'kapasitas_bucket' => $request->dump["kapasitas_bucket"],
                'bucket_fill_factor' => $request->dump["bucket_fill_factor"],
                'jumlah_siklus' => round($siklus_pengisian,0),
                'produktivitas_per_siklus' => round($produktivitas_per_siklus,1),
                'cycle_time_excavator' => $request->dump["cycle_time_excavator"],
                'jarak_angkut' => $request->dump["jarak_angkut"],
                'loaded_speed' => $request->dump["loaded_speed"],
                'empty_speed' => $request->dump["empty_speed"],
                'standby_dumping_time' => $request->dump["standby_dumping_time"],
                'spot_delay_time' => $request->dump["spot_delay_time"],
                'waktu_siklus' => round($waktu_siklus_dump_truck,2),
                'jumlah_dump_truck' => round($jumlah_dump_truck,0),
                'job_efficiency' => $request->dump["job_efficiency"],
            ];
            
            DB::beginTransaction();
            try{
                $produktivitas = Produktivitas::find($id);
                $produktivitas->id_tipe_alat = $request->id_tipe_alat;
                $produktivitas->hasil = round($hasil,3);
                $produktivitas->parameter = json_encode($parameter);
                $produktivitas->save();
            }catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status' => 'Update Produktivitas Fail', 'message' => $e->getMessage()]);
            }

            $kebutuhanAlat = KebutuhanAlat::where('id_tipe_alat',$request->id_tipe_alat)->first();
            if($kebutuhanAlat != null){
                $parameterDetail = json_decode($kebutuhanAlat->parameter);
                $totalHari= 240;
                $jamKerja=8;
                $waktuPelaksanaan= 58;

                $biayaSewaPerJam = round($parameterDetail->jumlah_alat,0) * $tipeAlat->sewa_bulanan;
            
                $parameter = [
                    'volume_pekerjaan' => $parameterDetail->volume_pekerjaan,
                    'produktivitas_per_jam' => $produktivitas->hasil,
                    'jam_kerja_per_hari' => $jamKerja,
                    'waktu_pelaksanaan' => $waktuPelaksanaan,
                    'jumlah_fleet' => $parameterDetail->jumlah_fleet,
                    'jumlah_alat' => round($parameterDetail->jumlah_alat,0),
                    'harga_sewa' => $tipeAlat->sewa_bulanan,
                ];

                try{
                    $kebutuhanAlat->hasil = $biayaSewaPerJam;
                    $kebutuhanAlat->parameter = json_encode($parameter);
                    $kebutuhanAlat->save();
                }catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['status' => 'Update Produktivitas Fail', 'message' => $e->getMessage()]);
                }
                DB::commit();
                return $produktivitas;
            }
            
            DB::commit();
            return $produktivitas;

            return $produktivitas;
        }else if($request->id_jenis_alat[1] == "Bulldozer"){
            $request->validate([
                'bulldozer.kapasitas_blade' => 'required',
                'bulldozer.blade_factor' => 'required',
                'bulldozer.jarak_dorong' => 'required',
                'bulldozer.fordward_speed' => 'required',
                'bulldozer.reverse_speed' => 'required',
                'bulldozer.gear_shifting' => 'required',
                'bulldozer.grade_factor' => 'required',
                'bulldozer.job_efficiency' => 'required',
            ]);

            $produktivitas_per_siklus = $request->bulldozer["kapasitas_blade"] * $request->bulldozer["blade_factor"];
            $cycle_time = ($request->bulldozer["jarak_dorong"] / $request->bulldozer["fordward_speed"]) + ($request->bulldozer["jarak_dorong"] / $request->bulldozer["reverse_speed"]) + $request->bulldozer["gear_shifting"]; 
            
            $hasil = $produktivitas_per_siklus * (60/round($cycle_time,2)) * $request->bulldozer["grade_factor"] * $request->bulldozer["job_efficiency"]; 
            
            $parameter = [
                'kapasitas_blade' => $request->bulldozer["kapasitas_blade"],
                'blade_factor' => $request->bulldozer["blade_factor"],
                'produktivitas_per_siklus' => $produktivitas_per_siklus,
                'jarak_dorong' => $request->bulldozer["jarak_dorong"],
                'fordward_speed' => $request->bulldozer["fordward_speed"],
                'reverse_speed' => $request->bulldozer["reverse_speed"],
                'gear_shifting' => $request->bulldozer["gear_shifting"],
                'cycle_time' => round($cycle_time,2),
                'grade_factor' => $request->bulldozer["grade_factor"],
                'job_efficiency' => $request->bulldozer["job_efficiency"],
            ];

            DB::beginTransaction();
            
            try{
                $produktivitas = Produktivitas::find($id);
                $produktivitas->id_tipe_alat = $request->id_tipe_alat;
                $produktivitas->hasil = round($hasil,3);
                $produktivitas->parameter = json_encode($parameter);
                $produktivitas->save();
            }catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status' => 'Update Produktivitas Fail', 'message' => $e->getMessage()]);
            }

            $kebutuhanAlat = KebutuhanAlat::where('id_tipe_alat',$request->id_tipe_alat)->first();
            if($kebutuhanAlat != null){
                $parameterDetail = json_decode($kebutuhanAlat->parameter);
                $totalHari= 240;
                $jamKerja=8;
                $waktuPelaksanaan= 58;

                $produktivitasPerHari = round($hasil,3) * $parameterDetail->jam_kerja_per_hari;
                $produktivitasMinHari = $parameterDetail->produktivitas_min_per_hari;
                $jumlahAlat = round($produktivitasMinHari,2)/round($produktivitasPerHari,2);


                $biayaSewaPerJam = round($jumlahAlat,0) * $tipeAlat->sewa_bulanan;
            
                $parameter = [
                    'volume_pekerjaan' => $parameterDetail->volume_pekerjaan,
                    'produktivitas_per_jam' => $produktivitas->hasil,
                    'jam_kerja_per_hari' => $jamKerja,
                    'waktu_pelaksanaan' => $waktuPelaksanaan,
                    'produktivitas_alat_per_hari' => round($produktivitasPerHari,2),
                    'produktivitas_min_per_hari' => round($produktivitasMinHari,2),
                    'jumlah_alat' => round($jumlahAlat,0),
                    'harga_sewa' => $tipeAlat->sewa_bulanan,
                ];

                try{
                    $kebutuhanAlat->hasil = $biayaSewaPerJam;
                    $kebutuhanAlat->parameter = json_encode($parameter);
                    $kebutuhanAlat->save();
                }catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['status' => 'Update Produktivitas Fail', 'message' => $e->getMessage()]);
                }
                DB::commit();
                return $produktivitas;
            }
            
            DB::commit();
            return $produktivitas;
        }else{
            $request->validate([
                'compactor.lebar_pemadatan' => 'required',
                'compactor.lebar_blade' => 'required',
                'compactor.lebar_overlap' => 'required',
                'compactor.number_of_trips' => 'required',
                'compactor.kecepatan_kerja' => 'required',
                'compactor.job_efficiency' => 'required',
                'compactor.tebal_lapisan_tanah' => 'required',
            ]);

            $parameter = [
                'lebar_pemadatan' => $request->compactor["lebar_pemadatan"],
                'lebar_blade' => $request->compactor["lebar_blade"],
                'lebar_overlap' => $request->compactor["lebar_overlap"],
                'number_of_trips' => $request->compactor["number_of_trips"],
                'kecepatan_kerja' => $request->compactor["kecepatan_kerja"],
                'job_efficiency' => $request->compactor["job_efficiency"],
                'tebal_lapisan_tanah' => $request->compactor["tebal_lapisan_tanah"],
            ];

            $hasil = (($request->compactor["lebar_blade"]/1000)-$request->compactor["lebar_overlap"]) * $request->compactor["kecepatan_kerja"] * $request->compactor["tebal_lapisan_tanah"] * ($request->compactor["job_efficiency"]/$request->compactor["number_of_trips"]);
            
            DB::beginTransaction();

            try{
                $produktivitas = Produktivitas::find($id);
                $produktivitas->id_tipe_alat = $request->id_tipe_alat;
                $produktivitas->hasil = round($hasil,3);
                $produktivitas->parameter = json_encode($parameter);
                $produktivitas->save();;
            }catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status' => 'Update Produktivitas Fail', 'message' => $e->getMessage()]);
            }

             /**update kebutuhan alat */
             $kebutuhanAlat = KebutuhanAlat::where('id_tipe_alat',$request->id_tipe_alat)->first();
             if($kebutuhanAlat != null){
                 $parameterDetail = json_decode($kebutuhanAlat->parameter);
                 $totalHari= 240;
                 $jamKerja=8;
                 $waktuPelaksanaan= 58;
 
                 $produktivitasPerHari = round($hasil,3) * $parameterDetail->jam_kerja_per_hari;
                 $produktivitasMinHari = $parameterDetail->produktivitas_min_per_hari;
                 $jumlahAlat = round($produktivitasMinHari,2)/round($produktivitasPerHari,2);
 
 
                 $biayaSewaPerJam = round($jumlahAlat,0) * $tipeAlat->sewa_bulanan;
             
                 $parameter = [
                     'volume_pekerjaan' => $parameterDetail->volume_pekerjaan,
                     'produktivitas_per_jam' => $produktivitas->hasil,
                     'jam_kerja_per_hari' => $jamKerja,
                     'waktu_pelaksanaan' => $waktuPelaksanaan,
                     'produktivitas_alat_per_hari' => round($produktivitasPerHari,2),
                     'produktivitas_min_per_hari' => round($produktivitasMinHari,2),
                     'jumlah_alat' => round($jumlahAlat,0),
                     'harga_sewa' => $tipeAlat->sewa_bulanan,
                 ];
 
                 try{
                     $kebutuhanAlat->hasil = $biayaSewaPerJam;
                     $kebutuhanAlat->parameter = json_encode($parameter);
                     $kebutuhanAlat->save();
                 }catch (\Exception $e) {
                     DB::rollback();
                     return response()->json(['status' => 'Update Produktivitas Fail', 'message' => $e->getMessage()]);
                 }
                 DB::commit();
                 return $produktivitas;
             }
             
             DB::commit();
             return $produktivitas;
        }
    }

    public function destroy($id)
    {
       return Produktivitas::find($id)->delete();
    }
}
