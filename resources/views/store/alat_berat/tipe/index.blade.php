@extends('layout.master')
@section('title')
Tipe Alat Berat
@endsection
@section('content')
<div class="container-fluid">

  <div class="card">
    <div class="card-body">
      <h4 class="card-title">
        Pilih Jenis Alat
      </h4>
      <form @submit.prevent="filterData()" @keydown="form.onKeydown($event)" id="formPasien">
          <div class="row my-4">
              <div class="col md-12">
                <div class="form-row">
                  <label class="col-lg-2" for="id_jenis_alat">Jenis Alat</label>
                  <div class="form-group col-md-10">
                    <select v-model="form.id_jenis_alat" id="id_jenis_alat" onchange="selectTrigger()" placeholder="Pilih Proyek"
                        style="width: 100%" class="form-control custom-select">
                        <option disabled value="">- Pilih Jenis Alat -</option>
                        <option v-for="item in allJenisAlat" :value="item.id">
                            @{{item.nama}}</option>
                    </select>
                    <has-error :form="form" field="id_jenis_alat"></has-error>
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
          <h4 class="card-title"> Daftar Tipe Alat Berat
            <button type="button" class="btn btn-primary btn-rounded float-right mb-3" @click="createModal()">
            <i class="fas fa-plus-circle"></i> Tambah Tipe Alat Berat</button>
          </h4>
          
          <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-wrap">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Alat</th>
                    <th>Merk</th>
                    <th>Kapasitas</th>
                    <th>Sewa satuan/jam</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="item, index in mainData" :key="index">
                  <td>@{{ index+1 }}</td>
                  <td>@{{ item.nama}}</td>
                  <td>@{{ item.nama_jenis_alat}}</td>
                  <td>@{{ item.merk}}</td>
                  <td>@{{ item.kapasitas_bucket}}</td>
                  <td>@{{ item.sewa_bulanan}}</td>
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
        <h4 class="modal-title" v-show="!editMode" id="myLargeModalLabel">Tambah Tipe Alat Berat</h4>
        <h4 class="modal-title" v-show="editMode" id="myLargeModalLabel">Edit</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="emptyFilter()">×</button>
      </div>
      <form @submit.prevent="editMode ? updateData() : storeData()" @keydown="form.onKeydown($event)" id="form">
          <div class="modal-body mx-4">
            <div class="form-row">
              <label class="col-lg-2" for="id_jenis_alat">Jenis Alat</label>
              <div class="form-group col-md-8">
                <select v-model="form.id_jenis_alat" id="id_jenis_alat" onchange="selectTrigger()" placeholder="Pilih Proyek"
                    style="width: 100%" class="form-control custom-select">
                    <option disabled value="">- Pilih Jenis Alat -</option>
                    <option v-for="item in allJenisAlat" :value="item.id">
                        @{{  item.nama }}</option>
                </select>
                <has-error :form="form" field="id_jenis_alat"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="nama"> Nama </label>
              <div class="form-group col-md-8">
                <input v-model="form.nama" id="nama" type="text" min=0 placeholder="Masukkan nama alat berat"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nama') }">
                <has-error :form="form" field="nama"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="merk"> Merk </label>
              <div class="form-group col-md-8">
                <input v-model="form.merk" id="merk" type="text" min=0 placeholder="Masukkan merk alat berat"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('merk') }">
                <has-error :form="form" field="merk"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="sewa_bulanan"> Biaya sewa satuan alat per jam </label>
              <div class="form-group col-md-8">
                <input v-model="form.sewa_bulanan" id="sewa_bulanan" type="text" min=0 placeholder="Masukkan sewa bulanan"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('sewa_bulanan') }">
                <has-error :form="form" field="sewa_bulanan"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="kapasitas_bucket"> Kapasistas </label>
              <div class="form-group col-md-8">
                <input v-model="form.kapasitas_bucket" id="kapasitas_bucket" type="number" step="0.001" min=0 placeholder="Masukkan kapasitas alat berat"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('kapasitas_bucket') }">
                <has-error :form="form" field="kapasitas_bucket"></has-error>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal" @click="emptyFilter()">Batal</button>
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
      app.inputSelect()
  }
  $('#keluar').click(function(){
   app.emptyFilter()
  });

  $('#batal').click(function(){
   app.emptyFilter()
  });

  var app = new Vue({
    el: '#app',
    data: {
      mainData: [
      ],
      form: new Form({
        id: '',
        nama: '',
        id_jenis_alat: '',
        kapasitas_bucket: '',
        merk :'',
        sewa_bulanan : '',      
      }),
      allJenisAlat : @json($allJenisAlat),
      editMode: false,
    },
    mounted() {
      this.refreshData()
    },
    watch:{
      'form.sewa_bulanan'(newVal){
        this.form.sewa_bulanan = formatRupiah(newVal,"Rp ")
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
        this.editMode = true;
        this.form.fill(data)
        this.form.clear();
        $('#modal').modal('show');
      },
      storeData(){
        let data = $("#sewa_bulanan ").val().split(" ")
        let result = data[1].replaceAll(".","")
        this.form.sewa_bulanan = new Number(result)
        this.form.post("{{ route('tipeAlat.store') }}")
        .then(response => {
          console.log('res',response)
          $('#modal').modal('hide');
          Swal.fire(
              'Berhasil',
              'Data tipe alat berhasil ditambahkan',
              'success'
          )
          this.refreshData()
        })
        .catch(e => {
            e.response.status != 422 ? console.log(e) : '';
        })
      },
      updateData(){
        url = "{{ route('tipeAlat.update', ':id') }}".replace(':id', this.form.id)
        let data = $("#sewa_bulanan ").val().split(" ")
        let result = data[1].replaceAll(".","")
        this.form.sewa_bulanan = new Number(result)
        this.form.put(url)
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
            'Berhasil',
            'Data tipe alat berhasil diubah',
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
            url = "{{ route('tipeAlat.destroy', ':id') }}".replace(':id', id)
            this.form.delete(url)
            .then(response => {
              console.log('res',response)
              Swal.fire(
                'Terhapus',
                'Data tipe alat telah dihapus',
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
        axios.get("{{ route('tipeAlat.list') }}")
        .then(response => {
          $('#table').DataTable().destroy()
          if (response.data.length !== 0){
            let array = []
            for(let data of response.data){
              const format = data.sewa_bulanan.toString().split('').reverse().join('');
              const convert = format.match(/\d{1,3}/g);
              const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
              data.sewa_bulanan = rupiah
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
          console.log('err',e)
          e.response.status != 422 ? console.log(e) : '';
        })
      },
      inputSelect() {
        this.form.id_tipe_alat =  $("#id_tipe_alat").val()
      },
      filterData(){
        url = "{{ route('tipeAlat.filter', ':id') }}".replace(':id', this.form.id_jenis_alat)
        this.form.get(url)
        .then(response => {
          $('#table').DataTable().destroy()
          if (response.data.length !== 0){
            let array = []
            for(let data of response.data){
              const format = data.sewa_bulanan.toString().split('').reverse().join('');
              const convert = format.match(/\d{1,3}/g);
              const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
              data.sewa_bulanan = rupiah
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
        this.form.id_jenis_alat= '';
        this.refreshData()
      },
      emptyFilter(){
        this.form.clear();
        this.form.reset();
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
