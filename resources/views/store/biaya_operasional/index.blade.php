@extends('layout.master')
@section('title')
Biaya Operasional
@endsection
@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <form @submit.prevent="filterData()" @keydown="form.onKeydown($event)" id="formPasien">
          <div class="row my-4">
              <div class="col md-12">
                <div class="form-row">
                  <label class="col-lg-2" for="id_proyek">Proyek</label>
                  <div class="form-group col-md-10">
                    <select v-model="form.id_proyek" id="id_proyek" onchange="selectTrigger()" placeholder="Pilih Proyek"
                        style="width: 100%" class="form-control custom-select">
                        <option disabled value="">- Pilih Proyek -</option>
                        <option v-for="item in allProyek" :value="item.id">
                            @{{item.nama }}</option>
                    </select>
                    <has-error :form="form" field="id_proyek"></has-error>
                  </div>
                </div>
                <div class="form-row">
                  <label class="col-lg-2" for="id_jenis_alat">Jenis Alat</label>
                  <div class="form-group col-md-10">
                    <select v-model="form.id_jenis_alat" id="id_jenis_alat" onchange="selectTriggerJenisAlat()" placeholder="Pilih Jenis Alat"
                        style="width: 100%" class="form-control custom-select">
                        <option disabled value="">- Pilih Jenis Alat -</option>
                        <option v-for="item in allJenisAlat" :value="item.id">
                            @{{item.nama }}</option>
                    </select>
                    <has-error :form="form" field="id_jenis_alat"></has-error>
                  </div>
                </div>
                <div class="form-row">
                  <label class="col-lg-2" for="id_tipe_alat">Tipe Alat</label>
                  <div class="form-group col-md-10">
                    <select v-model="form.id_tipe_alat" id="id_tipe_alat" onchange="selectTriggerTipeAlat()" placeholder="Pilih Tipe Alat"
                        style="width: 100%" class="form-control custom-select">
                        <option disabled value="">- Pilih Tipe Alat -</option>
                        <option v-for="item in allTipeAlat" :value="item.id">
                            @{{item.nama }}</option>
                    </select>
                    <has-error :form="form" field="id_tipe_alat"></has-error>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-reset" data-dismiss="modal" @click="resetData()">Reset</button>
              <button type="submit" class="btn btn-search">Filter</button>
          </div>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"> Daftar Biaya Operasional
            <button type="button" class="btn btn-primary btn-rounded float-right mb-3" @click="createModal()">
            <i class="fas fa-plus-circle"></i> Tambah Biaya Operasional</button>
          </h4>
          
          <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-wrap">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Tipe Alat</th>
                    <th>Interval (Jam)</th>
                    <th>Koefisien (Rp)</th>
                    <th>Total Biaya</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="item, index in mainData" :key="index">
                  <td>@{{ index+1 }}</td>
                  <td>@{{ item.nama_tipe_alat}}</td>
                  <td v-html="item.interval"></td>
                  <td v-html="item.koefisien"></td>
                  <td v-html="item.hasil"></td>
                  <td>
                    <a href="javascript:void(0);" @click="editModal(item)" class="text-success"
                      data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i
                      class="far fa-edit"></i></a>
                    <a href="javascript:void(0);" @click="deleteData(item.id)" class="text-danger"
                      data-toggle="tooltip" data-placement="top" data-original-title="Hapus"><i
                      class="far fa-trash-alt"></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL -->
<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-full-width modal-dialog-scrollable" id="modal" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <h4 class="modal-title" v-show="!editMode" id="myLargeModalLabel">Tambah Biaya Operasional</h4>
        <h4 class="modal-title" v-show="editMode" id="myLargeModalLabel">Edit</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="emptyFilter">×</button>
      </div>
      {{-- <form @submit.prevent="editMode ? updateData() : storeData()" @keydown="form.onKeydown($event)" id="form"> --}}
          <div class="modal-body mx-4">
            <div v-show="!editMode">
              <div class="form-row">
                <label class="col-lg-2" for="id_proyek">Proyek</label>
                <div class="form-group col-md-10">
                  <select v-model="form.id_proyek" id="id_proyek_modal" onchange="selectTrigger()" placeholder="Pilih Proyek"
                      style="width: 100%" class="form-control custom-select">
                      <option disabled value="">- Pilih Proyek -</option>
                      <option v-for="item in allProyek" :value="item.id">
                          @{{item.nama }}</option>
                  </select>
                  <has-error :form="form" field="id_proyek"></has-error>
                </div>
              </div>
              <div class="form-row">
                <label class="col-lg-2" for="id_jenis_alat_modal">Jenis Alat</label>
                <div class="form-group col-md-10">
                  <select v-model="form.id_jenis_alat" id="id_jenis_alat_modal" onchange="selectTriggerJenisAlat()" placeholder="Pilih Jenis Alat"
                      style="width: 100%" class="form-control custom-select">
                      <option disabled value="">- Pilih Jenis Alat -</option>
                      <option v-for="item in allJenisAlat" :value="[item.id,item.nama]">
                          @{{item.nama }}</option>
                  </select>
                  <has-error :form="form" field="id_jenis_alat"></has-error>
                </div>
              </div>
              <div class="form-row">
                <label class="col-lg-2" for="id_tipe_alat">Tipe Alat</label>
                <div class="form-group col-md-10">
                  <select v-model="form.id_tipe_alat" id="id_tipe_alat" onchange="selectTriggerTipeAlat()" placeholder="Pilih Tipe Alat"
                      style="width: 100%" class="form-control custom-select">
                      <option disabled value="">- Pilih Tipe Alat -</option>
                      <option v-for="item in allTipeAlat" :value="item.id">
                          @{{item.nama }}</option>
                  </select>
                  <has-error :form="form" field="id_tipe_alat"></has-error>
                </div>
              </div>
            </div>
            @include('store.biaya_operasional.form.hydraulic')
            @include('store.biaya_operasional.form.dump')
            @include('store.biaya_operasional.form.bulldozer')
            @include('store.biaya_operasional.form.compactor')
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal" @click="emptyFilter">Batal</button>
            <button v-show="!editMode" type="submit" class="btn btn-primary" @click="storeData">Tambah</button>
            <button v-show="editMode" type="submit" class="btn btn-success" @click="updateData">Ubah</button>
          </div>
      {{-- </form> --}}
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
  function selectTrigger(isModal) {
    if($("#id_proyek").val()!==null){
      app.getJenisAlat($("#id_proyek").val())
    }else{
      app.getJenisAlat($("#id_proyek_modal").val())
    }
    app.inputSelect()
  }

  function selectTriggerJenisAlat(){
    if($("#id_jenis_alat").val()!==null){
      app.getTipeAlat($("#id_jenis_alat").val())
    }else{
      let jenisAlat = $("#id_jenis_alat_modal").val()
      let splitStringJenisAlat = jenisAlat.split(",")
      app.getTipeAlat(splitStringJenisAlat[0])
      app.showFieldModal(splitStringJenisAlat[1])
    }
    app.inputSelectJenisAlat()
  }

  function selectTriggerTipeAlat(){
    app.inputSelectTipeAlat()
  }

  var app = new Vue({
    el: '#app',
    data: {
      mainData: [],
      form: new Form({
        id: '',
        id_proyek:'',
        id_jenis_alat: '',
        id_tipe_alat: '',
        hydraulic: {
          bahan_bakar: {
            harga_satuan: '',
            interval : '',
            daya_mesin:'',
          },
          oil_engine:{
             harga_satuan : '',
             liter_pemakaian :'',
             faktor_efisien : '',
             interval: '',
          },
          oil_hidrolik : {
            harga_satuan: '',
            liter_pemakaian :'',
            interval : '',
            daya_mesin: '',
          },
          engine_oil_filter: {
            koefisien : '',
            interval : '',
          },
          fuel_filter_element: {
            koefisien:'',
            interval : '',
          },
          final_drive_oil : {
            interval : '',
            koefisien : '',
          },
          air_cleaner_inner: {
            koefisien: '',
            interval: '',
          },
          air_cleaner_outer: {
            koefisien :'',
            interval: '',
          },
          fuel_main_filter: {
            harga_bulanan :'',
            interval: '',
          },
          grase : {
            harga_bulanan: '',
            interval: '',
          },
          gaji_operator: {
            harga_bulanan: '',
            interval : '',
          },
        },
        dump:{
          bahan_bakar: {
            harga_satuan: '',
            interval : '',
            daya_mesin:'',
          },
          oil_engine:{
             harga_satuan : '',
             liter_pemakaian :'',
             persen_pemakaian : '',
             interval: '',
          },
          oil_hidrolik : {
            harga_satuan: '',
            liter_pemakaian :'',
            interval : '',
          },
          oil_transmisi:{
            koefisien: '',
            interval: '',
          },
          oil_power_dteering:{
            koefisien: '',
            interval : '',
          },
          engine_oil_filter: {
            koefisien : '',
            interval : '',
          },
          pre_fuel_filter: {
            koefisien : '',
            interval: '',
          },
          fuel_filter : {
            koefisien : '',
            interval : '',
          },
          air_cleaner_inner: {
            koefisien: '',
            interval: '',
          },
          air_cleaner_outer: {
            koefisien: '',
            interval: '',
          },
          grase : {
            harga_bulanan: '',
            interval: '',
          },
          tire_cost:{
            koefisien: '',
            interval: '',
          },
          gaji_operator: {
            harga_bulanan: '',
            interval : '',
          },
        },
        bulldozer:{
          bahan_bakar: {
            harga_satuan: '',
            interval : '',
            daya_mesin:'',
          },
          oil_engine:{
             harga_satuan : '',
             liter_pemakaian :'',
             persen_pemakaian : '',
             interval: '',
          },
          oil_hidrolik : {
            harga_satuan: '',
            liter_pemakaian :'',
            interval : '',
            daya_mesin:'',
          },
          engine_oil_filter: {
            harga_bulanan : '',
            interval : '',
          },
          pre_fuel_filter: {
            koefisien : '',
            interval: '',
          },
          fuel_filter : {
            koefisien : '',
            interval : '',
          },
          air_cleaner_inner: {
            koefisien: '',
            interval: '',
          },
          air_cleaner_outer: {
            koefisien :'',
            interval: '',
          },
          grase : {
            harga_bulanan: '',
            interval: '',
          },
          gaji_operator: {
            harga_bulanan: '',
            interval : '',
          },
        },
        compactor:{
          bahan_bakar: {
            harga_satuan: '',
            interval : '',
            daya_mesin:'',
          },
          oil_engine:{
             harga_satuan : '',
             liter_pemakaian :'',
             persen_pemakaian : '',
             interval: '',
          },
          oil_hidrolik : {
            harga_satuan: '',
            liter_pemakaian :'',
            interval : '',
            daya_mesin:'',
          },
          engine_oil_filter: {
            koefisien : '',
            interval : '',
          },
          fuel_filter_element : {
            koefisien : '',
            interval : '',
          },
          fuel_water_separator: {
            koefisien: '',
            interval : '',
          },
          fuel_filter:{
            koefisien: '',
            interval: '',
          },
          hydraulic_filter:{
            koefisien:'',
            interval : '',
          },
          air_cleaner_inner: {
            koefisien: '',
            interval: '',
          },
          air_cleaner_outer: {
            koefisien :'',
            interval: '',
          },
          grase : {
            harga_bulanan: '',
            interval: '',
          },
          gaji_operator: {
            harga_bulanan: '',
            interval : '',
          },
        }
      }),
      editMode: false,
      allProyek : @json($allProyek),
      allJenisAlat: [],
      allTipeAlat : [],
      editMode: false,
      hydraulicMode:false,
      dumpMode:false,
      bulldozerMode:false,
      compactorMode:false,
      hargaSatuan:'',
    },
    mounted() {
      this.refreshData()
    },
    watch:{
      'form.bulldozer.bahan_bakar.harga_satuan'(newVal){
        this.form.bulldozer.bahan_bakar.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.bulldozer.oil_engine.harga_satuan'(newVal){
        this.form.bulldozer.oil_engine.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.bulldozer.oil_hidrolik.harga_satuan'(newVal){
        this.form.bulldozer.oil_hidrolik.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.bulldozer.fuel_filter.koefisien'(newVal){
        this.form.bulldozer.fuel_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.bulldozer.grase.harga_bulanan'(newVal){
        this.form.bulldozer.grase.harga_bulanan = formatRupiah(newVal,"Rp ")
      },
      'form.bulldozer.gaji_operator.harga_bulanan'(newVal){
        this.form.bulldozer.gaji_operator.harga_bulanan = formatRupiah(newVal,"Rp ")
      },
      'form.bulldozer.engine_oil_filter.koefisien'(newVal){
        this.form.bulldozer.engine_oil_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.bulldozer.pre_fuel_filter.koefisien'(newVal){
        this.form.bulldozer.pre_fuel_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.bulldozer.air_cleaner_inner.koefisien'(newVal){
        this.form.bulldozer.air_cleaner_inner.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.bulldozer.air_cleaner_outer.koefisien'(newVal){
        this.form.bulldozer.air_cleaner_outer.koefisien = formatRupiah(newVal,"Rp ")
      },

      'form.compactor.bahan_bakar.harga_satuan'(newVal){
        this.form.compactor.bahan_bakar.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.oil_engine.harga_satuan'(newVal){
        this.form.compactor.oil_engine.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.oil_hidrolik.harga_satuan'(newVal){
        this.form.compactor.oil_hidrolik.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.fuel_filter_element.koefisien'(newVal){
        this.form.compactor.fuel_filter_element.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.grase.harga_bulanan'(newVal){
        this.form.compactor.grase.harga_bulanan = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.gaji_operator.harga_bulanan'(newVal){
        this.form.compactor.gaji_operator.harga_bulanan = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.engine_oil_filter.koefisien'(newVal){
        this.form.compactor.engine_oil_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.fuel_water_separator.koefisien'(newVal){
        this.form.compactor.fuel_water_separator.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.fuel_filter.koefisien'(newVal){
        this.form.compactor.fuel_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.hydraulic_filter.koefisien'(newVal){
        this.form.compactor.hydraulic_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.air_cleaner_inner.koefisien'(newVal){
        this.form.compactor.air_cleaner_inner.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.compactor.air_cleaner_outer.koefisien'(newVal){
        this.form.compactor.air_cleaner_outer.koefisien = formatRupiah(newVal,"Rp ")
      },


      'form.dump.bahan_bakar.harga_satuan'(newVal){
        this.form.dump.bahan_bakar.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.dump.oil_engine.harga_satuan'(newVal){
        this.form.dump.oil_engine.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.dump.oil_hidrolik.harga_satuan'(newVal){
        this.form.dump.oil_hidrolik.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.dump.fuel_filter.koefisien'(newVal){
        this.form.dump.fuel_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.dump.grase.harga_bulanan'(newVal){
        this.form.dump.grase.harga_bulanan = formatRupiah(newVal,"Rp ")
      },
      'form.dump.gaji_operator.harga_bulanan'(newVal){
        this.form.dump.gaji_operator.harga_bulanan = formatRupiah(newVal,"Rp ")
      },
      'form.dump.oil_transmisi.koefisien'(newVal){
        this.form.dump.oil_transmisi.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.dump.oil_power_dteering.koefisien'(newVal){
        this.form.dump.oil_power_dteering.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.dump.engine_oil_filter.koefisien'(newVal){
        this.form.dump.engine_oil_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.dump.pre_fuel_filter.koefisien'(newVal){
        this.form.dump.pre_fuel_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.dump.tire_cost.koefisien'(newVal){
        this.form.dump.tire_cost.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.dump.air_cleaner_inner.koefisien'(newVal){
        this.form.dump.air_cleaner_inner.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.dump.air_cleaner_outer.koefisien'(newVal){
        this.form.dump.air_cleaner_outer.koefisien = formatRupiah(newVal,"Rp ")
      },

      'form.hydraulic.bahan_bakar.harga_satuan'(newVal){
        this.form.hydraulic.bahan_bakar.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.oil_engine.harga_satuan'(newVal){
        this.form.hydraulic.oil_engine.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.oil_hidrolik.harga_satuan'(newVal){
        this.form.hydraulic.oil_hidrolik.harga_satuan = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.fuel_filter_element.koefisien'(newVal){
        this.form.hydraulic.fuel_filter_element.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.grase.harga_bulanan'(newVal){
        this.form.hydraulic.grase.harga_bulanan = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.gaji_operator.harga_bulanan'(newVal){
        this.form.hydraulic.gaji_operator.harga_bulanan = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.engine_oil_filter.koefisien'(newVal){
        this.form.hydraulic.engine_oil_filter.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.final_drive_oil.koefisien'(newVal){
        this.form.hydraulic.final_drive_oil.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.air_cleaner_inner.koefisien'(newVal){
        this.form.hydraulic.air_cleaner_inner.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.air_cleaner_outer.koefisien'(newVal){
        this.form.hydraulic.air_cleaner_outer.koefisien = formatRupiah(newVal,"Rp ")
      },
      'form.hydraulic.fuel_main_filter.harga_bulanan'(newVal){
        this.form.hydraulic.fuel_main_filter.harga_bulanan = formatRupiah(newVal,"Rp ")
      },
      
    },
    methods: {
      createModal(){
        this.editMode = false;
        this.allJenisAlat=[];
        this.allTipeAlat=[];
        this.form.reset();
        this.form.clear();
        $('#modal').modal('show');
      },
      editModal(data){
        this.editMode = true;
        let detailData = JSON.parse(data.parameter_biaya_operasional) 
        this.form.id = data.id
        if(data.nama_jenis_alat === "Hydraulic Excavator"){
          this.hydraulicMode = true
          this.form.hydraulic.bahan_bakar.harga_satuan = detailData.hargaSatuanBahanBakar
          this.form.hydraulic.bahan_bakar.interval = detailData.intervalBahanBakar
          this.form.hydraulic.bahan_bakar.daya_mesin = detailData.dayaMesinBahanBakar
         
          this.form.hydraulic.oil_engine.harga_satuan = detailData.hargaSatuanOilEngine
          this.form.hydraulic.oil_engine.liter_pemakaian = detailData.literPemakaianOilEngine
          this.form.hydraulic.oil_engine.faktor_efisien = detailData.faktorEfisienOilEngine
          this.form.hydraulic.oil_engine.interval = detailData.intervalOilEngine
         
          this.form.hydraulic.oil_hidrolik.harga_satuan = detailData.hargaSatuanOilHidrolik
          this.form.hydraulic.oil_hidrolik.liter_pemakaian = detailData.literPemakaianOilHidrolik
          this.form.hydraulic.oil_hidrolik.interval = detailData.intervalOilHidrolik
          this.form.hydraulic.oil_hidrolik.daya_mesin = detailData.dayaMesinOilHidrolilk
          
          this.form.hydraulic.engine_oil_filter.koefisien = detailData.koefisienEngineOilFlter
          this.form.hydraulic.engine_oil_filter.interval = detailData.intervalEngineOilFilter
          this.form.hydraulic.fuel_filter_element.koefisien = detailData.koefisienFuelFilter
          this.form.hydraulic.fuel_filter_element.interval = detailData.intervalFuelFilter
          this.form.hydraulic.final_drive_oil.koefisien = detailData.koefisienFinalDriveOil
          this.form.hydraulic.final_drive_oil.interval = detailData.intervalFinalDriveOil
          this.form.hydraulic.air_cleaner_inner.koefisien = detailData.koefisienAirCleanerInner 
          this.form.hydraulic.air_cleaner_inner.interval = detailData.intervalAirCleanerInner
          this.form.hydraulic.air_cleaner_outer.koefisien = detailData.koefisienAirCleanerOuter
          this.form.hydraulic.air_cleaner_outer.interval = detailData.intervalAirCleanerOuter
          
          this.form.hydraulic.fuel_main_filter.harga_bulanan = detailData.hargaBulananFuelMainFilter
          this.form.hydraulic.fuel_main_filter.interval = detailData.intervalFuelMainFilter
          
          this.form.hydraulic.grase.harga_bulanan = detailData.hargaBulananGrase
          this.form.hydraulic.grase.interval = detailData.intervalGrase
          
          this.form.hydraulic.gaji_operator.harga_bulanan = detailData.hargaBulananGajiOperator
          this.form.hydraulic.gaji_operator.interval = detailData.intervalGajiOperator
          this.form.clear();
        }else if(data.nama_jenis_alat === "Dump Truck"){
          this.dumpMode = true
          this.form.dump.bahan_bakar.harga_satuan = detailData.hargaSatuanBahanBakar
          this.form.dump.bahan_bakar.interval = detailData.intervalBahanBakar
          this.form.dump.bahan_bakar.daya_mesin = detailData.dayaMesinBahanBakar
         
          this.form.dump.oil_engine.harga_satuan = detailData.hargaSatuanOilEngine
          this.form.dump.oil_engine.liter_pemakaian = detailData.literPemakaianOilEngine
          this.form.dump.oil_engine.faktor_efisien = detailData.faktorEfisienOilEngine
          this.form.dump.oil_engine.interval = detailData.intervalOilEngine
         
          this.form.dump.oil_hidrolik.harga_satuan = detailData.hargaSatuanOilHidrolik
          this.form.dump.oil_hidrolik.liter_pemakaian = detailData.literPemakaianOilHidrolik
          this.form.dump.oil_hidrolik.interval = detailData.intervalOilHidrolik
          this.form.dump.oil_hidrolik.daya_mesin = detailData.dayaMesinOilHidrolilk
          
          this.form.dump.oil_transmisi.koefisien = detailData.koefisienOilTransmisi
          this.form.dump.oil_transmisi.interval = detailData.intervalOilTransmisi
          this.form.dump.oil_power_dteering.koefisien = detailData.intervalOilPowerDteering
          this.form.dump.oil_power_dteering.interval = detailData.intervalOilTransmisi
          this.form.dump.engine_oil_filter.koefisien = detailData.koefisienEngineOilFlter
          this.form.dump.engine_oil_filter.interval = detailData.intervalEngineOilFilter
          this.form.dump.pre_fuel_filter.koefisien = detailData.koefisienPreFuelFilter
          this.form.dump.pre_fuel_filter.interval = detailData.intervalPreFuelFilter
          this.form.dump.fuel_filter.koefisien = detailData.koefisienFuelFilter
          this.form.dump.fuel_filter.interval = detailData.intervalFuelFilter
          this.form.dump.air_cleaner_inner.koefisien = detailData.koefisienAirCleanerInner 
          this.form.dump.air_cleaner_inner.interval = detailData.intervalAirCleanerInner
          this.form.dump.air_cleaner_outer.koefisien = detailData.koefisienAirCleanerOuter
          this.form.dump.air_cleaner_outer.interval = detailData.intervalAirCleanerOuter
          
          this.form.dump.tire_cost.koefisien = detailData.koefisienTireCost
          this.form.dump.tire_cost.interval = detailData.intervalTireCost

          this.form.dump.grase.harga_bulanan = detailData.hargaBulananGrase
          this.form.dump.grase.interval = detailData.intervalGrase
          
          this.form.dump.gaji_operator.harga_bulanan = detailData.hargaBulananGajiOperator
          this.form.dump.gaji_operator.interval = detailData.intervalGajiOperator
        }else if(data.nama_jenis_alat === "Bulldozer"){
          this.bulldozerMode = true
          this.form.bulldozer.bahan_bakar.harga_satuan = detailData.hargaSatuanBahanBakar
          this.form.bulldozer.bahan_bakar.interval = detailData.intervalBahanBakar
          this.form.bulldozer.bahan_bakar.daya_mesin = detailData.dayaMesinBahanBakar
         
          this.form.bulldozer.oil_engine.harga_satuan = detailData.hargaSatuanOilEngine
          this.form.bulldozer.oil_engine.liter_pemakaian = detailData.literPemakaianOilEngine
          this.form.bulldozer.oil_engine.faktor_efisien = detailData.faktorEfisienOilEngine
          this.form.bulldozer.oil_engine.interval = detailData.intervalOilEngine
         
          this.form.bulldozer.oil_hidrolik.harga_satuan = detailData.hargaSatuanOilHidrolik
          this.form.bulldozer.oil_hidrolik.liter_pemakaian = detailData.literPemakaianOilHidrolik
          this.form.bulldozer.oil_hidrolik.interval = detailData.intervalOilHidrolik
          this.form.bulldozer.oil_hidrolik.daya_mesin = detailData.dayaMesinOilHidrolilk
          
          this.form.bulldozer.engine_oil_filter.koefisien = detailData.koefisienEngineOilFlter
          this.form.bulldozer.engine_oil_filter.interval = detailData.intervalEngineOilFilter
          this.form.bulldozer.pre_fuel_filter.koefisien = detailData.koefisienPreFuelFilter
          this.form.bulldozer.pre_fuel_filter.interval = detailData.intervalPreFuelFilter
          this.form.bulldozer.fuel_filter.koefisien = detailData.koefisienFuelFilter
          this.form.bulldozer.fuel_filter.interval = detailData.intervalFuelFilter
          this.form.bulldozer.air_cleaner_inner.koefisien = detailData.koefisienAirCleanerInner 
          this.form.bulldozer.air_cleaner_inner.interval = detailData.intervalAirCleanerInner
          this.form.bulldozer.air_cleaner_outer.koefisien = detailData.koefisienAirCleanerOuter
          this.form.bulldozer.air_cleaner_outer.interval = detailData.intervalAirCleanerOuter
        
          this.form.bulldozer.grase.harga_bulanan = detailData.hargaBulananGrase
          this.form.bulldozer.grase.interval = detailData.intervalGrase
          
          this.form.bulldozer.gaji_operator.harga_bulanan = detailData.hargaBulananGajiOperator
          this.form.bulldozer.gaji_operator.interval = detailData.intervalGajiOperator
        }else{
          this.compactorMode = true
          this.form.compactor.bahan_bakar.harga_satuan = detailData.hargaSatuanBahanBakar
          this.form.compactor.bahan_bakar.interval = detailData.intervalBahanBakar
          this.form.compactor.bahan_bakar.daya_mesin = detailData.dayaMesinBahanBakar
         
          this.form.compactor.oil_engine.harga_satuan = detailData.hargaSatuanOilEngine
          this.form.compactor.oil_engine.liter_pemakaian = detailData.literPemakaianOilEngine
          this.form.compactor.oil_engine.faktor_efisien = detailData.faktorEfisienOilEngine
          this.form.compactor.oil_engine.interval = detailData.intervalOilEngine
         
          this.form.compactor.oil_hidrolik.harga_satuan = detailData.hargaSatuanOilHidrolik
          this.form.compactor.oil_hidrolik.liter_pemakaian = detailData.literPemakaianOilHidrolik
          this.form.compactor.oil_hidrolik.interval = detailData.intervalOilHidrolik
          this.form.compactor.oil_hidrolik.daya_mesin = detailData.dayaMesinOilHidrolilk
          
          this.form.compactor.engine_oil_filter.koefisien = detailData.koefisienEngineOilFlter
          this.form.compactor.engine_oil_filter.interval = detailData.intervalEngineOilFilter
          this.form.compactor.fuel_filter_element.koefisien = detailData.koefisienFuelFilterElement
          this.form.compactor.fuel_filter_element.interval = detailData.intervalFuelFilterElement
          this.form.compactor.fuel_water_separator.koefisien = detailData.koefisienFuelWaterSeparator
          this.form.compactor.fuel_water_separator.interval = detailData.intervalFuelWaterSeparator
          this.form.compactor.fuel_filter.koefisien = detailData.koefisienFuelFilter
          this.form.compactor.fuel_filter.interval = detailData.intervalFuelFilter
          this.form.compactor.hydraulic_filter.koefisien = detailData.koefisienHydraulicFilter
          this.form.compactor.hydraulic_filter.interval = detailData.intervalHydraulicFilter
          this.form.compactor.air_cleaner_inner.koefisien = detailData.koefisienAirCleanerInner 
          this.form.compactor.air_cleaner_inner.interval = detailData.intervalAirCleanerInner
          this.form.compactor.air_cleaner_outer.koefisien = detailData.koefisienAirCleanerOuter
          this.form.compactor.air_cleaner_outer.interval = detailData.intervalAirCleanerOuter
        
          this.form.compactor.grase.harga_bulanan = detailData.hargaBulananGrase
          this.form.compactor.grase.interval = detailData.intervalGrase
          
          this.form.compactor.gaji_operator.harga_bulanan = detailData.hargaBulananGajiOperator
          this.form.compactor.gaji_operator.interval = detailData.intervalGajiOperator
        }
        $('#modal').modal('show');
      },
      storeData(){
        this.form.post("{{ route('biayaOperasional.store') }}")
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
              'Berhasil',
              'Data biaya operasional berhasil ditambahkan',
              'success'
          )

          this.emptyFilter()
          this.refreshData()
        })
        .catch(e => {
            e.response.status != 422 ? console.log(e) : '';
        })
      },
      updateData(){
        url = "{{ route('biayaOperasional.update', ':id') }}".replace(':id', this.form.id)
        this.form.put(url)
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
            'Berhasil',
            'Data biaya operasional berhasil diubah',
            'success'
          )
          this.refreshData()
        })
        .catch(e => {
            e.response.status != 422 ? console.log(e) : '';
        })
      },
      deleteData(id){
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Anda tidak dapat mengembalikan ini",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.value) {
            url = "{{ route('biayaOperasional.destroy', ':id') }}".replace(':id', id)
            this.form.delete(url)
            .then(response => {
              Swal.fire(
                'Terhapus',
                'Biaya operasional alat telah dihapus',
                'success'
              )
              this.refreshData()
            })
            .catch(e => {
                e.response.status != 422 ? console.log(e) : '';
            })
          }
      })
      },
      refreshData() {
        axios.get("{{ route('biayaOperasional.list') }}")
        .then(response => {
          if (response.data.length !== 0){
            let array = []
            for(let data of response.data){
              let params = JSON.parse(data.parameter_biaya_operasional)
              let paramsKebutuhanAlat = JSON.parse(data.parameter_kebutuhan_alat)
              let parameterInterval = ""
              let parameterKoefisien = ""
              let hasil = ""
              if(data.nama_jenis_alat === "Hydraulic Excavator"){
                parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik 
                parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                parameterInterval += "<br/> " + "Fuel Filter Element :" + params.intervalFuelFilter  
                parameterInterval += "<br/> " + "Final Drive Oil:" + params.intervalFinalDriveOil 
                parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                parameterInterval += "<br/> " + "Fuel Main Filter:" + params.intervalFuelMainFilter 
                parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                data.interval = parameterInterval 

                parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik
                parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                parameterKoefisien += "<br/> " + "Fuel Filter Element :" + params.koefisienFuelFilter  
                parameterKoefisien += "<br/> " + "Final Drive Oil:" + params.koefisienFinalDriveOil 
                parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                parameterKoefisien += "<br/> " + "Fuel Main Filter:" + params.koefisienFuelMainFilter 
                parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                data.koefisien = parameterKoefisien 

                const format = data.hasil.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                let uangHarian = data.hasil * 8;
                const formatHarian = uangHarian.toString().split('').reverse().join('');
                const convertHarian = formatHarian.match(/\d{1,3}/g);
                const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                let uangBulanan = uangHarian * 58;
                const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                hasil += "Total biaya operasi per Jam :" + rupiah  
                hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                data.hasil = hasil
              }else if(data.nama_jenis_alat === "Dump Truck"){
                parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik  
                parameterInterval += "<br/> " + "Oil Transmisi :" + params.intervalOilTransmisi  
                parameterInterval += "<br/> " + "Oil Power Dteering :" + params.intervalOilPowerDteering  
                parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                parameterInterval += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                parameterInterval += "<br/> " + "Fuel Filter :" + params.intervalFuelFilter  
                parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                parameterInterval += "<br/> " + "Tire Cost:" + params.intervalTireCost
                parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                data.interval = parameterInterval 

                parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik  
                parameterKoefisien += "<br/> " + "Oil Transmisi :" + params.koefisienOilTransmisi  
                parameterKoefisien += "<br/> " + "Oil Power Dteering :" + params.koefisienOilPowerDteering  
                parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                parameterKoefisien += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                parameterKoefisien += "<br/> " + "Fuel Filter :" + params.koefisienFuelFilter  
                parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                parameterKoefisien += "<br/> " + "Tire Cost:" + params.koefisienTireCost 
                parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                data.koefisien = parameterKoefisien 

                const format = data.hasil.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                let uangHarian = data.hasil * 8;
                const formatHarian = uangHarian.toString().split('').reverse().join('');
                const convertHarian = formatHarian.match(/\d{1,3}/g);
                const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                let uangBulanan = uangHarian * 58;
                const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                hasil += "Total biaya operasi per Jam :" + rupiah  
                hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                data.hasil = hasil
              }else if(data.nama_jenis_alat === "Bulldozer"){
                parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik  
                parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                parameterInterval += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                parameterInterval += "<br/> " + "Fuel Filter :" + params.intervalFuelFilter  
                parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                data.interval = parameterInterval 

                parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik  
                parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                parameterKoefisien += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                parameterKoefisien += "<br/> " + "Fuel Filter :" + params.koefisienFuelFilter  
                parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                data.koefisien = parameterKoefisien 

                const format = data.hasil.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                let uangHarian = data.hasil * 8;
                const formatHarian = uangHarian.toString().split('').reverse().join('');
                const convertHarian = formatHarian.match(/\d{1,3}/g);
                const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                let uangBulanan = uangHarian * 58;
                const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                hasil += "Total biaya operasi per Jam :" + rupiah  
                hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                data.hasil = hasil
              }else{
                parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik  
                parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                parameterInterval += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                parameterInterval += "<br/> " + "Fuel Filter Element :" + params.intervalFuelFilterElement  
                parameterInterval += "<br/> " + "Fuel Water Separator :" + params.intervalFuelWaterSeparator  
                parameterInterval += "<br/> " + "Fuel Filter :" + params.intervalFuelFilter  
                parameterInterval += "<br/> " + "Hydraulic Filter :" + params.intervalHydraulicFilter  
                parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                data.interval = parameterInterval 

                parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik  
                parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                parameterKoefisien += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                parameterKoefisien += "<br/> " + "Fuel Filter Element :" + params.koefisienFuelFilterElement  
                parameterKoefisien += "<br/> " + "Fuel Water Separator :" + params.koefisienFuelWaterSeparator  
                parameterKoefisien += "<br/> " + "Fuel Filter :" + params.koefisienFuelFilter  
                parameterKoefisien += "<br/> " + "Hydraulic Filter :" + params.koefisienHydraulicFilter 
                parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                data.koefisien = parameterKoefisien 

                const format = data.hasil.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                let uangHarian = data.hasil * 8;
                const formatHarian = uangHarian.toString().split('').reverse().join('');
                const convertHarian = formatHarian.match(/\d{1,3}/g);
                const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                let uangBulanan = uangHarian * 58;
                const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                hasil += "Total biaya operasi per Jam :" + rupiah  
                hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                data.hasil = hasil
              }
              array.push(data) 
            }
            this.mainData = array
          }else{
            this.mainData = []
          }
          $('#table').DataTable().destroy()
          this.$nextTick(function () {
              $('#table').DataTable();
          })
        })
        .catch(e => {
          console.log('err',e)
          e.response.status != 422 ? console.log(e) : '';
        })
      },
      inputSelect() {
        this.form.id_proyek =  $("#id_proyek").val()
      },
      inputSelectJenisAlat(){
        this.form.id_jenis_alat =  $("#id_jenis_alat").val()
      },
      inputSelectTipeAlat(){
        this.form.id_tipe_alat =  $("#id_tipe_alat").val()
      },
      filterData(){
        if (this.form.id_tipe_alat !== "" && this.form.id_jenis_alat === ""){
          url = "{{ route('biayaOperasional.filter', ':id') }}".replace(':id', this.form.id_tipe_alat)
          this.form.get(url)
          .then(response => {
            if (response.data.length !== 0){
              let array = []
              for(let data of response.data){
                let params = JSON.parse(data.parameter_biaya_operasional)
                let paramsKebutuhanAlat = JSON.parse(data.parameter_kebutuhan_alat)
                let parameterInterval = ""
                let parameterKoefisien = ""
                let hasil = ""
                if(data.nama_jenis_alat === "Hydraulic Excavator"){
                  parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                  parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                  parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik 
                  parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                  parameterInterval += "<br/> " + "Fuel Filter Element :" + params.intervalFuelFilter  
                  parameterInterval += "<br/> " + "Final Drive Oil:" + params.intervalFinalDriveOil 
                  parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                  parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                  parameterInterval += "<br/> " + "Fuel Main Filter:" + params.intervalFuelMainFilter 
                  parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                  parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                  data.interval = parameterInterval 

                  parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                  parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                  parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik
                  parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                  parameterKoefisien += "<br/> " + "Fuel Filter Element :" + params.koefisienFuelFilter  
                  parameterKoefisien += "<br/> " + "Final Drive Oil:" + params.koefisienFinalDriveOil 
                  parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                  parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                  parameterKoefisien += "<br/> " + "Fuel Main Filter:" + params.koefisienFuelMainFilter 
                  parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                  parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                  data.koefisien = parameterKoefisien 

                  const format = data.hasil.toString().split('').reverse().join('');
                  const convert = format.match(/\d{1,3}/g);
                  const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                  let uangHarian = data.hasil * 8;
                  const formatHarian = uangHarian.toString().split('').reverse().join('');
                  const convertHarian = formatHarian.match(/\d{1,3}/g);
                  const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                  let uangBulanan = uangHarian * 58;
                  const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                  const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                  const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                  let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                  const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                  const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                  const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                  hasil += "Total biaya operasi per Jam :" + rupiah  
                  hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                  hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                  hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                  data.hasil = hasil
                }else if(data.nama_jenis_alat === "Dump Truck"){
                  parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                  parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                  parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik  
                  parameterInterval += "<br/> " + "Oil Transmisi :" + params.intervalOilTransmisi  
                  parameterInterval += "<br/> " + "Oil Power Dteering :" + params.intervalOilPowerDteering  
                  parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                  parameterInterval += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterInterval += "<br/> " + "Fuel Filter :" + params.intervalFuelFilter  
                  parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                  parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                  parameterInterval += "<br/> " + "Tire Cost:" + params.intervalTireCost
                  parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                  parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                  data.interval = parameterInterval 

                  parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                  parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                  parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik  
                  parameterKoefisien += "<br/> " + "Oil Transmisi :" + params.koefisienOilTransmisi  
                  parameterKoefisien += "<br/> " + "Oil Power Dteering :" + params.koefisienOilPowerDteering  
                  parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                  parameterKoefisien += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterKoefisien += "<br/> " + "Fuel Filter :" + params.koefisienFuelFilter  
                  parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                  parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                  parameterKoefisien += "<br/> " + "Tire Cost:" + params.koefisienTireCost 
                  parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                  parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                  data.koefisien = parameterKoefisien 

                  const format = data.hasil.toString().split('').reverse().join('');
                  const convert = format.match(/\d{1,3}/g);
                  const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                  let uangHarian = data.hasil * 8;
                  const formatHarian = uangHarian.toString().split('').reverse().join('');
                  const convertHarian = formatHarian.match(/\d{1,3}/g);
                  const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                  let uangBulanan = uangHarian * 58;
                  const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                  const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                  const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                  let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                  const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                  const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                  const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                  hasil += "Total biaya operasi per Jam :" + rupiah  
                  hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                  hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                  hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                  data.hasil = hasil
                }else if(data.nama_jenis_alat === "Bulldozer"){
                  parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                  parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                  parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik  
                  parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                  parameterInterval += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterInterval += "<br/> " + "Fuel Filter :" + params.intervalFuelFilter  
                  parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                  parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                  parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                  parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                  data.interval = parameterInterval 

                  parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                  parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                  parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik  
                  parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                  parameterKoefisien += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterKoefisien += "<br/> " + "Fuel Filter :" + params.koefisienFuelFilter  
                  parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                  parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                  parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                  parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                  data.koefisien = parameterKoefisien 

                  const format = data.hasil.toString().split('').reverse().join('');
                  const convert = format.match(/\d{1,3}/g);
                  const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                  let uangHarian = data.hasil * 8;
                  const formatHarian = uangHarian.toString().split('').reverse().join('');
                  const convertHarian = formatHarian.match(/\d{1,3}/g);
                  const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                  let uangBulanan = uangHarian * 58;
                  const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                  const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                  const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                  let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                  const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                  const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                  const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                  hasil += "Total biaya operasi per Jam :" + rupiah  
                  hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                  hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                  hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                  data.hasil = hasil
                }else{
                  parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                  parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                  parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik  
                  parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                  parameterInterval += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterInterval += "<br/> " + "Fuel Filter Element :" + params.intervalFuelFilterElement  
                  parameterInterval += "<br/> " + "Fuel Water Separator :" + params.intervalFuelWaterSeparator  
                  parameterInterval += "<br/> " + "Fuel Filter :" + params.intervalFuelFilter  
                  parameterInterval += "<br/> " + "Hydraulic Filter :" + params.intervalHydraulicFilter  
                  parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                  parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                  parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                  parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                  data.interval = parameterInterval 

                  parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                  parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                  parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik  
                  parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                  parameterKoefisien += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterKoefisien += "<br/> " + "Fuel Filter Element :" + params.koefisienFuelFilterElement  
                  parameterKoefisien += "<br/> " + "Fuel Water Separator :" + params.koefisienFuelWaterSeparator  
                  parameterKoefisien += "<br/> " + "Fuel Filter :" + params.koefisienFuelFilter  
                  parameterKoefisien += "<br/> " + "Hydraulic Filter :" + params.koefisienHydraulicFilter 
                  parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                  parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                  parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                  parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                  data.koefisien = parameterKoefisien 

                  const format = data.hasil.toString().split('').reverse().join('');
                  const convert = format.match(/\d{1,3}/g);
                  const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                  let uangHarian = data.hasil * 8;
                  const formatHarian = uangHarian.toString().split('').reverse().join('');
                  const convertHarian = formatHarian.match(/\d{1,3}/g);
                  const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                  let uangBulanan = uangHarian * 58;
                  const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                  const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                  const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                  let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                  const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                  const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                  const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                  hasil += "Total biaya operasi per Jam :" + rupiah  
                  hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                  hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                  hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                  data.hasil = hasil
                }
                array.push(data) 
              }
              this.mainData = array
            }else{
              this.mainData = []
            }
            $('#table').DataTable().destroy()
            this.$nextTick(function () {
                $('#table').DataTable();
            })
          })
          .catch(e => {
              e.response.status != 422 ? console.log(e) : '';
          })
        }else{
          url = "{{ route('biayaOperasionalbyJenisAlat.filter', ':id') }}".replace(':id', this.form.id_jenis_alat)
          this.form.get(url)
          .then(response => {
            if (response.data.length !== 0){
              let array = []
              for(let data of response.data){
                let params = JSON.parse(data.parameter_biaya_operasional)
                let paramsKebutuhanAlat = JSON.parse(data.parameter_kebutuhan_alat)
                let parameterInterval = ""
                let parameterKoefisien = ""
                let hasil = ""
                if(data.nama_jenis_alat === "Hydraulic Excavator"){
                  parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                  parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                  parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik 
                  parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                  parameterInterval += "<br/> " + "Fuel Filter Element :" + params.intervalFuelFilter  
                  parameterInterval += "<br/> " + "Final Drive Oil:" + params.intervalFinalDriveOil 
                  parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                  parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                  parameterInterval += "<br/> " + "Fuel Main Filter:" + params.intervalFuelMainFilter 
                  parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                  parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                  data.interval = parameterInterval 

                  parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                  parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                  parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik
                  parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                  parameterKoefisien += "<br/> " + "Fuel Filter Element :" + params.koefisienFuelFilter  
                  parameterKoefisien += "<br/> " + "Final Drive Oil:" + params.koefisienFinalDriveOil 
                  parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                  parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                  parameterKoefisien += "<br/> " + "Fuel Main Filter:" + params.koefisienFuelMainFilter 
                  parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                  parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                  data.koefisien = parameterKoefisien 

                  const format = data.hasil.toString().split('').reverse().join('');
                  const convert = format.match(/\d{1,3}/g);
                  const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                  let uangHarian = data.hasil * 8;
                  const formatHarian = uangHarian.toString().split('').reverse().join('');
                  const convertHarian = formatHarian.match(/\d{1,3}/g);
                  const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                  let uangBulanan = uangHarian * 58;
                  const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                  const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                  const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                  let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                  const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                  const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                  const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                  hasil += "Total biaya operasi per Jam :" + rupiah  
                  hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                  hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                  hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                  data.hasil = hasil
                }else if(data.nama_jenis_alat === "Dump Truck"){
                  parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                  parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                  parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik  
                  parameterInterval += "<br/> " + "Oil Transmisi :" + params.intervalOilTransmisi  
                  parameterInterval += "<br/> " + "Oil Power Dteering :" + params.intervalOilPowerDteering  
                  parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                  parameterInterval += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterInterval += "<br/> " + "Fuel Filter :" + params.intervalFuelFilter  
                  parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                  parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                  parameterInterval += "<br/> " + "Tire Cost:" + params.intervalTireCost
                  parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                  parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                  data.interval = parameterInterval 

                  parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                  parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                  parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik  
                  parameterKoefisien += "<br/> " + "Oil Transmisi :" + params.koefisienOilTransmisi  
                  parameterKoefisien += "<br/> " + "Oil Power Dteering :" + params.koefisienOilPowerDteering  
                  parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                  parameterKoefisien += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterKoefisien += "<br/> " + "Fuel Filter :" + params.koefisienFuelFilter  
                  parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                  parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                  parameterKoefisien += "<br/> " + "Tire Cost:" + params.koefisienTireCost 
                  parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                  parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                  data.koefisien = parameterKoefisien 

                  const format = data.hasil.toString().split('').reverse().join('');
                  const convert = format.match(/\d{1,3}/g);
                  const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                  let uangHarian = data.hasil * 8;
                  const formatHarian = uangHarian.toString().split('').reverse().join('');
                  const convertHarian = formatHarian.match(/\d{1,3}/g);
                  const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                  let uangBulanan = uangHarian * 58;
                  const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                  const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                  const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                  let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                  const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                  const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                  const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                  hasil += "Total biaya operasi per Jam :" + rupiah  
                  hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                  hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                  hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                  data.hasil = hasil
                }else if(data.nama_jenis_alat === "Bulldozer"){
                  parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                  parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                  parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik  
                  parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                  parameterInterval += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterInterval += "<br/> " + "Fuel Filter :" + params.intervalFuelFilter  
                  parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                  parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                  parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                  parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                  data.interval = parameterInterval 

                  parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                  parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                  parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik  
                  parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                  parameterKoefisien += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterKoefisien += "<br/> " + "Fuel Filter :" + params.koefisienFuelFilter  
                  parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                  parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                  parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                  parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                  data.koefisien = parameterKoefisien 

                  const format = data.hasil.toString().split('').reverse().join('');
                  const convert = format.match(/\d{1,3}/g);
                  const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                  let uangHarian = data.hasil * 8;
                  const formatHarian = uangHarian.toString().split('').reverse().join('');
                  const convertHarian = formatHarian.match(/\d{1,3}/g);
                  const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                  let uangBulanan = uangHarian * 58;
                  const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                  const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                  const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                  let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                  const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                  const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                  const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                  hasil += "Total biaya operasi per Jam :" + rupiah  
                  hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                  hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                  hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                  data.hasil = hasil
                }else{
                  parameterInterval += "Bahan bakar :" + params.intervalBahanBakar 
                  parameterInterval += "<br/> " + "Oil Engine :" + params.intervalOilEngine  
                  parameterInterval += "<br/> " + "Oil Hidrolik :" + params.intervalOilHidrolik  
                  parameterInterval += "<br/> " + "Engine Oil Filter :" + params.intervalEngineOilFilter  
                  parameterInterval += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterInterval += "<br/> " + "Fuel Filter Element :" + params.intervalFuelFilterElement  
                  parameterInterval += "<br/> " + "Fuel Water Separator :" + params.intervalFuelWaterSeparator  
                  parameterInterval += "<br/> " + "Fuel Filter :" + params.intervalFuelFilter  
                  parameterInterval += "<br/> " + "Hydraulic Filter :" + params.intervalHydraulicFilter  
                  parameterInterval += "<br/> " + "Air Cleaner Inner:" + params.intervalAirCleanerInner
                  parameterInterval += "<br/> " + "Air Cleaner Outer:" + params.intervalAirCleanerOuter
                  parameterInterval += "<br/> " + "Grease:" + params.intervalGrase
                  parameterInterval += "<br/> " + "Operator:" + params.intervalGajiOperator
                  data.interval = parameterInterval 

                  parameterKoefisien += "Bahan bakar :" + params.koefisienBahanBakar 
                  parameterKoefisien += "<br/> " + "Oil Engine :" + params.koefisienOilEngine  
                  parameterKoefisien += "<br/> " + "Oil Hidrolik :" + params.koefisienOilHidrolik  
                  parameterKoefisien += "<br/> " + "Engine Oil Filter :" + params.koefisienEngineOilFlter  
                  parameterKoefisien += "<br/> " + "Pre Fuel Filter :" + params.koefisienPreFuelFilter  
                  parameterKoefisien += "<br/> " + "Fuel Filter Element :" + params.koefisienFuelFilterElement  
                  parameterKoefisien += "<br/> " + "Fuel Water Separator :" + params.koefisienFuelWaterSeparator  
                  parameterKoefisien += "<br/> " + "Fuel Filter :" + params.koefisienFuelFilter  
                  parameterKoefisien += "<br/> " + "Hydraulic Filter :" + params.koefisienHydraulicFilter 
                  parameterKoefisien += "<br/> " + "Air Cleaner Inner:" + params.koefisienAirCleanerInner
                  parameterKoefisien += "<br/> " + "Air Cleaner Outer:" + params.koefisienAirCleanerOuter
                  parameterKoefisien += "<br/> " + "Grease:" + params.koefisienGrase
                  parameterKoefisien += "<br/> " + "Operator:" + params.koefisienGajiOperator
                  data.koefisien = parameterKoefisien 

                  const format = data.hasil.toString().split('').reverse().join('');
                  const convert = format.match(/\d{1,3}/g);
                  const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                  let uangHarian = data.hasil * 8;
                  const formatHarian = uangHarian.toString().split('').reverse().join('');
                  const convertHarian = formatHarian.match(/\d{1,3}/g);
                  const rupiahHarian = 'Rp ' + convertHarian.join('.').split('').reverse().join('')

                  let uangBulanan = uangHarian * 58;
                  const formatBulanan = uangBulanan.toString().split('').reverse().join('');
                  const convertBulanan = formatBulanan.match(/\d{1,3}/g);
                  const rupiahBulanan = 'Rp ' + convertBulanan.join('.').split('').reverse().join('')

                  let uangTotalAlat = uangBulanan * paramsKebutuhanAlat.jumlah_alat;
                  const formatTotalAlat = uangTotalAlat.toString().split('').reverse().join('');
                  const convertTotalAlat = formatTotalAlat.match(/\d{1,3}/g);
                  const rupiahTotalAlat = 'Rp ' + convertTotalAlat.join('.').split('').reverse().join('')

                  hasil += "Total biaya operasi per Jam :" + rupiah  
                  hasil += "<br/> " + "Total biaya operasi per hari :" + rupiahHarian
                  hasil +=  "<br/> " + "Total biaya operasi per 58 hari :" + rupiahBulanan
                  hasil +=  "<br/> " + "Total Biaya operasi x jumlah alat  :" + rupiahTotalAlat
                  data.hasil = hasil
                }
                array.push(data) 
              }
              this.mainData = array
            }else{
              this.mainData = []
            }
            $('#table').DataTable().destroy()
            this.$nextTick(function () {
                $('#table').DataTable();
            })
          })
          .catch(e => {
              e.response.status != 422 ? console.log(e) : '';
          })
        }
      },
      resetData(){
        this.form.id_proyek= '';
        this.form.id_jenis_alat= '';
        this.form.id_tipe_alat= '';
        this.refreshData()
      },
      getJenisAlat(id){
        url = "{{ route('jenisAlat.filter', ':id') }}".replace(':id', id)
        axios.get(url)
        .then(response => {
          this.allJenisAlat = response.data
        })
        .catch(e => {
          e.response.status != 422 ? console.log(e) : '';
        })
      },
      getTipeAlat(id){
        url = "{{ route('tipeAlat.filter', ':id') }}".replace(':id', id)
        axios.get(url)
        .then(response => {
          this.allTipeAlat = response.data
        })
        .catch(e => {
          e.response.status != 422 ? console.log(e) : '';
        })
      },
      emptyFilter(){
        console.log('clear')
        this.form.clear();
        this.form.reset();
        this.hydraulicMode = false;
        this.dumpMode = false;
        this.bulldozerMode = false;
        this.compactorMode = false;
      },
      showFieldModal(name){
        if(name === "Hydraulic Excavator"){
          this.hydraulicMode = true
        }else if(name === "Dump Truck"){
          this.dumpMode = true
        }else if(name === "Bulldozer"){
          this.bulldozerMode = true
        }else{
          this.compactorMode = true
        }
      },
    },
  })
</script>
<script>
  function formatRupiah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split      = number_string.split(','),
      sisa       = split[0].length % 3,
      rupiah     = split[0].substr(0, sisa),
      ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
          
      if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }
      
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }
</script>
@endpush
