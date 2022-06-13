@extends('layout.master')
@section('title')
Kebutuhan Alat
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
          <h4 class="card-title"> Daftar Kebutuhan Alat
            <button type="button" class="btn btn-primary btn-rounded float-right mb-3" @click="createModal()">
            <i class="fas fa-plus-circle"></i> Tambah Kebutuhan Alat</button>
          </h4>
          
          <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-wrap">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Tipe Alat</th>
                    <th>Jumlah Alat</th>
                    <th>Parameter</th>
                    <th>Hasil</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="item, index in mainData" :key="index">
                  <td>@{{ index+1 }}</td>
                  <td>@{{ item.nama_tipe_alat}}</td>
                  <td>@{{ item.jumlahAlat}}</td>
                  <td v-html="item.parameterString"></td>
                  <td>@{{ item.sewa_harian}}</td>
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
        <h4 class="modal-title" v-show="!editMode" id="myLargeModalLabel">Tambah Kebutuhan Alat</h4>
        <h4 class="modal-title" v-show="editMode" id="myLargeModalLabel">Edit</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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
            @include('store.kebutuhan_alat.form.hydraulic')
            @include('store.kebutuhan_alat.form.dump')
            @include('store.kebutuhan_alat.form.bulldozer')
            @include('store.kebutuhan_alat.form.compactor')
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
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
  function selectTrigger() {
    if($("#id_proyek").val()!==null){
      app.getJenisAlat($("#id_proyek").val())
    }else {
      app.getJenisAlat($("#id_proyek_modal").val())
    }
    app.inputSelect()
  }

  function selectTriggerVolumePekerjaan(){
    app.inputSelectVolumePekerjaan()
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
      mainData: [
      ],
      form: new Form({
        id: '',
        id_proyek:'',
        id_jenis_alat: '',
        id_tipe_alat: '',
        id_volume_pekerjaan: '',
        dump:{
          jumlah_fleet: '',
          jumlah_dt: '',
        },
      }),
      editMode: false,
      allProyek : @json($allProyek),
      allVolumePekerjaan : @json($allVolumePekerjaan),
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
        this.form.reset();
        this.form.clear();
        $('#modal').modal('show');
      },
      editModal(data){
        this.editMode = true;
        let detailData = JSON.parse(data.parameter) 
        console.log('data',data)
        if(data.nama_jenis_alat === "Hydraulic Excavator"){
          this.hydraulicMode = true
        }else if(data.nama_jenis_alat === "Dump Truck"){
          this.dumpMode = true
        }else if(data.nama_jenis_alat === "Bulldozer"){
          this.bulldozerMode = true
        }else{
          this.compactorMode = true
        }
        this.form.id_volume_pekerjaan = data.id_volume_pekerjaan
        this.form.dump.jumlah_fleet = detailData.jumlah_fleet
        this.form.dump.jumlah_dt = detailData.jumlah_alat / detailData.jumlah_fleet
        this.form.id = data.id
        this.form.id_jenis_alat = [data.id_jenis_alat,data.nama_jenis_alat]
        this.form.id_tipe_alat = data.id_tipe_alat
        this.form.clear();
        $('#modal').modal('show');
      },
      storeData(){
        this.form.post("{{ route('kebutuhanAlat.store') }}")
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
              'Berhasil',
              'Data kebutuhan alat berhasil ditambahkan',
              'success'
          )
          this.refreshData()
          this.emptyFilter()
        })
        .catch(e => {
            e.response.status != 422 ? console.log(e) : '';
        })
      },
      updateData(){
        url = "{{ route('kebutuhanAlat.update', ':id') }}".replace(':id', this.form.id)
        this.form.put(url)
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
            'Berhasil',
            'Data kebutuhan alat berhasil diubah',
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
            url = "{{ route('kebutuhanAlat.destroy', ':id') }}".replace(':id', id)
            this.form.delete(url)
            .then(response => {
              console.log('res',response)
              Swal.fire(
                'Terhapus',
                'Data kebutuhan alat telah dihapus',
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
        axios.get("{{ route('kebutuhanAlat.list') }}")
        .then(response => {
          if (response.data.length !== 0){
            let array = []
            for(let data of response.data){
              let params = JSON.parse(data.parameter)
              let parameter = ""

              const format = data.hasil.toString().split('').reverse().join('');
              const convert = format.match(/\d{1,3}/g);
              const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
              data.sewa_harian = rupiah
             
              if(data.nama_jenis_alat === "Dump Truck"){
                parameter += "Volume Pekerjaan :" + params.volume_pekerjaan  + " m<sup>3</sup>"
                parameter += "<br/> " + "Produktivitas per jam :" + params.produktivitas_per_jam  + " m<sup>3</sup>/jam"
                parameter += "<br/> " + "Jam kerja per hari :" + params.jam_kerja_per_hari  + " jam"
                parameter += "<br/> " + "Waktu pelaksanaan :" + params.waktu_pelaksanaan  + " hari kalender"
                parameter += "<br/> " + "Jumlah fleet :" + params.jumlah_fleet  + " unit"
                data.parameterString = parameter
              }else{
                parameter += "Volume Pekerjaan :" + params.volume_pekerjaan  + " m<sup>3</sup>"
                parameter += "<br/> " + "Produktivitas per jam :" + params.produktivitas_per_jam  + " m<sup>3</sup>/jam"
                parameter += "<br/> " + "Jam kerja per hari :" + params.jam_kerja_per_hari  + " jam"
                parameter += "<br/> " + "Waktu pelaksanaan :" + params.waktu_pelaksanaan  + " hari kalender"
                parameter += "<br/> " + "Produktivitas alat per hari :" + params.produktivitas_alat_per_hari  + " m<sup3</sup>"
                parameter += "<br/> " + "Produktivitas alat min per hari :" + params.produktivitas_min_per_hari  + " m<sup3</sup>"
                data.parameterString = parameter
              }
              data.jumlahAlat = params.jumlah_alat
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
      inputSelectVolumePekerjaan(){
        this.form.id_volume_pekerjaan =  $("#id_volume_pekerjaan_modal").val()
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
      filterData(){
        if (this.form.id_tipe_alat !== "" && this.form.id_jenis_alat === ""){
          url = "{{ route('kebutuhanAlatbyTipeAlat.filter', ':id') }}".replace(':id', this.form.id_tipe_alat)
          this.form.get(url)
          .then(response => {
            if (response.data.length !== 0){
              let array = []
              for(let data of response.data){
                let params = JSON.parse(data.parameter)
                let parameter = ""

                const format = data.hasil.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
                data.sewa_harian = rupiah
              
                if(data.nama_jenis_alat === "Dump Truck"){
                  parameter += "Volume Pekerjaan :" + params.volume_pekerjaan  + " m<sup>3</sup>"
                  parameter += "<br/> " + "Produktivitas per jam :" + params.produktivitas_per_jam  + " m<sup>3</sup>/jam"
                  parameter += "<br/> " + "Jam kerja per hari :" + params.jam_kerja_per_hari  + " jam"
                  parameter += "<br/> " + "Waktu pelaksanaan :" + params.waktu_pelaksanaan  + " hari kalender"
                  parameter += "<br/> " + "Jumlah fleet :" + params.jumlah_fleet  + " unit"
                  data.parameterString = parameter
                }else{
                  parameter += "Volume Pekerjaan :" + params.volume_pekerjaan  + " m<sup>3</sup>"
                  parameter += "<br/> " + "Produktivitas per jam :" + params.produktivitas_per_jam  + " m<sup>3</sup>/jam"
                  parameter += "<br/> " + "Jam kerja per hari :" + params.jam_kerja_per_hari  + " jam"
                  parameter += "<br/> " + "Waktu pelaksanaan :" + params.waktu_pelaksanaan  + " hari kalender"
                  parameter += "<br/> " + "Produktivitas alat per hari :" + params.produktivitas_alat_per_hari  + " m<sup3</sup>"
                  parameter += "<br/> " + "Produktivitas alat min per hari :" + params.produktivitas_min_per_hari  + " m<sup3</sup>"
                  data.parameterString = parameter
                }
                data.jumlahAlat = params.jumlah_alat
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
          url = "{{ route('kebutuhanAlat.filter', ':id') }}".replace(':id', this.form.id_jenis_alat)
          this.form.get(url)
          .then(response => {
            if (response.data.length !== 0){
              let array = []
              for(let data of response.data){
                let params = JSON.parse(data.parameter)
                let parameter = ""

                const format = data.hasil.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
                data.sewa_harian = rupiah
              
                if(data.nama_jenis_alat === "Dump Truck"){
                  parameter += "Volume Pekerjaan :" + params.volume_pekerjaan  + " m<sup>3</sup>"
                  parameter += "<br/> " + "Produktivitas per jam :" + params.produktivitas_per_jam  + " m<sup>3</sup>/jam"
                  parameter += "<br/> " + "Jam kerja per hari :" + params.jam_kerja_per_hari  + " jam"
                  parameter += "<br/> " + "Waktu pelaksanaan :" + params.waktu_pelaksanaan  + " hari kalender"
                  parameter += "<br/> " + "Jumlah fleet :" + params.jumlah_fleet  + " unit"
                  data.parameterString = parameter
                }else{
                  parameter += "Volume Pekerjaan :" + params.volume_pekerjaan  + " m<sup>3</sup>"
                  parameter += "<br/> " + "Produktivitas per jam :" + params.produktivitas_per_jam  + " m<sup>3</sup>/jam"
                  parameter += "<br/> " + "Jam kerja per hari :" + params.jam_kerja_per_hari  + " jam"
                  parameter += "<br/> " + "Waktu pelaksanaan :" + params.waktu_pelaksanaan  + " hari kalender"
                  parameter += "<br/> " + "Produktivitas alat per hari :" + params.produktivitas_alat_per_hari  + " m<sup3</sup>"
                  parameter += "<br/> " + "Produktivitas alat min per hari :" + params.produktivitas_min_per_hari  + " m<sup3</sup>"
                  data.parameterString = parameter
                }
                data.jumlahAlat = params.jumlah_alat
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
