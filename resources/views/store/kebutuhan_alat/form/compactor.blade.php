<div v-show="compactorMode">
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
</div>