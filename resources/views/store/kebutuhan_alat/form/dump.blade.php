<div v-show="dumpMode">
  <div class="form-row">
    <label class="col-lg-2" for="id_volume_pekerjaan">Volume Pekerjaan</label>
    <div class="form-group col-md-10">
      <select v-model="form.id_volume_pekerjaan" id="id_volume_pekerjaan_modal" onchange="selectTriggerVolumePekerjaan()" placeholder="Pilih Proyek"
          style="width: 100%" class="form-control custom-select">
          <option disabled value="">- Pilih Volume Pekerjaan -</option>
          <option v-for="item in allVolumePekerjaan" :value="item.id">
              @{{item.nama }}</option>
      </select>
      <has-error :form="form" field="id_volume_pekerjaan"></has-error>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="jumlah_fleet"> Jumlah Fleet </label>
    <div class="form-group col-md-10">
      <input v-model="form.dump.jumlah_fleet" id="jumlah_fleet" type="number" step="0.01" min=0 placeholder="Masukkan jumlah fleet"
          class="form-control" :class="{ 'is-invalid': form.errors.has('jumlah_fleet') }">
      <has-error :form="form" field="jumlah_fleet"></has-error>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="jumlah_dt"> Jumlah DT </label>
    <div class="form-group col-md-10">
      <input v-model="form.dump.jumlah_dt" id="jumlah_dt" type="number" step="0.01" min=0 placeholder="Masukkan jumlah dt"
          class="form-control" :class="{ 'is-invalid': form.errors.has('jumlah_dt') }">
      <has-error :form="form" field="jumlah_dt"></has-error>
    </div>
  </div>
</div>