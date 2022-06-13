<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\BiayaOperasional;
use App\Models\TipeAlat;
use App\Models\JenisAlat;


class BiayaOperasionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $allProyek = Proyek::all();
        return view('store.biaya_operasional.index',compact('allProyek'));
    }

    public function listBiayaOperasional(){
        $allBiayaOperasional = BiayaOperasional::select('biaya_operasional.*','biaya_operasional.parameter as parameter_biaya_operasional',
                            'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat',
                            'jenis_alat.nama as nama_jenis_alat','kebutuhan_alat.parameter as parameter_kebutuhan_alat')
                            ->join('tipe_alat', 'biaya_operasional.id_tipe_alat', '=', 'tipe_alat.id')
                            ->join('kebutuhan_alat', 'biaya_operasional.id_tipe_alat', '=', 'kebutuhan_alat.id_tipe_alat')
                            ->join('jenis_alat', 'tipe_alat.id_jenis_alat', '=', 'jenis_alat.id')
                            ->get();
        
        return $allBiayaOperasional;
    }

    public function filterBiayaOperasional($id){
        $allBiayaOperasional = BiayaOperasional::select('biaya_operasional.*','biaya_operasional.parameter as parameter_biaya_operasional',
                            'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat',
                            'jenis_alat.nama as nama_jenis_alat','kebutuhan_alat.parameter as parameter_kebutuhan_alat')
                            ->join('tipe_alat', 'biaya_operasional.id_tipe_alat', '=', 'tipe_alat.id')
                            ->join('kebutuhan_alat', 'biaya_operasional.id_tipe_alat', '=', 'kebutuhan_alat.id_tipe_alat')
                            ->join('jenis_alat', 'tipe_alat.id_jenis_alat', '=', 'jenis_alat.id')
                            ->where('tipe_alat.id', '=', $id)
                            ->get();
        return $allBiayaOperasional;
    }

    public function filterBiayaOperasionalbyJenisAlat($id){
        $allBiayaOperasional = BiayaOperasional::select('biaya_operasional.*','biaya_operasional.parameter as parameter_biaya_operasional',
                            'tipe_alat.nama as nama_tipe_alat','tipe_alat.id as id_tipe_alat',
                            'jenis_alat.nama as nama_jenis_alat','kebutuhan_alat.parameter as parameter_kebutuhan_alat')
                            ->join('tipe_alat', 'biaya_operasional.id_tipe_alat', '=', 'tipe_alat.id')
                            ->join('kebutuhan_alat', 'biaya_operasional.id_tipe_alat', '=', 'kebutuhan_alat.id_tipe_alat')
                            ->join('jenis_alat', 'tipe_alat.id_jenis_alat', '=', 'jenis_alat.id')
                            ->where('jenis_alat.id', '=', $id)
                            ->get();
        return $allBiayaOperasional;
    }

    public function store(Request $request)
    {   
        if($request->id_jenis_alat[1] == "Hydraulic Excavator"){
            $request->validate([
                'hydraulic.bahan_bakar.harga_satuan' => 'required',
                'hydraulic.bahan_bakar.daya_mesin' => 'required',
                'hydraulic.bahan_bakar.interval' => 'required',
                'hydraulic.oil_engine.harga_satuan' => 'required',
                'hydraulic.oil_engine.liter_pemakaian' => 'required',
                'hydraulic.oil_engine.faktor_efisien' => 'required',
                'hydraulic.oil_engine.interval' => 'required',
                'hydraulic.oil_hidrolik.harga_satuan' => 'required',
                'hydraulic.oil_hidrolik.daya_mesin' => 'required',
                'hydraulic.oil_hidrolik.interval' => 'required',
                'hydraulic.engine_oil_filter.koefisien' => 'required',
                'hydraulic.engine_oil_filter.interval' => 'required',
                'hydraulic.fuel_filter_element.koefisien' => 'required',
                'hydraulic.fuel_filter_element.interval' => 'required',
                'hydraulic.final_drive_oil.koefisien' => 'required',
                'hydraulic.final_drive_oil.interval' => 'required',
                'hydraulic.air_cleaner_inner.koefisien' => 'required',
                'hydraulic.air_cleaner_inner.interval' => 'required',
                'hydraulic.air_cleaner_outer.koefisien' => 'required',
                'hydraulic.air_cleaner_outer.interval' => 'required',
                'hydraulic.grase.harga_bulanan' => 'required',
                'hydraulic.grase.interval' => 'required',
                'hydraulic.gaji_operator.harga_bulanan' => 'required',
                'hydraulic.gaji_operator.interval' => 'required',
            ]);

            $koefisienBahanBakar = 70/100 * 0.2 * preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["bahan_bakar"]["harga_satuan"]) *  $request->hydraulic["bahan_bakar"]["daya_mesin"];
            $koefisienOilEngine = ($request->hydraulic["oil_engine"]["faktor_efisien"]/195.5 + $request->hydraulic["oil_engine"]["liter_pemakaian"]/250) * preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["oil_engine"]["harga_satuan"]);
            $koefisienOilHidrolik = (1.2 *$request->hydraulic["oil_hidrolik"]["daya_mesin"]/2000) * preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["oil_hidrolik"]["harga_satuan"]);
            $koefisienMainFuelFilter = preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["fuel_main_filter"]["harga_bulanan"])/1000;
            $koefisienGrase = preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["grase"]["harga_bulanan"])/8;
            $koefisienGajiOperator = preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["gaji_operator"]["harga_bulanan"])/240;
            $parameter = [
                'hargaSatuanBahanBakar' => $request->hydraulic["bahan_bakar"]["harga_satuan"],
                'koefisienBahanBakar' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienBahanBakar,0))),3))),
                'intervalBahanBakar' => $request->hydraulic["bahan_bakar"]["interval"],
                'dayaMesinBahanBakar' => $request->hydraulic["bahan_bakar"]["daya_mesin"],
                
                'hargaSatuanOilEngine' => $request->hydraulic["oil_engine"]["harga_satuan"],
                'literPemakaianOilEngine' => $request->hydraulic["oil_engine"]["liter_pemakaian"],
                'faktorEfisienOilEngine' => $request->hydraulic["oil_engine"]["faktor_efisien"],
                'koefisienOilEngine' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilEngine,0))),3))),
                'intervalOilEngine' => $request->hydraulic["oil_engine"]["interval"],
                
                'koefisienOilHidrolik' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilHidrolik,0))),3))),
                'intervalOilHidrolik' => $request->hydraulic["oil_hidrolik"]["interval"],
                'hargaSatuanOilHidrolik' =>$request->hydraulic["oil_hidrolik"]["harga_satuan"],
                'dayaMesinOilHidrolilk' => $request->hydraulic["oil_hidrolik"]["daya_mesin"],
                
                'koefisienEngineOilFlter' => $request->hydraulic["engine_oil_filter"]["koefisien"],
                'intervalEngineOilFilter' => $request->hydraulic["engine_oil_filter"]["interval"],
                'koefisienFuelFilter' =>  $request->hydraulic["fuel_filter_element"]["koefisien"],
                'intervalFuelFilter' => $request->hydraulic["fuel_filter_element"]["interval"],
                'koefisienFinalDriveOil' => $request->hydraulic["final_drive_oil"]["koefisien"],
                'intervalFinalDriveOil' => $request->hydraulic["final_drive_oil"]["interval"],
                'koefisienAirCleanerInner' => $request->hydraulic["air_cleaner_inner"]["koefisien"],
                'intervalAirCleanerInner' => $request->hydraulic["air_cleaner_inner"]["interval"],
                'koefisienAirCleanerOuter' => $request->hydraulic["air_cleaner_outer"]["koefisien"],
                'intervalAirCleanerOuter' => $request->hydraulic["air_cleaner_outer"]["interval"],
                
                'koefisienFuelMainFilter' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienMainFuelFilter,0))),3))),
                'intervalFuelMainFilter' => $request->hydraulic["fuel_main_filter"]["interval"],
                'hargaBulananFuelMainFilter' => $request->hydraulic["fuel_main_filter"]["harga_bulanan"],
                
                'koefisienGrase' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGrase,0))),3))),
                'intervalGrase' => $request->hydraulic["grase"]["interval"],
                'hargaBulananGrase' => $request->hydraulic["grase"]["harga_bulanan"],
                
                'koefisienGajiOperator' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGajiOperator,0))),3))),
                'intervalGajiOperator' => $request->hydraulic["gaji_operator"]["interval"],
                'hargaBulananGajiOperator' => $request->hydraulic["gaji_operator"]["harga_bulanan"],
            ];
            $hasil = round($koefisienBahanBakar,0) + round($koefisienOilEngine,0) + round($koefisienOilHidrolik,0) + preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["engine_oil_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["fuel_filter_element"]["koefisien"]) + preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["final_drive_oil"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["air_cleaner_inner"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["air_cleaner_outer"]["koefisien"])
                     +round($koefisienMainFuelFilter,0)+round($koefisienGrase,0)+round($koefisienGajiOperator,0);

            $biayaOperasional = New BiayaOperasional;
            $biayaOperasional->id_tipe_alat = $request->id_tipe_alat;
            $biayaOperasional->hasil = $hasil;
            $biayaOperasional->parameter = json_encode($parameter);
            $biayaOperasional->save();

            return $biayaOperasional;
        }else if($request->id_jenis_alat[1] == "Dump Truck"){
            $request->validate([
                'dump.bahan_bakar.harga_satuan' => 'required',
                'dump.bahan_bakar.daya_mesin' => 'required',
                'dump.bahan_bakar.interval' => 'required',
                'dump.oil_engine.harga_satuan' => 'required',
                'dump.oil_engine.liter_pemakaian' => 'required',
                'dump.oil_engine.faktor_efisien' => 'required',
                'dump.oil_engine.interval' => 'required',
                'dump.oil_hidrolik.harga_satuan' => 'required',
                'dump.oil_hidrolik.daya_mesin' => 'required',
                'dump.oil_hidrolik.interval' => 'required',
                'dump.oil_transmisi.koefisien' => 'required',
                'dump.oil_transmisi.interval' => 'required',
                'dump.oil_power_dteering.koefisien' => 'required',
                'dump.oil_power_dteering.interval' => 'required',
                'dump.engine_oil_filter.koefisien' => 'required',
                'dump.engine_oil_filter.interval' => 'required',
                'dump.pre_fuel_filter.koefisien' => 'required',
                'dump.pre_fuel_filter.interval' => 'required',
                'dump.fuel_filter.koefisien' => 'required',
                'dump.fuel_filter.interval' => 'required',
                'dump.air_cleaner_inner.koefisien' => 'required',
                'dump.air_cleaner_inner.interval' => 'required',
                'dump.air_cleaner_outer.koefisien' => 'required',
                'dump.air_cleaner_outer.interval' => 'required',
                'dump.grase.harga_bulanan' => 'required',
                'dump.grase.interval' => 'required',
                'dump.tire_cost.koefisien' => 'required',
                'dump.tire_cost.interval' => 'required',
                'dump.gaji_operator.harga_bulanan' => 'required',
                'dump.gaji_operator.interval' => 'required',
            ]);
            $koefisienBahanBakar = 70/100 * 0.2 * preg_replace('/,.*|[^0-9]/', '', $request->dump["bahan_bakar"]["harga_satuan"]) *  $request->dump["bahan_bakar"]["daya_mesin"];
            $koefisienOilEngine = ($request->dump["oil_engine"]["faktor_efisien"]/195.5 + $request->dump["oil_engine"]["liter_pemakaian"]/250) * preg_replace('/,.*|[^0-9]/', '', $request->dump["oil_engine"]["harga_satuan"]);
            $koefisienOilHidrolik = (1.2 *$request->dump["oil_hidrolik"]["daya_mesin"]/1250) * preg_replace('/,.*|[^0-9]/', '', $request->dump["oil_hidrolik"]["harga_satuan"]);
          
            $koefisienGrase = preg_replace('/,.*|[^0-9]/', '', $request->dump["grase"]["harga_bulanan"])/8;
            $koefisienGajiOperator = preg_replace('/,.*|[^0-9]/', '', $request->dump["gaji_operator"]["harga_bulanan"])/240;
            $parameter = [
                'hargaSatuanBahanBakar' => $request->dump["bahan_bakar"]["harga_satuan"],
                'koefisienBahanBakar' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienBahanBakar,0))),3))),
                'intervalBahanBakar' => $request->dump["bahan_bakar"]["interval"],
                'dayaMesinBahanBakar' => $request->dump["bahan_bakar"]["daya_mesin"],
                
                'koefisienOilEngine' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilEngine,0))),3))),
                'intervalOilEngine' => $request->dump["oil_engine"]["interval"],
                'hargaSatuanOilEngine' => $request->dump["oil_engine"]["harga_satuan"],
                'literPemakaianOilEngine' => $request->dump["oil_engine"]["liter_pemakaian"],
                'faktorEfisienOilEngine' => $request->dump["oil_engine"]["faktor_efisien"],
                
                'koefisienOilHidrolik' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilHidrolik,0))),3))),
                'intervalOilHidrolik' => $request->dump["oil_hidrolik"]["interval"],
                'hargaSatuanOilHidrolik' =>$request->dump["oil_hidrolik"]["harga_satuan"],
                'dayaMesinOilHidrolilk' => $request->dump["oil_hidrolik"]["daya_mesin"],
                
                'koefisienOilTransmisi' => $request->dump["oil_transmisi"]["koefisien"],
                'intervalOilTransmisi' =>  $request->dump["oil_transmisi"]["interval"],
                'koefisienOilPowerDteering' => $request->dump["oil_power_dteering"]["koefisien"],
                'intervalOilPowerDteering' =>  $request->dump["oil_power_dteering"]["interval"],
                'koefisienEngineOilFlter' => $request->dump["engine_oil_filter"]["koefisien"],
                'intervalEngineOilFilter' => $request->dump["engine_oil_filter"]["interval"],
                'koefisienPreFuelFilter' =>  $request->dump["pre_fuel_filter"]["koefisien"],
                'intervalPreFuelFilter' => $request->dump["pre_fuel_filter"]["interval"],
                'koefisienFuelFilter' =>  $request->dump["fuel_filter"]["koefisien"],
                'intervalFuelFilter' => $request->dump["fuel_filter"]["interval"],
                'koefisienAirCleanerInner' => $request->dump["air_cleaner_inner"]["koefisien"],
                'intervalAirCleanerInner' => $request->dump["air_cleaner_inner"]["interval"],
                'koefisienAirCleanerOuter' => $request->dump["air_cleaner_outer"]["koefisien"],
                'intervalAirCleanerOuter' => $request->dump["air_cleaner_outer"]["interval"],
                
                'koefisienGrase' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGrase,0))),3))),
                'intervalGrase' => $request->dump["grase"]["interval"],
                'hargaBulananGrase' => $request->dump["grase"]["harga_bulanan"],

                'koefisienTireCost' => $request->dump["tire_cost"]["koefisien"],
                'intervalTireCost' => $request->dump["tire_cost"]["interval"],
                
                'koefisienGajiOperator' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGajiOperator,0))),3))),
                'intervalGajiOperator' => $request->dump["gaji_operator"]["interval"],
                'hargaBulananGajiOperator' => $request->dump["gaji_operator"]["harga_bulanan"],
            ];
            $hasil = round($koefisienBahanBakar,0) + round($koefisienOilEngine,0) + round($koefisienOilHidrolik,0) + preg_replace('/,.*|[^0-9]/', '', $request->dump["oil_transmisi"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->dump["oil_power_dteering"]["koefisien"]) + preg_replace('/,.*|[^0-9]/', '', $request->dump["engine_oil_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->dump["pre_fuel_filter"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->dump["fuel_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->dump["air_cleaner_inner"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->dump["air_cleaner_outer"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->dump["tire_cost"]["koefisien"])+round($koefisienGrase,0)+round($koefisienGajiOperator,0);

            $biayaOperasional = New BiayaOperasional;
            $biayaOperasional->id_tipe_alat = $request->id_tipe_alat;
            $biayaOperasional->hasil = $hasil;
            $biayaOperasional->parameter = json_encode($parameter);
            $biayaOperasional->save();

            return $biayaOperasional;
        }else if($request->id_jenis_alat[1] == "Bulldozer"){
            $request->validate([
                'bulldozer.bahan_bakar.harga_satuan' => 'required',
                'bulldozer.bahan_bakar.daya_mesin' => 'required',
                'bulldozer.bahan_bakar.interval' => 'required',
                'bulldozer.oil_engine.harga_satuan' => 'required',
                'bulldozer.oil_engine.liter_pemakaian' => 'required',
                'bulldozer.oil_engine.faktor_efisien' => 'required',
                'bulldozer.oil_engine.interval' => 'required',
                'bulldozer.oil_hidrolik.harga_satuan' => 'required',
                'bulldozer.oil_hidrolik.daya_mesin' => 'required',
                'bulldozer.oil_hidrolik.interval' => 'required',
                'bulldozer.engine_oil_filter.koefisien' => 'required',
                'bulldozer.engine_oil_filter.interval' => 'required',
                'bulldozer.pre_fuel_filter.koefisien' => 'required',
                'bulldozer.pre_fuel_filter.interval' => 'required',
                'bulldozer.fuel_filter.koefisien' => 'required',
                'bulldozer.fuel_filter.interval' => 'required',
                'bulldozer.air_cleaner_inner.koefisien' => 'required',
                'bulldozer.air_cleaner_inner.interval' => 'required',
                'bulldozer.air_cleaner_outer.koefisien' => 'required',
                'bulldozer.air_cleaner_outer.interval' => 'required',
                'bulldozer.grase.harga_bulanan' => 'required',
                'bulldozer.grase.interval' => 'required',
                'bulldozer.gaji_operator.harga_bulanan' => 'required',
                'bulldozer.gaji_operator.interval' => 'required',
            ]);
            $koefisienBahanBakar = 70/100 * 0.2 * preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["bahan_bakar"]["harga_satuan"]) *  $request->bulldozer["bahan_bakar"]["daya_mesin"];
            $koefisienOilEngine = ($request->bulldozer["oil_engine"]["faktor_efisien"]/195.5 + $request->bulldozer["oil_engine"]["liter_pemakaian"]/250) * preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["oil_engine"]["harga_satuan"]);
            $koefisienOilHidrolik = (1.2 *$request->bulldozer["oil_hidrolik"]["daya_mesin"]/2000) * preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["oil_hidrolik"]["harga_satuan"]);
          
            $koefisienGrase = preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["grase"]["harga_bulanan"])/8;
            $koefisienGajiOperator = preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["gaji_operator"]["harga_bulanan"])/240;
            $parameter = [
                'koefisienBahanBakar' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienBahanBakar,0))),3))),
                'intervalBahanBakar' => $request->bulldozer["bahan_bakar"]["interval"],
                'hargaSatuanBahanBakar' => $request->bulldozer["bahan_bakar"]["harga_satuan"],
                'dayaMesinBahanBakar' => $request->bulldozer["bahan_bakar"]["daya_mesin"],
                
                'koefisienOilEngine' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilEngine,0))),3))),
                'intervalOilEngine' => $request->bulldozer["oil_engine"]["interval"],
                'hargaSatuanOilEngine' => $request->bulldozer["oil_engine"]["harga_satuan"],
                'literPemakaianOilEngine' => $request->bulldozer["oil_engine"]["liter_pemakaian"],
                'faktorEfisienOilEngine' => $request->bulldozer["oil_engine"]["faktor_efisien"],
                
                'koefisienOilHidrolik' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilHidrolik,0))),3))),
                'intervalOilHidrolik' => $request->bulldozer["oil_hidrolik"]["interval"],
                'hargaSatuanOilHidrolik' =>$request->bulldozer["oil_hidrolik"]["harga_satuan"],
                'dayaMesinOilHidrolilk' => $request->bulldozer["oil_hidrolik"]["daya_mesin"],
                
                'koefisienEngineOilFlter' => $request->bulldozer["engine_oil_filter"]["koefisien"],
                'intervalEngineOilFilter' => $request->bulldozer["engine_oil_filter"]["interval"],
                'koefisienPreFuelFilter' =>  $request->bulldozer["pre_fuel_filter"]["koefisien"],
                'intervalPreFuelFilter' => $request->bulldozer["pre_fuel_filter"]["interval"],
                'koefisienFuelFilter' =>  $request->bulldozer["fuel_filter"]["koefisien"],
                'intervalFuelFilter' => $request->bulldozer["fuel_filter"]["interval"],
                'koefisienAirCleanerInner' => $request->bulldozer["air_cleaner_inner"]["koefisien"],
                'intervalAirCleanerInner' => $request->bulldozer["air_cleaner_inner"]["interval"],
                'koefisienAirCleanerOuter' => $request->bulldozer["air_cleaner_outer"]["koefisien"],
                'intervalAirCleanerOuter' => $request->bulldozer["air_cleaner_outer"]["interval"],
                
                'koefisienGrase' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGrase,0))),3))),
                'intervalGrase' => $request->bulldozer["grase"]["interval"],
                'hargaBulananGrase' => $request->bulldozer["grase"]["harga_bulanan"],
                
                'koefisienGajiOperator' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGajiOperator,0))),3))),
                'intervalGajiOperator' => $request->bulldozer["gaji_operator"]["interval"],
                'hargaBulananGajiOperator' => $request->bulldozer["gaji_operator"]["harga_bulanan"],
                
            ];
            $hasil = round($koefisienBahanBakar,0) + round($koefisienOilEngine,0) + round($koefisienOilHidrolik,0) 
                     +preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["engine_oil_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["pre_fuel_filter"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["fuel_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["air_cleaner_inner"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["air_cleaner_outer"]["koefisien"])
                     +round($koefisienGrase,0)+round($koefisienGajiOperator,0);

            $biayaOperasional = New BiayaOperasional;
            $biayaOperasional->id_tipe_alat = $request->id_tipe_alat;
            $biayaOperasional->hasil = $hasil;
            $biayaOperasional->parameter = json_encode($parameter);
            $biayaOperasional->save();

            return $biayaOperasional;
        }else{
            $request->validate([
                'compactor.bahan_bakar.harga_satuan' => 'required',
                'compactor.bahan_bakar.daya_mesin' => 'required',
                'compactor.bahan_bakar.interval' => 'required',
                'compactor.oil_engine.harga_satuan' => 'required',
                'compactor.oil_engine.liter_pemakaian' => 'required',
                'compactor.oil_engine.faktor_efisien' => 'required',
                'compactor.oil_engine.interval' => 'required',
                'compactor.oil_hidrolik.harga_satuan' => 'required',
                'compactor.oil_hidrolik.daya_mesin' => 'required',
                'compactor.oil_hidrolik.interval' => 'required',
                'compactor.engine_oil_filter.koefisien' => 'required',
                'compactor.engine_oil_filter.interval' => 'required',
                'compactor.fuel_filter_element.koefisien' => 'required',
                'compactor.fuel_filter_element.interval' => 'required',
                'compactor.fuel_water_separator.koefisien' => 'required',
                'compactor.fuel_water_separator.interval' => 'required',
                'compactor.fuel_filter.koefisien' => 'required',
                'compactor.fuel_filter.interval' => 'required',
                'compactor.hydraulic_filter.koefisien' => 'required',
                'compactor.hydraulic_filter.interval' => 'required',
                'compactor.air_cleaner_inner.koefisien' => 'required',
                'compactor.air_cleaner_inner.interval' => 'required',
                'compactor.air_cleaner_outer.koefisien' => 'required',
                'compactor.air_cleaner_outer.interval' => 'required',
                'compactor.grase.harga_bulanan' => 'required',
                'compactor.grase.interval' => 'required',
                'compactor.gaji_operator.harga_bulanan' => 'required',
                'compactor.gaji_operator.interval' => 'required',
            ]);

            $koefisienBahanBakar = 70/100 * 0.2 * preg_replace('/,.*|[^0-9]/', '', $request->compactor["bahan_bakar"]["harga_satuan"]) *  $request->compactor["bahan_bakar"]["daya_mesin"];
            $koefisienOilEngine = ($request->compactor["oil_engine"]["faktor_efisien"]/195.5 + $request->compactor["oil_engine"]["liter_pemakaian"]/250) * preg_replace('/,.*|[^0-9]/', '', $request->compactor["oil_engine"]["harga_satuan"]);
            $koefisienOilHidrolik = (1.2 *$request->compactor["oil_hidrolik"]["daya_mesin"]/2000) * preg_replace('/,.*|[^0-9]/', '', $request->compactor["oil_hidrolik"]["harga_satuan"]);
          
            $koefisienGrase = preg_replace('/,.*|[^0-9]/', '', $request->compactor["grase"]["harga_bulanan"])/8;
            $koefisienGajiOperator = preg_replace('/,.*|[^0-9]/', '', $request->compactor["gaji_operator"]["harga_bulanan"])/240;
            $parameter = [
                'koefisienBahanBakar' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienBahanBakar,0))),3))),
                'intervalBahanBakar' => $request->compactor["bahan_bakar"]["interval"],
                'hargaSatuanBahanBakar' => $request->compactor["bahan_bakar"]["harga_satuan"],
                'dayaMesinBahanBakar' => $request->compactor["bahan_bakar"]["daya_mesin"],
                
                'koefisienOilEngine' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilEngine,0))),3))),
                'intervalOilEngine' => $request->compactor["oil_engine"]["interval"],
                'hargaSatuanOilEngine' => $request->compactor["oil_engine"]["harga_satuan"],
                'literPemakaianOilEngine' => $request->compactor["oil_engine"]["liter_pemakaian"],
                'faktorEfisienOilEngine' => $request->compactor["oil_engine"]["faktor_efisien"],
                
                'koefisienOilHidrolik' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilHidrolik,0))),3))),
                'intervalOilHidrolik' => $request->compactor["oil_hidrolik"]["interval"],
                'hargaSatuanOilHidrolik' =>$request->compactor["oil_hidrolik"]["harga_satuan"],
                'dayaMesinOilHidrolilk' => $request->compactor["oil_hidrolik"]["daya_mesin"],
                
                'koefisienEngineOilFlter' => $request->compactor["engine_oil_filter"]["koefisien"],
                'intervalEngineOilFilter' => $request->compactor["engine_oil_filter"]["interval"],
                'koefisienFuelFilterElement' =>  $request->compactor["fuel_filter_element"]["koefisien"],
                'intervalFuelFilterElement' => $request->compactor["fuel_filter_element"]["interval"],
                'koefisienFuelWaterSeparator' =>  $request->compactor["fuel_water_separator"]["koefisien"],
                'intervalFuelWaterSeparator' => $request->compactor["fuel_water_separator"]["interval"],
                'koefisienFuelFilter' =>  $request->compactor["fuel_filter"]["koefisien"],
                'intervalFuelFilter' => $request->compactor["fuel_filter"]["interval"],
                'koefisienHydraulicFilter' =>  $request->compactor["hydraulic_filter"]["koefisien"],
                'intervalHydraulicFilter' => $request->compactor["hydraulic_filter"]["interval"],
                'koefisienAirCleanerInner' => $request->compactor["air_cleaner_inner"]["koefisien"],
                'intervalAirCleanerInner' => $request->compactor["air_cleaner_inner"]["interval"],
                'koefisienAirCleanerOuter' => $request->compactor["air_cleaner_outer"]["koefisien"],
                'intervalAirCleanerOuter' => $request->compactor["air_cleaner_outer"]["interval"],
                
                'koefisienGrase' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGrase,0))),3))),
                'intervalGrase' => $request->compactor["grase"]["interval"],
                'hargaBulananGrase' => $request->compactor["grase"]["harga_bulanan"],
                
                'koefisienGajiOperator' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGajiOperator,0))),3))),
                'intervalGajiOperator' => $request->compactor["gaji_operator"]["interval"],
                'hargaBulananGajiOperator' => $request->compactor["gaji_operator"]["harga_bulanan"],
            ];
            $hasil = round($koefisienBahanBakar,0) + round($koefisienOilEngine,0) + round($koefisienOilHidrolik,0) + preg_replace('/,.*|[^0-9]/', '', $request->compactor["engine_oil_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->compactor["fuel_filter_element"]["koefisien"]) + preg_replace('/,.*|[^0-9]/', '', $request->compactor["fuel_water_separator"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->compactor["fuel_filter"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->compactor["hydraulic_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->compactor["air_cleaner_inner"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->compactor["air_cleaner_outer"]["koefisien"])
                     +round($koefisienGrase,0)+round($koefisienGajiOperator,0);

            $biayaOperasional = New BiayaOperasional;
            $biayaOperasional->id_tipe_alat = $request->id_tipe_alat;
            $biayaOperasional->hasil = $hasil;
            $biayaOperasional->parameter = json_encode($parameter);
            $biayaOperasional->save();

            return $biayaOperasional;
        }
    }
    
    public function update(Request $request, $id)
    {
        $idTipeAlat = BiayaOperasional::find($id)->id_tipe_alat;
        $idJenisAlat = TipeAlat::find($idTipeAlat)->id_jenis_alat;
        $namaJenisAlat = JenisAlat::find($idJenisAlat)->nama;

        if($namaJenisAlat == "Hydraulic Excavator"){
            $request->validate([
                'hydraulic.bahan_bakar.harga_satuan' => 'required',
                'hydraulic.bahan_bakar.daya_mesin' => 'required',
                'hydraulic.bahan_bakar.interval' => 'required',
                'hydraulic.oil_engine.harga_satuan' => 'required',
                'hydraulic.oil_engine.liter_pemakaian' => 'required',
                'hydraulic.oil_engine.faktor_efisien' => 'required',
                'hydraulic.oil_engine.interval' => 'required',
                'hydraulic.oil_hidrolik.harga_satuan' => 'required',
                'hydraulic.oil_hidrolik.daya_mesin' => 'required',
                'hydraulic.oil_hidrolik.interval' => 'required',
                'hydraulic.engine_oil_filter.koefisien' => 'required',
                'hydraulic.engine_oil_filter.interval' => 'required',
                'hydraulic.fuel_filter_element.koefisien' => 'required',
                'hydraulic.fuel_filter_element.interval' => 'required',
                'hydraulic.final_drive_oil.koefisien' => 'required',
                'hydraulic.final_drive_oil.interval' => 'required',
                'hydraulic.air_cleaner_inner.koefisien' => 'required',
                'hydraulic.air_cleaner_inner.interval' => 'required',
                'hydraulic.air_cleaner_outer.koefisien' => 'required',
                'hydraulic.air_cleaner_outer.interval' => 'required',
                'hydraulic.grase.harga_bulanan' => 'required',
                'hydraulic.grase.interval' => 'required',
                'hydraulic.gaji_operator.harga_bulanan' => 'required',
                'hydraulic.gaji_operator.interval' => 'required',
            ]);

            $koefisienBahanBakar = 70/100 * 0.2 * preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["bahan_bakar"]["harga_satuan"]) *  $request->hydraulic["bahan_bakar"]["daya_mesin"];
            $koefisienOilEngine = ($request->hydraulic["oil_engine"]["faktor_efisien"]/195.5 + $request->hydraulic["oil_engine"]["liter_pemakaian"]/250) * preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["oil_engine"]["harga_satuan"]);
            $koefisienOilHidrolik = (1.2 *$request->hydraulic["oil_hidrolik"]["daya_mesin"]/2000) * preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["oil_hidrolik"]["harga_satuan"]);
            $koefisienMainFuelFilter = preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["fuel_main_filter"]["harga_bulanan"])/1000;
            $koefisienGrase = preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["grase"]["harga_bulanan"])/8;
            $koefisienGajiOperator = preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["gaji_operator"]["harga_bulanan"])/240;
            $parameter = [
                'hargaSatuanBahanBakar' => $request->hydraulic["bahan_bakar"]["harga_satuan"],
                'koefisienBahanBakar' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienBahanBakar,0))),3))),
                'intervalBahanBakar' => $request->hydraulic["bahan_bakar"]["interval"],
                'dayaMesinBahanBakar' => $request->hydraulic["bahan_bakar"]["daya_mesin"],
                
                'hargaSatuanOilEngine' => $request->hydraulic["oil_engine"]["harga_satuan"],
                'literPemakaianOilEngine' => $request->hydraulic["oil_engine"]["liter_pemakaian"],
                'faktorEfisienOilEngine' => $request->hydraulic["oil_engine"]["faktor_efisien"],
                'koefisienOilEngine' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilEngine,0))),3))),
                'intervalOilEngine' => $request->hydraulic["oil_engine"]["interval"],
                
                'koefisienOilHidrolik' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilHidrolik,0))),3))),
                'intervalOilHidrolik' => $request->hydraulic["oil_hidrolik"]["interval"],
                'hargaSatuanOilHidrolik' =>$request->hydraulic["oil_hidrolik"]["harga_satuan"],
                'dayaMesinOilHidrolilk' => $request->hydraulic["oil_hidrolik"]["daya_mesin"],
                
                'koefisienEngineOilFlter' => $request->hydraulic["engine_oil_filter"]["koefisien"],
                'intervalEngineOilFilter' => $request->hydraulic["engine_oil_filter"]["interval"],
                'koefisienFuelFilter' =>  $request->hydraulic["fuel_filter_element"]["koefisien"],
                'intervalFuelFilter' => $request->hydraulic["fuel_filter_element"]["interval"],
                'koefisienFinalDriveOil' => $request->hydraulic["final_drive_oil"]["koefisien"],
                'intervalFinalDriveOil' => $request->hydraulic["final_drive_oil"]["interval"],
                'koefisienAirCleanerInner' => $request->hydraulic["air_cleaner_inner"]["koefisien"],
                'intervalAirCleanerInner' => $request->hydraulic["air_cleaner_inner"]["interval"],
                'koefisienAirCleanerOuter' => $request->hydraulic["air_cleaner_outer"]["koefisien"],
                'intervalAirCleanerOuter' => $request->hydraulic["air_cleaner_outer"]["interval"],
                
                'koefisienFuelMainFilter' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienMainFuelFilter,0))),3))),
                'intervalFuelMainFilter' => $request->hydraulic["fuel_main_filter"]["interval"],
                'hargaBulananFuelMainFilter' => $request->hydraulic["fuel_main_filter"]["harga_bulanan"],
                
                'koefisienGrase' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGrase,0))),3))),
                'intervalGrase' => $request->hydraulic["grase"]["interval"],
                'hargaBulananGrase' => $request->hydraulic["grase"]["harga_bulanan"],
                
                'koefisienGajiOperator' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGajiOperator,0))),3))),
                'intervalGajiOperator' => $request->hydraulic["gaji_operator"]["interval"],
                'hargaBulananGajiOperator' => $request->hydraulic["gaji_operator"]["harga_bulanan"],
            ];
            $hasil = round($koefisienBahanBakar,0) + round($koefisienOilEngine,0) + round($koefisienOilHidrolik,0) + preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["engine_oil_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["fuel_filter_element"]["koefisien"]) + preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["final_drive_oil"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["air_cleaner_inner"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->hydraulic["air_cleaner_outer"]["koefisien"])
                     +round($koefisienMainFuelFilter,0)+round($koefisienGrase,0)+round($koefisienGajiOperator,0);

            $biayaOperasional = BiayaOperasional::find($id);
            $biayaOperasional->hasil = $hasil;
            $biayaOperasional->parameter = json_encode($parameter);
            $biayaOperasional->save();

            return $biayaOperasional;
        }else if($namaJenisAlat == "Dump Truck"){
            $request->validate([
                'dump.bahan_bakar.harga_satuan' => 'required',
                'dump.bahan_bakar.daya_mesin' => 'required',
                'dump.bahan_bakar.interval' => 'required',
                'dump.oil_engine.harga_satuan' => 'required',
                'dump.oil_engine.liter_pemakaian' => 'required',
                'dump.oil_engine.faktor_efisien' => 'required',
                'dump.oil_engine.interval' => 'required',
                'dump.oil_hidrolik.harga_satuan' => 'required',
                'dump.oil_hidrolik.daya_mesin' => 'required',
                'dump.oil_hidrolik.interval' => 'required',
                'dump.oil_transmisi.koefisien' => 'required',
                'dump.oil_transmisi.interval' => 'required',
                'dump.oil_power_dteering.koefisien' => 'required',
                'dump.oil_power_dteering.interval' => 'required',
                'dump.engine_oil_filter.koefisien' => 'required',
                'dump.engine_oil_filter.interval' => 'required',
                'dump.pre_fuel_filter.koefisien' => 'required',
                'dump.pre_fuel_filter.interval' => 'required',
                'dump.fuel_filter.koefisien' => 'required',
                'dump.fuel_filter.interval' => 'required',
                'dump.air_cleaner_inner.koefisien' => 'required',
                'dump.air_cleaner_inner.interval' => 'required',
                'dump.air_cleaner_outer.koefisien' => 'required',
                'dump.air_cleaner_outer.interval' => 'required',
                'dump.grase.harga_bulanan' => 'required',
                'dump.grase.interval' => 'required',
                'dump.tire_cost.koefisien' => 'required',
                'dump.tire_cost.interval' => 'required',
                'dump.gaji_operator.harga_bulanan' => 'required',
                'dump.gaji_operator.interval' => 'required',
            ]);
            $koefisienBahanBakar = 70/100 * 0.2 * preg_replace('/,.*|[^0-9]/', '', $request->dump["bahan_bakar"]["harga_satuan"]) *  $request->dump["bahan_bakar"]["daya_mesin"];
            $koefisienOilEngine = ($request->dump["oil_engine"]["faktor_efisien"]/195.5 + $request->dump["oil_engine"]["liter_pemakaian"]/250) * preg_replace('/,.*|[^0-9]/', '', $request->dump["oil_engine"]["harga_satuan"]);
            $koefisienOilHidrolik = (1.2 *$request->dump["oil_hidrolik"]["daya_mesin"]/1250) * preg_replace('/,.*|[^0-9]/', '', $request->dump["oil_hidrolik"]["harga_satuan"]);
          
            $koefisienGrase = preg_replace('/,.*|[^0-9]/', '', $request->dump["grase"]["harga_bulanan"])/8;
            $koefisienGajiOperator = preg_replace('/,.*|[^0-9]/', '', $request->dump["gaji_operator"]["harga_bulanan"])/240;
            $parameter = [
                'hargaSatuanBahanBakar' => $request->dump["bahan_bakar"]["harga_satuan"],
                'koefisienBahanBakar' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienBahanBakar,0))),3))),
                'intervalBahanBakar' => $request->dump["bahan_bakar"]["interval"],
                'dayaMesinBahanBakar' => $request->dump["bahan_bakar"]["daya_mesin"],
                
                'koefisienOilEngine' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilEngine,0))),3))),
                'intervalOilEngine' => $request->dump["oil_engine"]["interval"],
                'hargaSatuanOilEngine' => $request->dump["oil_engine"]["harga_satuan"],
                'literPemakaianOilEngine' => $request->dump["oil_engine"]["liter_pemakaian"],
                'faktorEfisienOilEngine' => $request->dump["oil_engine"]["faktor_efisien"],
                
                'koefisienOilHidrolik' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilHidrolik,0))),3))),
                'intervalOilHidrolik' => $request->dump["oil_hidrolik"]["interval"],
                'hargaSatuanOilHidrolik' =>$request->dump["oil_hidrolik"]["harga_satuan"],
                'dayaMesinOilHidrolilk' => $request->dump["oil_hidrolik"]["daya_mesin"],
                
                'koefisienOilTransmisi' => $request->dump["oil_transmisi"]["koefisien"],
                'intervalOilTransmisi' =>  $request->dump["oil_transmisi"]["interval"],
                'koefisienOilPowerDteering' => $request->dump["oil_power_dteering"]["koefisien"],
                'intervalOilPowerDteering' =>  $request->dump["oil_power_dteering"]["interval"],
                'koefisienEngineOilFlter' => $request->dump["engine_oil_filter"]["koefisien"],
                'intervalEngineOilFilter' => $request->dump["engine_oil_filter"]["interval"],
                'koefisienPreFuelFilter' =>  $request->dump["pre_fuel_filter"]["koefisien"],
                'intervalPreFuelFilter' => $request->dump["pre_fuel_filter"]["interval"],
                'koefisienFuelFilter' =>  $request->dump["fuel_filter"]["koefisien"],
                'intervalFuelFilter' => $request->dump["fuel_filter"]["interval"],
                'koefisienAirCleanerInner' => $request->dump["air_cleaner_inner"]["koefisien"],
                'intervalAirCleanerInner' => $request->dump["air_cleaner_inner"]["interval"],
                'koefisienAirCleanerOuter' => $request->dump["air_cleaner_outer"]["koefisien"],
                'intervalAirCleanerOuter' => $request->dump["air_cleaner_outer"]["interval"],
                
                'koefisienGrase' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGrase,0))),3))),
                'intervalGrase' => $request->dump["grase"]["interval"],
                'hargaBulananGrase' => $request->dump["grase"]["harga_bulanan"],

                'koefisienTireCost' => $request->dump["tire_cost"]["koefisien"],
                'intervalTireCost' => $request->dump["tire_cost"]["interval"],
                
                'koefisienGajiOperator' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGajiOperator,0))),3))),
                'intervalGajiOperator' => $request->dump["gaji_operator"]["interval"],
                'hargaBulananGajiOperator' => $request->dump["gaji_operator"]["harga_bulanan"],
            ];
            $hasil = round($koefisienBahanBakar,0) + round($koefisienOilEngine,0) + round($koefisienOilHidrolik,0) + preg_replace('/,.*|[^0-9]/', '', $request->dump["oil_transmisi"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->dump["oil_power_dteering"]["koefisien"]) + preg_replace('/,.*|[^0-9]/', '', $request->dump["engine_oil_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->dump["pre_fuel_filter"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->dump["fuel_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->dump["air_cleaner_inner"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->dump["air_cleaner_outer"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->dump["tire_cost"]["koefisien"])+round($koefisienGrase,0)+round($koefisienGajiOperator,0);

            $biayaOperasional = BiayaOperasional::find($id);
            $biayaOperasional->hasil = $hasil;
            $biayaOperasional->parameter = json_encode($parameter);
            $biayaOperasional->save();

            return $biayaOperasional;
        }else if($namaJenisAlat == "Bulldozer"){
            $request->validate([
                'bulldozer.bahan_bakar.harga_satuan' => 'required',
                'bulldozer.bahan_bakar.daya_mesin' => 'required',
                'bulldozer.bahan_bakar.interval' => 'required',
                'bulldozer.oil_engine.harga_satuan' => 'required',
                'bulldozer.oil_engine.liter_pemakaian' => 'required',
                'bulldozer.oil_engine.faktor_efisien' => 'required',
                'bulldozer.oil_engine.interval' => 'required',
                'bulldozer.oil_hidrolik.harga_satuan' => 'required',
                'bulldozer.oil_hidrolik.daya_mesin' => 'required',
                'bulldozer.oil_hidrolik.interval' => 'required',
                'bulldozer.engine_oil_filter.koefisien' => 'required',
                'bulldozer.engine_oil_filter.interval' => 'required',
                'bulldozer.pre_fuel_filter.koefisien' => 'required',
                'bulldozer.pre_fuel_filter.interval' => 'required',
                'bulldozer.fuel_filter.koefisien' => 'required',
                'bulldozer.fuel_filter.interval' => 'required',
                'bulldozer.air_cleaner_inner.koefisien' => 'required',
                'bulldozer.air_cleaner_inner.interval' => 'required',
                'bulldozer.air_cleaner_outer.koefisien' => 'required',
                'bulldozer.air_cleaner_outer.interval' => 'required',
                'bulldozer.grase.harga_bulanan' => 'required',
                'bulldozer.grase.interval' => 'required',
                'bulldozer.gaji_operator.harga_bulanan' => 'required',
                'bulldozer.gaji_operator.interval' => 'required',
            ]);
            $koefisienBahanBakar = 70/100 * 0.2 * preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["bahan_bakar"]["harga_satuan"]) *  $request->bulldozer["bahan_bakar"]["daya_mesin"];
            $koefisienOilEngine = ($request->bulldozer["oil_engine"]["faktor_efisien"]/195.5 + $request->bulldozer["oil_engine"]["liter_pemakaian"]/250) * preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["oil_engine"]["harga_satuan"]);
            $koefisienOilHidrolik = (1.2 *$request->bulldozer["oil_hidrolik"]["daya_mesin"]/2000) * preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["oil_hidrolik"]["harga_satuan"]);
          
            $koefisienGrase = preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["grase"]["harga_bulanan"])/8;
            $koefisienGajiOperator = preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["gaji_operator"]["harga_bulanan"])/240;
            $parameter = [
                'koefisienBahanBakar' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienBahanBakar,0))),3))),
                'intervalBahanBakar' => $request->bulldozer["bahan_bakar"]["interval"],
                'hargaSatuanBahanBakar' => $request->bulldozer["bahan_bakar"]["harga_satuan"],
                'dayaMesinBahanBakar' => $request->bulldozer["bahan_bakar"]["daya_mesin"],
                
                'koefisienOilEngine' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilEngine,0))),3))),
                'intervalOilEngine' => $request->bulldozer["oil_engine"]["interval"],
                'hargaSatuanOilEngine' => $request->bulldozer["oil_engine"]["harga_satuan"],
                'literPemakaianOilEngine' => $request->bulldozer["oil_engine"]["liter_pemakaian"],
                'faktorEfisienOilEngine' => $request->bulldozer["oil_engine"]["faktor_efisien"],
                
                'koefisienOilHidrolik' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilHidrolik,0))),3))),
                'intervalOilHidrolik' => $request->bulldozer["oil_hidrolik"]["interval"],
                'hargaSatuanOilHidrolik' =>$request->bulldozer["oil_hidrolik"]["harga_satuan"],
                'dayaMesinOilHidrolilk' => $request->bulldozer["oil_hidrolik"]["daya_mesin"],
                
                'koefisienEngineOilFlter' => $request->bulldozer["engine_oil_filter"]["koefisien"],
                'intervalEngineOilFilter' => $request->bulldozer["engine_oil_filter"]["interval"],
                'koefisienPreFuelFilter' =>  $request->bulldozer["pre_fuel_filter"]["koefisien"],
                'intervalPreFuelFilter' => $request->bulldozer["pre_fuel_filter"]["interval"],
                'koefisienFuelFilter' =>  $request->bulldozer["fuel_filter"]["koefisien"],
                'intervalFuelFilter' => $request->bulldozer["fuel_filter"]["interval"],
                'koefisienAirCleanerInner' => $request->bulldozer["air_cleaner_inner"]["koefisien"],
                'intervalAirCleanerInner' => $request->bulldozer["air_cleaner_inner"]["interval"],
                'koefisienAirCleanerOuter' => $request->bulldozer["air_cleaner_outer"]["koefisien"],
                'intervalAirCleanerOuter' => $request->bulldozer["air_cleaner_outer"]["interval"],
                
                'koefisienGrase' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGrase,0))),3))),
                'intervalGrase' => $request->bulldozer["grase"]["interval"],
                'hargaBulananGrase' => $request->bulldozer["grase"]["harga_bulanan"],
                
                'koefisienGajiOperator' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGajiOperator,0))),3))),
                'intervalGajiOperator' => $request->bulldozer["gaji_operator"]["interval"],
                'hargaBulananGajiOperator' => $request->bulldozer["gaji_operator"]["harga_bulanan"],
                
            ];
            $hasil = round($koefisienBahanBakar,0) + round($koefisienOilEngine,0) + round($koefisienOilHidrolik,0) 
                     +preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["engine_oil_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["pre_fuel_filter"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["fuel_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["air_cleaner_inner"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->bulldozer["air_cleaner_outer"]["koefisien"])
                     +round($koefisienGrase,0)+round($koefisienGajiOperator,0);

            $biayaOperasional = BiayaOperasional::find($id);
            $biayaOperasional->hasil = $hasil;
            $biayaOperasional->parameter = json_encode($parameter);
            $biayaOperasional->save();

            return $biayaOperasional;
        }else{
            $request->validate([
                'compactor.bahan_bakar.harga_satuan' => 'required',
                'compactor.bahan_bakar.daya_mesin' => 'required',
                'compactor.bahan_bakar.interval' => 'required',
                'compactor.oil_engine.harga_satuan' => 'required',
                'compactor.oil_engine.liter_pemakaian' => 'required',
                'compactor.oil_engine.faktor_efisien' => 'required',
                'compactor.oil_engine.interval' => 'required',
                'compactor.oil_hidrolik.harga_satuan' => 'required',
                'compactor.oil_hidrolik.daya_mesin' => 'required',
                'compactor.oil_hidrolik.interval' => 'required',
                'compactor.engine_oil_filter.koefisien' => 'required',
                'compactor.engine_oil_filter.interval' => 'required',
                'compactor.fuel_filter_element.koefisien' => 'required',
                'compactor.fuel_filter_element.interval' => 'required',
                'compactor.fuel_water_separator.koefisien' => 'required',
                'compactor.fuel_water_separator.interval' => 'required',
                'compactor.fuel_filter.koefisien' => 'required',
                'compactor.fuel_filter.interval' => 'required',
                'compactor.hydraulic_filter.koefisien' => 'required',
                'compactor.hydraulic_filter.interval' => 'required',
                'compactor.air_cleaner_inner.koefisien' => 'required',
                'compactor.air_cleaner_inner.interval' => 'required',
                'compactor.air_cleaner_outer.koefisien' => 'required',
                'compactor.air_cleaner_outer.interval' => 'required',
                'compactor.grase.harga_bulanan' => 'required',
                'compactor.grase.interval' => 'required',
                'compactor.gaji_operator.harga_bulanan' => 'required',
                'compactor.gaji_operator.interval' => 'required',
            ]);

            $koefisienBahanBakar = 70/100 * 0.2 * preg_replace('/,.*|[^0-9]/', '', $request->compactor["bahan_bakar"]["harga_satuan"]) *  $request->compactor["bahan_bakar"]["daya_mesin"];
            $koefisienOilEngine = ($request->compactor["oil_engine"]["faktor_efisien"]/195.5 + $request->compactor["oil_engine"]["liter_pemakaian"]/250) * preg_replace('/,.*|[^0-9]/', '', $request->compactor["oil_engine"]["harga_satuan"]);
            $koefisienOilHidrolik = (1.2 *$request->compactor["oil_hidrolik"]["daya_mesin"]/2000) * preg_replace('/,.*|[^0-9]/', '', $request->compactor["oil_hidrolik"]["harga_satuan"]);
          
            $koefisienGrase = preg_replace('/,.*|[^0-9]/', '', $request->compactor["grase"]["harga_bulanan"])/8;
            $koefisienGajiOperator = preg_replace('/,.*|[^0-9]/', '', $request->compactor["gaji_operator"]["harga_bulanan"])/240;
            $parameter = [
                'koefisienBahanBakar' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienBahanBakar,0))),3))),
                'intervalBahanBakar' => $request->compactor["bahan_bakar"]["interval"],
                'hargaSatuanBahanBakar' => $request->compactor["bahan_bakar"]["harga_satuan"],
                'dayaMesinBahanBakar' => $request->compactor["bahan_bakar"]["daya_mesin"],
                
                'koefisienOilEngine' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilEngine,0))),3))),
                'intervalOilEngine' => $request->compactor["oil_engine"]["interval"],
                'hargaSatuanOilEngine' => $request->compactor["oil_engine"]["harga_satuan"],
                'literPemakaianOilEngine' => $request->compactor["oil_engine"]["liter_pemakaian"],
                'faktorEfisienOilEngine' => $request->compactor["oil_engine"]["faktor_efisien"],
                
                'koefisienOilHidrolik' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienOilHidrolik,0))),3))),
                'intervalOilHidrolik' => $request->compactor["oil_hidrolik"]["interval"],
                'hargaSatuanOilHidrolik' =>$request->compactor["oil_hidrolik"]["harga_satuan"],
                'dayaMesinOilHidrolilk' => $request->compactor["oil_hidrolik"]["daya_mesin"],
                
                'koefisienEngineOilFlter' => $request->compactor["engine_oil_filter"]["koefisien"],
                'intervalEngineOilFilter' => $request->compactor["engine_oil_filter"]["interval"],
                'koefisienFuelFilterElement' =>  $request->compactor["fuel_filter_element"]["koefisien"],
                'intervalFuelFilterElement' => $request->compactor["fuel_filter_element"]["interval"],
                'koefisienFuelWaterSeparator' =>  $request->compactor["fuel_water_separator"]["koefisien"],
                'intervalFuelWaterSeparator' => $request->compactor["fuel_water_separator"]["interval"],
                'koefisienFuelFilter' =>  $request->compactor["fuel_filter"]["koefisien"],
                'intervalFuelFilter' => $request->compactor["fuel_filter"]["interval"],
                'koefisienHydraulicFilter' =>  $request->compactor["hydraulic_filter"]["koefisien"],
                'intervalHydraulicFilter' => $request->compactor["hydraulic_filter"]["interval"],
                'koefisienAirCleanerInner' => $request->compactor["air_cleaner_inner"]["koefisien"],
                'intervalAirCleanerInner' => $request->compactor["air_cleaner_inner"]["interval"],
                'koefisienAirCleanerOuter' => $request->compactor["air_cleaner_outer"]["koefisien"],
                'intervalAirCleanerOuter' => $request->compactor["air_cleaner_outer"]["interval"],
                
                'koefisienGrase' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGrase,0))),3))),
                'intervalGrase' => $request->compactor["grase"]["interval"],
                'hargaBulananGrase' => $request->compactor["grase"]["harga_bulanan"],
                
                'koefisienGajiOperator' => 'Rp. '.strrev(implode('.',str_split(strrev(strval(round($koefisienGajiOperator,0))),3))),
                'intervalGajiOperator' => $request->compactor["gaji_operator"]["interval"],
                'hargaBulananGajiOperator' => $request->compactor["gaji_operator"]["harga_bulanan"],
            ];
            $hasil = round($koefisienBahanBakar,0) + round($koefisienOilEngine,0) + round($koefisienOilHidrolik,0) + preg_replace('/,.*|[^0-9]/', '', $request->compactor["engine_oil_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->compactor["fuel_filter_element"]["koefisien"]) + preg_replace('/,.*|[^0-9]/', '', $request->compactor["fuel_water_separator"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->compactor["fuel_filter"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->compactor["hydraulic_filter"]["koefisien"])
                     +preg_replace('/,.*|[^0-9]/', '', $request->compactor["air_cleaner_inner"]["koefisien"])+preg_replace('/,.*|[^0-9]/', '', $request->compactor["air_cleaner_outer"]["koefisien"])
                     +round($koefisienGrase,0)+round($koefisienGajiOperator,0);

            $biayaOperasional = BiayaOperasional::find($id);
            $biayaOperasional->id_tipe_alat = $request->id_tipe_alat;
            $biayaOperasional->hasil = $hasil;
            $biayaOperasional->parameter = json_encode($parameter);
            $biayaOperasional->save();

            return $biayaOperasional;
        }
    }

    public function destroy($id)
    {
       return BiayaOperasional::find($id)->delete();
    }
}
