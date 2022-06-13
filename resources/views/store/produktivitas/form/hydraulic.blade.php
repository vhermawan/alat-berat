<div v-show="hydraulicMode">
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Standar Cycle Time </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.hydraulic.waktu_putar" id="waktu_putar"
                  :class="{ 'is-invalid': form.errors.has('waktu_putar') }"
                  placeholder="Masukkan waktu putar">
                  <has-error :form="form" field="waktu_putar"></has-error>
              </div>
            </div>
            <div class="col-md-2 block-tag">
              <small class="badge badge-default badge-success text-white">detik</small>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.hydraulic.kecepatan_putar" id="kecepatan_putar"
                  :class="{ 'is-invalid': form.errors.has('kecepatan_putar') }"    
                  placeholder="Masukan kecepatan putar">
                  <has-error :form="form" field="kecepatan_putar"></has-error>
              </div>
            </div>
            <div class="col-md-2 block-tag">
              <small class="badge badge-default badge-success text-white">detik/menit</small>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="conversion_factor"> Conversion factor </label>
    <div class="form-group col-md-8">
      <input v-model="form.hydraulic.conversion_factor" id="conversion_factor" type="number" step="0.01" min=0 placeholder="Masukkan conversion factor"
          class="form-control" :class="{ 'is-invalid': form.errors.has('hydraulic.conversion_factor') }">
      <div class="invalid-feedback">
        Conversion factor required
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="bucket_fill_factor"> Bucket fill factor </label>
    <div class="form-group col-md-8">
      <input v-model="form.hydraulic.bucket_fill_factor" id="bucket_fill_factor" type="number" step="0.01" min=0 placeholder="Masukkan bucket fill factor"
          class="form-control" :class="{ 'is-invalid': form.errors.has('hydraulic.bucket_fill_factor') }">
      <div class="invalid-feedback">
        Bucket fill factor required
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="faktor_kedalaman"> Faktor Kedalaman </label>
    <div class="form-group col-md-8">
      <input v-model="form.hydraulic.faktor_kedalaman" id="faktor_kedalaman" type="number" step="0.01" min=0 placeholder="Masukkan faktor kedalaman"
          class="form-control" :class="{ 'is-invalid': form.errors.has('hydraulic.faktor_kedalaman') }">
      <div class="invalid-feedback">
       Faktor kedalaman required
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="faktor_efisiensi_kerja"> Faktor Efisiensi Kerja </label>
    <div class="form-group col-md-8">
      <input v-model="form.hydraulic.faktor_efisiensi_kerja" id="faktor_efisiensi_kerja" type="number" step="0.01" min=0 placeholder="Masukkan faktor efisiensi kerja"
          class="form-control" :class="{ 'is-invalid': form.errors.has('hydraulic.faktor_efisiensi_kerja') }">
      <div class="invalid-feedback">
        Faktor efisiensi kerja required
       </div>
    </div>
  </div>
</div>