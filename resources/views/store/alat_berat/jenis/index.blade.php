@extends('layout.master')
@section('title')
Jenis Alat Berat
@endsection
@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">
        Pilih Proyek
      </h4>
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
          <h4 class="card-title"> Daftar Jenis Alat Berat
            <button type="button" class="btn btn-primary btn-rounded float-right mb-3" @click="createModal()">
            <i class="fas fa-plus-circle"></i> Tambah Jenis Alat Berat</button>
          </h4>
          
          <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-wrap">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Proyek</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="item, index in mainData" :key="index">
                  <td>@{{ index+1 }}</td>
                  <td>@{{ item.nama}}</td>
                  <td>@{{ item.nama_proyek}}</td>
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
        <h4 class="modal-title" v-show="!editMode" id="myLargeModalLabel">Tambah Jenis Alat Berat</h4>
        <h4 class="modal-title" v-show="editMode" id="myLargeModalLabel">Edit</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form @submit.prevent="editMode ? updateData() : storeData()" @keydown="form.onKeydown($event)" id="form">
          <div class="modal-body mx-4">
            <div class="form-row">
              <label class="col-lg-2" for="id_proyek">Proyek</label>
              <div class="form-group col-md-8">
                <select v-model="form.id_proyek" id="id_proyek" onchange="selectTrigger()" placeholder="Pilih Proyek"
                    style="width: 100%" class="form-control custom-select">
                    <option disabled value="">- Pilih Proyek -</option>
                    <option v-for="item in allProyek" :value="item.id">
                        @{{  item.nama }}</option>
                </select>
                <has-error :form="form" field="id_proyek"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="nama"> Nama </label>
              <div class="form-group col-md-8">
                <input v-model="form.nama" id="nama" type="text" min=0 placeholder="Masukkan nama jenis alat berat"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nama') }">
                <has-error :form="form" field="nama"></has-error>
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
  function selectTrigger() {
      app.inputSelect()
  }

  var app = new Vue({
    el: '#app',
    data: {
      mainData: [
      ],
      form: new Form({
        id: '',
        id_proyek: '',
        nama: '',
      }),
      allProyek : @json($allProyek),
      editMode: false,
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
        this.form.fill(data)
        this.form.clear();
        $('#modal').modal('show');
      },
      storeData(){
        this.form.post("{{ route('jenisAlat.store') }}")
        .then(response => {
          console.log('res',response)
          $('#modal').modal('hide');
          Swal.fire(
              'Berhasil',
              'Data jenis alat berhasil ditambahkan',
              'success'
          )
          this.refreshData()
        })
        .catch(e => {
            e.response.status != 422 ? console.log(e) : '';
        })
      },
      updateData(){
        url = "{{ route('jenisAlat.update', ':id') }}".replace(':id', this.form.id)
        this.form.put(url)
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
            'Berhasil',
            'Data jenis alat berhasil diubah',
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
            url = "{{ route('jenisAlat.destroy', ':id') }}".replace(':id', id)
            this.form.delete(url)
            .then(response => {
              console.log('res',response)
              Swal.fire(
                'Terhapus',
                'Data jenis alat telah dihapus',
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
        axios.get("{{ route('jenisAlat.list') }}")
        .then(response => {
          $('#table').DataTable().destroy()
          this.mainData = response.data
          this.$nextTick(function () {
              $('#table').DataTable();
          })
        })
        .catch(e => {
          e.response.status != 422 ? console.log(e) : '';
        })
      },
      inputSelect() {
        this.form.id_proyek =  $("#id_proyek").val()
      },
      filterData(){
        url = "{{ route('jenisAlat.filter', ':id') }}".replace(':id', this.form.id_proyek)
        this.form.get(url)
        .then(response => {
          $('#table').DataTable().destroy()
          this.mainData = response.data
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
      }
    },
  })
</script>
@endpush
