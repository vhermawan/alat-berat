@extends('layout.master')
@section('title')
Produktivitas
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
          <h4 class="card-title"> Daftar Produktivitas
            <button type="button" class="btn btn-primary btn-rounded float-right mb-3" @click="createModal()">
            <i class="fas fa-plus-circle"></i> Tambah Produktivitas</button>
          </h4>
          
          <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-wrap">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Tipe Alat</th>
                    <th>Parameter</th>
                    <th>Hasil</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="item, index in mainData" :key="index">
                  <td>@{{ index+1 }}</td>
                  <td>@{{ item.nama_tipe_alat}}</td>
                  <td v-html="item.parameterString"></td>
                  <td v-html="item.produktivitas"></td>
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
  <div class="modal-dialog modal-lg" id="modal">
    <div class="modal-content">
      <div class="modal-header ">
        <h4 class="modal-title" v-show="!editMode" id="myLargeModalLabel">Tambah Produktivitas</h4>
        <h4 class="modal-title" v-show="editMode" id="myLargeModalLabel">Edit</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="keluar"  @click="emptyFilter()">×</button>
      </div>
      <form @submit.prevent="editMode ? updateData() : storeData()" @keydown="form.onKeydown($event)" id="form">
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
                <label class="col-lg-2" for="id_jenis_alat">Jenis Alat</label>
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
            @include('store.produktivitas.form.hydraulic')
            @include('store.produktivitas.form.dump')
            @include('store.produktivitas.form.bulldozer')
            @include('store.produktivitas.form.compactor')
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal" id="batal" @click="emptyFilter()">Batal</button>
            <button v-show="!editMode" type="submit" class="btn btn-primary">Tambah</button>
            <button v-show="editMode" type="submit" class="btn btn-success">Ubah</button>
          </div>
      </form>
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
          waktu_putar: '',
          kecepatan_putar: '',
          conversion_factor : '',
          bucket_fill_factor : '',
          faktor_kedalaman: '',
          faktor_efisiensi_kerja : '',
        },
        dump:{
          kapasitas_dump: '',
          kapasitas_bucket:'',
          bucket_fill_factor : '',
          cycle_time_excavator : '',
          jarak_angkut: '',
          loaded_speed: '',
          empty_speed: '',
          standby_dumping_time:'',
          spot_delay_time:'',
          job_efficiency: '',
        },
        bulldozer:{
          kapasitas_blade : '',
          blade_factor: '',
          jarak_dorong: '',
          fordward_speed: '',
          reverse_speed: '',
          gear_shifting :'',
          grade_factor : '',
          job_efficiency : '',
        },
        compactor:{
          lebar_pemadatan: '',
          lebar_blade: '',
          lebar_overlap: '',
          number_of_trips: '',
          kecepatan_kerja: '',
          job_efficiency: '',
          tebal_lapisan_tanah: '',
        }
      }),
      allProyek : @json($allProyek),
      allJenisAlat: [],
      allTipeAlat : [],
      editMode: false,
      hydraulicMode:false,
      dumpMode:false,
      bulldozerMode:false,
      compactorMode:false,
    },
    mounted() {
      this.refreshData()
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
        let detailData = JSON.parse(data.parameter) 
        if(data.nama_jenis_alat === "Hydraulic Excavator"){
          this.hydraulicMode = true
          this.form.hydraulic.bucket_fill_factor = detailData.bucket_fill_factor
          this.form.hydraulic.waktu_putar = detailData.waktu_putar
          this.form.hydraulic.kecepatan_putar = detailData.kecepatan_putar
          this.form.hydraulic.conversion_factor = detailData.conversion_factor
          this.form.hydraulic.faktor_kedalaman = detailData.faktor_kedalaman
          this.form.hydraulic.faktor_efisiensi_kerja = detailData.faktor_efisiensi_kerja
          this.form.id = data.id
          this.form.id_jenis_alat = [data.id_jenis_alat,data.nama_jenis_alat]
          this.form.id_tipe_alat = data.id_tipe_alat
        }else if(data.nama_jenis_alat === "Dump Truck"){
          this.dumpMode = true
          this.form.dump.kapasitas_dump = detailData.kapasitas_dump
          this.form.dump.bucket_fill_factor = detailData.bucket_fill_factor
          this.form.dump.cycle_time_excavator = detailData.cycle_time_excavator
          this.form.dump.jarak_angkut = detailData.jarak_angkut
          this.form.dump.loaded_speed = detailData.loaded_speed
          this.form.dump.empty_speed = detailData.empty_speed
          this.form.dump.standby_dumping_time = detailData.standby_dumping_time
          this.form.dump.spot_delay_time = detailData.spot_delay_time
          this.form.dump.job_efficiency = detailData.job_efficiency
          this.form.id = data.id
          this.form.id_jenis_alat = [data.id_jenis_alat,data.nama_jenis_alat]
          this.form.id_tipe_alat = data.id_tipe_alat
        }else if(data.nama_jenis_alat === "Bulldozer"){
          this.bulldozerMode = true
          this.form.bulldozer.kapasitas_blade = detailData.kapasitas_blade
          this.form.bulldozer.blade_factor = detailData.blade_factor
          this.form.bulldozer.jarak_dorong = detailData.jarak_dorong
          this.form.bulldozer.fordward_speed = detailData.fordward_speed
          this.form.bulldozer.reverse_speed = detailData.reverse_speed
          this.form.bulldozer.gear_shifting = detailData.gear_shifting
          this.form.bulldozer.grade_factor = detailData.grade_factor
          this.form.bulldozer.job_efficiency = detailData.job_efficiency
          this.form.id = data.id
          this.form.id_jenis_alat = [data.id_jenis_alat,data.nama_jenis_alat]
          this.form.id_tipe_alat = data.id_tipe_alat
        }else{
          this.compactorMode = true
          this.form.compactor.lebar_pemadatan = detailData.lebar_pemadatan
          this.form.compactor.lebar_blade = detailData.lebar_blade
          this.form.compactor.lebar_overlap = detailData.lebar_overlap
          this.form.compactor.number_of_trips = detailData.number_of_trips
          this.form.compactor.kecepatan_kerja = detailData.kecepatan_kerja
          this.form.compactor.job_efficiency = detailData.job_efficiency
          this.form.compactor.tebal_lapisan_tanah = detailData.tebal_lapisan_tanah
          this.form.id = data.id
          this.form.id_jenis_alat = [data.id_jenis_alat,data.nama_jenis_alat]
          this.form.id_tipe_alat = data.id_tipe_alat
        }
        this.form.clear();
        $('#modal').modal('show');
      },
      storeData(){
        this.form.post("{{ route('produktivitas.store') }}")
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
              'Berhasil',
              'Data produktivias berhasil ditambahkan',
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
        url = "{{ route('produktivitas.update', ':id') }}".replace(':id', this.form.id)
        this.form.put(url)
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
            'Berhasil',
            'Data produktivitas berhasil diubah',
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
            url = "{{ route('produktivitas.destroy', ':id') }}".replace(':id', id)
            this.form.delete(url)
            .then(response => {
              console.log('res',response)
              Swal.fire(
                'Terhapus',
                'Data produktivitas telah dihapus',
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
        this.mainData = [];
        axios.get("{{ route('produktivitas.list') }}")
        .then(response => {
          if (response.data.length !== 0){
            let array = []
            for(let data of response.data){
              let params = JSON.parse(data.parameter)
              let parameter = ""
              if(data.nama_jenis_alat === "Hydraulic Excavator"){
                parameter += "Standart cycle time :" + params.standart_cycle_time  + " menit"
                parameter +=  "<br/> " +"Cms :" + params.cms
                parameter +=  "<br/> " +"Kapasitas Bucket :" + params.kapasitas_bucket  + " m<sup>3</sup>"
                parameter +=  "<br/> " +"Bucket Fill Factor :" + params.bucket_fill_factor
                parameter +=  "<br/> " +"Faktor Kedalaman :" + params.faktor_kedalaman
                parameter +=  "<br/> " +"Faktor Efisiensi Kerja :" + params.faktor_efisiensi_kerja
                data.parameterString = parameter
              }else if(data.nama_jenis_alat === "Dump Truck"){
                parameter += "Kapasitas dump :" + params.kapasitas_dump  + " m<sup>3</sup>"
                parameter +=  "<br/> " +"Kapasitas bucket :" + params.kapasitas_bucket + " m<sup>3</sup>"
                parameter +=  "<br/> " +"Bucket fill factor :" + params.bucket_fill_factor  
                parameter +=  "<br/> " +"Jumlah siklus :" + params.jumlah_siklus
                parameter +=  "<br/> " +"Produktivitas per siklus :" + params.produktivitas_per_siklus
                parameter +=  "<br/> " +"Cycle time excavator :" + params.cycle_time_excavator + " menit"
                parameter +=  "<br/> " +"Jarak angkut :" + params.jarak_angkut + " meter"
                parameter +=  "<br/> " +"Loaded speed :" + params.loaded_speed + " m/menit"
                parameter +=  "<br/> " +"Empty speed :" + params.empty_speed + " m/menit"
                parameter +=  "<br/> " +"Standby dumping time :" + params.standby_dumping_time + " menit"
                parameter +=  "<br/> " +"Spot delay time :" + params.spot_delay_time + " menit"
                parameter +=  "<br/> " +"Waktu siklus :" + params.waktu_siklus + " menit"
                parameter +=  "<br/> " +"Jumlah dump truck :" + params.jumlah_dump_truck + " unit"
                parameter +=  "<br/> " +"Job efficiency :" + params.job_efficiency 
                data.parameterString = parameter
              }else if(data.nama_jenis_alat === "Bulldozer"){
                parameter += "Kapasitas blade :" + params.kapasitas_blade  + " m<sup>3</sup>"
                parameter +=  "<br/> " +"Blade factor :" + params.blade_factor 
                parameter +=  "<br/> " +"Jarak dorong :" + params.jarak_dorong  + " meter"
                parameter +=  "<br/> " +"Forward speed :" + params.fordward_speed + " m/menit"
                parameter +=  "<br/> " +"Produktivitas per siklus :" + params.produktivitas_per_siklus + " m<sup>3</sup>"
                parameter +=  "<br/> " +"Reverse speed :" + params.reverse_speed + " m/menit"
                parameter +=  "<br/> " +"Gear shifting :" + params.gear_shifting + " menit"
                parameter +=  "<br/> " +"Grade factor :" + params.grade_factor
                parameter +=  "<br/> " +"Job efficiency :" + params.job_efficiency 
                data.parameterString = parameter
              }else{
                parameter += "Lebar pemadatan :" + params.lebar_pemadatan  + " meter"
                parameter +=  "<br/> " +"Lebar Blade :" + params.lebar_blade + " mm"
                parameter +=  "<br/> " +"Lebar overlap :" + params.lebar_overlap  + " meter"
                parameter +=  "<br/> " +"Number of trips :" + params.number_of_trips 
                parameter +=  "<br/> " +"Kecepatan kerja :" + params.kecepatan_kerja + " m/jam"
                parameter +=  "<br/> " +"Job efficiency :" + params.job_efficiency 
                parameter +=  "<br/> " +"Tebal lapisan tanah :" + params.tebal_lapisan_tanah + " meter"
                data.parameterString = parameter
              }
              data.produktivitas = data.hasil + " m<sup>3</sup>/jam"
              array.push(data)          
            }
            this.mainData = array
          }else{
            this.mainData = [];
          }
        })
        .catch(e => {
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
        if(this.form.id_tipe_alat != "" && this.form.id_jenis_alat == ""){
          url = "{{ route('produktivitasbyTipeAlat.filter', ':id') }}".replace(':id', this.form.id_tipe_alat)
          this.form.get(url)
          .then(response => {
            $('#table').DataTable().destroy()
            if (response.data.length !== 0){
              let array = []
              for(let data of response.data){
                let params = JSON.parse(data.parameter)
                let parameter = ""
                if(data.nama_jenis_alat === "Hydraulic Excavator"){
                  parameter += "Standart cycle time :" + params.standart_cycle_time  + " menit"
                  parameter +=  "<br/> " +"Cms :" + params.cms
                  parameter +=  "<br/> " +"Kapasitas Bucket :" + params.kapasitas_bucket  + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Bucket Fill Factor :" + params.bucket_fill_factor
                  parameter +=  "<br/> " +"Faktor Kedalaman :" + params.faktor_kedalaman
                  parameter +=  "<br/> " +"Faktor Efisiensi Kerja :" + params.faktor_efisiensi_kerja
                  data.parameterString = parameter
                }else if(data.nama_jenis_alat === "Dump Truck"){
                  parameter += "Kapasitas dump :" + params.kapasitas_dump  + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Kapasitas bucket :" + params.kapasitas_bucket + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Bucket fill factor :" + params.bucket_fill_factor  
                  parameter +=  "<br/> " +"Jumlah siklus :" + params.jumlah_siklus
                  parameter +=  "<br/> " +"Produktivitas per siklus :" + params.produktivitas_per_siklus
                  parameter +=  "<br/> " +"Cycle time excavator :" + params.cycle_time_excavator + " menit"
                  parameter +=  "<br/> " +"Jarak angkut :" + params.jarak_angkut + " meter"
                  parameter +=  "<br/> " +"Loaded speed :" + params.loaded_speed + " m/menit"
                  parameter +=  "<br/> " +"Empty speed :" + params.empty_speed + " m/menit"
                  parameter +=  "<br/> " +"Standby dumping time :" + params.standby_dumping_time + " menit"
                  parameter +=  "<br/> " +"Spot delay time :" + params.spot_delay_time + " menit"
                  parameter +=  "<br/> " +"Waktu siklus :" + params.waktu_siklus + " menit"
                  parameter +=  "<br/> " +"Jumlah dump truck :" + params.jumlah_dump_truck + " unit"
                  parameter +=  "<br/> " +"Job efficiency :" + params.job_efficiency 
                  data.parameterString = parameter
                }else if(data.nama_jenis_alat === "Bulldozer"){
                  parameter += "Kapasitas blade :" + params.kapasitas_blade  + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Blade factor :" + params.blade_factor 
                  parameter +=  "<br/> " +"Jarak dorong :" + params.jarak_dorong  + " meter"
                  parameter +=  "<br/> " +"Forward speed :" + params.fordward_speed + " m/menit"
                  parameter +=  "<br/> " +"Produktivitas per siklus :" + params.produktivitas_per_siklus + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Reverse speed :" + params.reverse_speed + " m/menit"
                  parameter +=  "<br/> " +"Gear shifting :" + params.gear_shifting + " menit"
                  parameter +=  "<br/> " +"Grade factor :" + params.grade_factor
                  parameter +=  "<br/> " +"Job efficiency :" + params.job_efficiency 
                  data.parameterString = parameter
                }else{
                  parameter += "Lebar pemadatan :" + params.lebar_pemadatan  + " meter"
                  parameter +=  "<br/> " +"Lebar Blade :" + params.lebar_blade + " mm"
                  parameter +=  "<br/> " +"Lebar overlap :" + params.lebar_overlap  + " meter"
                  parameter +=  "<br/> " +"Number of trips :" + params.number_of_trips 
                  parameter +=  "<br/> " +"Kecepatan kerja :" + params.kecepatan_kerja + " m/jam"
                  parameter +=  "<br/> " +"Job efficiency :" + params.job_efficiency 
                  parameter +=  "<br/> " +"Tebal lapisan tanah :" + params.tebal_lapisan_tanah + " meter"
                  data.parameterString = parameter
                }
                data.produktivitas = data.hasil + " m<sup>3</sup>/jam"
                array.push(data)          
              }
              this.mainData = array
            }else{
              this.mainData = [];
            }
            this.$nextTick(function () {
                $('#table').DataTable();
            })
          })
          .catch(e => {
              e.response.status != 422 ? console.log(e) : '';
          })
        }else{
          url = "{{ route('produktivitas.filter', ':id') }}".replace(':id', this.form.id_jenis_alat)
          this.form.get(url)
          .then(response => {
            $('#table').DataTable().destroy()
            if (response.data.length !== 0){
              let array = []
              for(let data of response.data){
                let params = JSON.parse(data.parameter)
                let parameter = ""
                if(data.nama_jenis_alat === "Hydraulic Excavator"){
                  parameter += "Standart cycle time :" + params.standart_cycle_time  + " menit"
                  parameter +=  "<br/> " +"Cms :" + params.cms
                  parameter +=  "<br/> " +"Kapasitas Bucket :" + params.kapasitas_bucket  + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Bucket Fill Factor :" + params.bucket_fill_factor
                  parameter +=  "<br/> " +"Faktor Kedalaman :" + params.faktor_kedalaman
                  parameter +=  "<br/> " +"Faktor Efisiensi Kerja :" + params.faktor_efisiensi_kerja
                  data.parameterString = parameter
                }else if(data.nama_jenis_alat === "Dump Truck"){
                  parameter += "Kapasitas dump :" + params.kapasitas_dump  + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Kapasitas bucket :" + params.kapasitas_bucket + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Bucket fill factor :" + params.bucket_fill_factor  
                  parameter +=  "<br/> " +"Jumlah siklus :" + params.jumlah_siklus
                  parameter +=  "<br/> " +"Produktivitas per siklus :" + params.produktivitas_per_siklus
                  parameter +=  "<br/> " +"Cycle time excavator :" + params.cycle_time_excavator + " menit"
                  parameter +=  "<br/> " +"Jarak angkut :" + params.jarak_angkut + " meter"
                  parameter +=  "<br/> " +"Loaded speed :" + params.loaded_speed + " m/menit"
                  parameter +=  "<br/> " +"Empty speed :" + params.empty_speed + " m/menit"
                  parameter +=  "<br/> " +"Standby dumping time :" + params.standby_dumping_time + " menit"
                  parameter +=  "<br/> " +"Spot delay time :" + params.spot_delay_time + " menit"
                  parameter +=  "<br/> " +"Waktu siklus :" + params.waktu_siklus + " menit"
                  parameter +=  "<br/> " +"Jumlah dump truck :" + params.jumlah_dump_truck + " unit"
                  parameter +=  "<br/> " +"Job efficiency :" + params.job_efficiency 
                  data.parameterString = parameter
                }else if(data.nama_jenis_alat === "Bulldozer"){
                  parameter += "Kapasitas blade :" + params.kapasitas_blade  + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Blade factor :" + params.blade_factor 
                  parameter +=  "<br/> " +"Jarak dorong :" + params.jarak_dorong  + " meter"
                  parameter +=  "<br/> " +"Forward speed :" + params.fordward_speed + " m/menit"
                  parameter +=  "<br/> " +"Produktivitas per siklus :" + params.produktivitas_per_siklus + " m<sup>3</sup>"
                  parameter +=  "<br/> " +"Reverse speed :" + params.reverse_speed + " m/menit"
                  parameter +=  "<br/> " +"Gear shifting :" + params.gear_shifting + " menit"
                  parameter +=  "<br/> " +"Grade factor :" + params.grade_factor
                  parameter +=  "<br/> " +"Job efficiency :" + params.job_efficiency 
                  data.parameterString = parameter
                }else{
                  parameter += "Lebar pemadatan :" + params.lebar_pemadatan  + " meter"
                  parameter +=  "<br/> " +"Lebar Blade :" + params.lebar_blade + " mm"
                  parameter +=  "<br/> " +"Lebar overlap :" + params.lebar_overlap  + " meter"
                  parameter +=  "<br/> " +"Number of trips :" + params.number_of_trips 
                  parameter +=  "<br/> " +"Kecepatan kerja :" + params.kecepatan_kerja + " m/jam"
                  parameter +=  "<br/> " +"Job efficiency :" + params.job_efficiency 
                  parameter +=  "<br/> " +"Tebal lapisan tanah :" + params.tebal_lapisan_tanah + " meter"
                  data.parameterString = parameter
                }
                data.produktivitas = data.hasil + " m<sup>3</sup>/jam"
                array.push(data)          
              }
              this.mainData = array
            }else{
              this.mainData = [];
            }
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
@endpush
