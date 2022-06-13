@extends('layout.master')
@section('title')
Proyek
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"> Daftar Proyek
            <button type="button" class="btn btn-primary btn-rounded float-right mb-3" @click="createModal()">
            <i class="fas fa-plus-circle"></i> Tambah Proyek</button>
          </h4>
          
          <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered no-wrap">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Dana</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="item, index in mainData" :key="index">
                  <td>@{{ index+1 }}</td>
                  <td>@{{ item.nama}}</td>
                  <td>@{{ item.lokasi}}</td>
                  <td>@{{ item.budget}}</td>
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
        <h4 class="modal-title" v-show="!editMode" id="myLargeModalLabel">Tambah Proyek</h4>
        <h4 class="modal-title" v-show="editMode" id="myLargeModalLabel">Edit</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form @submit.prevent="editMode ? updateData() : storeData()" @keydown="form.onKeydown($event)" id="form">
          <div class="modal-body mx-4">
            <div class="form-row">
              <label class="col-lg-2" for="nama"> Nama </label>
              <div class="form-group col-md-8">
                <input v-model="form.nama" id="nama" type="text" min=0 placeholder="Masukkan nama proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nama') }">
                <has-error :form="form" field="nama"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="lokasi"> Lokasi </label>
              <div class="form-group col-md-8">
                <input v-model="form.lokasi" id="lokasi" type="text" min=0 placeholder="Masukkan lokasi proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('lokasi') }">
                <has-error :form="form" field="lokasi"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="sumber_dana"> Sumber Dana </label>
              <div class="form-group col-md-8">
                <input v-model="form.sumber_dana" id="sumber_dana" type="text" min=0 placeholder="Masukkan sumber_dana proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('sumber_dana') }">
                <has-error :form="form" field="sumber_dana"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="budget"> Dana </label>
              <div class="form-group col-md-8">
                <input v-model="form.budget" id="budget" type="text" placeholder="Masukkan budget proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('budget') }">
                <has-error :form="form" field="budget"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="retensi"> Retensi </label>
              <div class="form-group col-md-8">
                <input v-model="form.retensi" id="retensi" type="text" min=0 placeholder="Masukkan retensi proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('retensi') }">
                <has-error :form="form" field="retensi"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="jenis_kontrak"> Jenis Kontrak </label>
              <div class="form-group col-md-8">
                <input v-model="form.jenis_kontrak" id="jenis_kontrak" type="text" min=0 placeholder="Masukkan jenis kontrak proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('jenis_kontrak') }">
                <has-error :form="form" field="jenis_kontrak"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="jaminan_pelaksana"> Jaminan Pelaksana </label>
              <div class="form-group col-md-8">
                <input v-model="form.jaminan_pelaksana" id="jaminan_pelaksana" type="text" min=0 placeholder="Masukkan jaminan pelaksana proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('jaminan_pelaksana') }">
                <has-error :form="form" field="jaminan_pelaksana"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="konsultan_perencana"> Konsultan Perencana </label>
              <div class="form-group col-md-8">
                <input v-model="form.konsultan_perencana" id="konsultan_perencana" type="text" min=0 placeholder="Masukkan konsultan perencana proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('konsultan_perencana') }">
                <has-error :form="form" field="konsultan_perencana"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="konsultan_supervisi"> Konsultan Superivsi </label>
              <div class="form-group col-md-8">
                <input v-model="form.konsultan_supervisi" id="konsultan_supervisi" type="text" min=0 placeholder="Masukkan konsultan supervisi proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('konsultan_supervisi') }">
                <has-error :form="form" field="konsultan_supervisi"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="pemilik_proyek"> Pemilik Proyek </label>
              <div class="form-group col-md-8">
                <input v-model="form.pemilik_proyek" id="pemilik_proyek" type="text" min=0 placeholder="Masukkan pemilik proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('pemilik_proyek') }">
                <has-error :form="form" field="pemilik_proyek"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="masa_pelaksanaan"> Masa Pelaksanaan </label>
              <div class="form-group col-md-8">
                <input v-model="form.masa_pelaksanaan" id="masa_pelaksanaan" type="text" min=0 placeholder="Masukkan masa pelaksanaan proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('masa_pelaksanaan') }">
                <has-error :form="form" field="masa_pelaksanaan"></has-error>
              </div>
            </div>
            <div class="form-row">
              <label class="col-lg-2" for="masa_pemeliharaan"> Masa Pemeliharaan </label>
              <div class="form-group col-md-8">
                <input v-model="form.masa_pemeliharaan" id="masa_pemeliharaan" type="text" min=0 placeholder="Masukkan masa pemeliharaan proyek"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('masa_pemeliharaan') }">
                <has-error :form="form" field="masa_pemeliharaan"></has-error>
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
  var app = new Vue({
    el: '#app',
    data: {
      mainData: [],
      form: new Form({
        id: '',
        nama: '',
        lokasi: '',
        sumber_dana: '',
        budget: '',
        retensi: '',
        jenis_kontrak: '',
        jaminan_pelaksana: '',
        konsultan_perencana: '',
        konsultan_supervisi: '',
        pemilik_proyek: '',
        masa_pelaksanaan: '',
        masa_pemeliharaan: '',
      }),
      editMode: false,
    },
    mounted() {
      this.refreshData()
    },
    watch:{
      'form.budget'(newVal){
        this.form.budget = formatRupiah(newVal,"Rp ")
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
        this.form.post("{{ route('proyek.store') }}")
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
              'Berhasil',
              'Data proyek berhasil ditambahkan',
              'success'
          )
          this.refreshData()
        })
        .catch(e => {
            e.response.status != 422 ? console.log(e) : '';
        })
      },
      updateData(){
        url = "{{ route('proyek.update', ':id') }}".replace(':id', this.form.id)
        this.form.put(url)
        .then(response => {
          $('#modal').modal('hide');
          Swal.fire(
            'Berhasil',
            'Data proyek berhasil diubah',
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
            url = "{{ route('proyek.destroy', ':id') }}".replace(':id', id)
            this.form.delete(url)
            .then(response => {
              console.log('res',response)
              Swal.fire(
                'Terhapus',
                'Data proyek telah dihapus',
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
        axios.get("{{ route('proyek.list') }}")
        .then(response => {
          $('#table').DataTable().destroy()
          if (response.data.length !== 0){
            let array = []
            for(let data of response.data){
              const format = data.budget.toString().split('').reverse().join('');
              const convert = format.match(/\d{1,3}/g);
              const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
              data.budget = rupiah
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
  })
</script>
@endpush
