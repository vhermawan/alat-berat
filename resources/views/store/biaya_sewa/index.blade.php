@extends('layout.master')
@section('title')
Biaya Sewa
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
          <h4 class="card-title"> Daftar Sewa
            <button type="button" class="btn btn-primary btn-rounded float-right mb-3" @click="createModal()">
            <i class="fas fa-plus-circle"></i> Tambah Sewa</button>
          </h4>
          
          <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-wrap">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Tipe Alat</th>
                    <th>Total Biaya</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="item, index in mainData" :key="index">
                  <td>@{{ index+1 }}</td>
                  <td>@{{ item.nama_tipe_alat}}</td>
                  <td>@{{ item.hasil}}</td>
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
        <h4 class="modal-title" v-show="!editMode" id="myLargeModalLabel">Tambah Biaya Sewa</h4>
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
            <div class="form-row">
              <label class="col-lg-2" for="biaya_mod"> Biaya Mod </label>
              <div class="form-group col-md-10">
                <input v-model="form.biaya_mod" id="biaya_mod" type="text" placeholder="Masukkan biaya mod"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('biaya_mod') }">
                <has-error :form="form" field="biaya_mod"></has-error>
              </div>
            </div>
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

  function selectTrigger(isModal) {
    if($("#id_proyek").val()!==null){
      app.getJenisAlat($("#id_proyek").val())
    }else{
      app.getJenisAlat($("#id_proyek_modal").val())
    }
    app.inputSelect()
  }

  function selectTriggerJenisAlat(){
    let jenisAlat = $("#id_jenis_alat_modal").val()
    let splitStringJenisAlat = jenisAlat.split(",")
    app.getTipeAlat(splitStringJenisAlat[0])
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
        biaya_mod: '',
      }),
      allProyek : @json($allProyek),
      allJenisAlat: [],
      allTipeAlat : [],
      editMode: false,
    },
    mounted() {
      this.refreshData()
    },
    watch:{
      'form.biaya_mod'(newVal){
        this.form.biaya_mod = formatRupiah(newVal,"Rp ")
      },
    },
    methods: {
      createModal(){
        this.editMode = false;
        this.form.reset();
        this.form.clear();
        $('#modal').modal('show');
      },
      editModal(data){
        console.log('data',data)
        this.editMode = true;
        this.form.id = data.id;
        this.form.biaya_mod = data.biaya_mod
        this.form.clear();
        $('#modal').modal('show');
      },
      storeData(){
        this.form.post("{{ route('biayaSewa.store') }}")
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
              'Berhasil',
              'Data biaya sewa berhasil ditambahkan',
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
        url = "{{ route('biayaSewa.update', ':id') }}".replace(':id', this.form.id)
        this.form.put(url)
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
            'Berhasil',
            'Data biaya sewa berhasil diubah',
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
            url = "{{ route('biayaSewa.destroy', ':id') }}".replace(':id', id)
            this.form.delete(url)
            .then(response => {
              console.log('res',response)
              Swal.fire(
                'Terhapus',
                'Data biaya sewa telah dihapus',
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
      filterData(){
        if (this.form.id_tipe_alat !== "" && this.form.id_jenis_alat === ""){
          url = "{{ route('biayaSewa.filter', ':id') }}".replace(':id', this.form.id_tipe_alat)
          axios.get(url)
          .then(response => {
            $('#table').DataTable().destroy()
            if (response.data.length !== 0){
              let array = []
              for(let data of response.data){
                const format = data.hasil.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
                data.hasil = rupiah
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
          url = "{{ route('biayaSewabyJenisAlat.filter', ':id') }}".replace(':id', this.form.id_jenis_alat)
          axios.get(url)
          .then(response => {
            $('#table').DataTable().destroy()
            if (response.data.length !== 0){
              let array = []
              for(let data of response.data){
                const format = data.hasil.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
                data.hasil = rupiah
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
      refreshData() {
        console.log('data call')
        axios.get("{{ route('biayaSewa.list') }}")
        .then(response => {
          $('#table').DataTable().destroy()
          if (response.data.length !== 0){
            let array = []
            for(let data of response.data){
              const format = data.hasil.toString().split('').reverse().join('');
              const convert = format.match(/\d{1,3}/g);
              const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
              data.hasil = rupiah
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
      },
      resetData(){
        this.form.id_proyek= '';
        this.refreshData()
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
