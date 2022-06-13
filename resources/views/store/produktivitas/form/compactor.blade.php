<div v-show="compactorMode">
  <div class="form-row">
    <label class="col-md-2" for="lebar_pemadatan"> Lebar pemadatan </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.compactor.lebar_pemadatan" id="lebar_pemadatan" type="number" step="0.01" placeholder="Masukkan lebar pemadatan"
              class="form-control" :class="{ 'is-invalid': form.errors.has('compactor.lebar_pemadatan') }">
          <div class="invalid-feedback">
            Lebar pemadatan required
          </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">meter</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="lebar_blade">Lebar blade</label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
            <input v-model="form.compactor.lebar_blade" id="compactor.lebar_blade" type="number" step="0.01" placeholder="Masukkan lebar blade"
              class="form-control" :class="{ 'is-invalid': form.errors.has('lebar_blade') }">
            <div class="invalid-feedback">
              Lebar pemadatan required
            </div>
        </div>
        <div class="col-md-2 block-tag">
          <small class="badge badge-default badge-success text-white">mm</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="lebar_overlap"> Lebar overlap </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
            <input v-model="form.compactor.lebar_overlap" id="compactor.lebar_overlap" type="number" step="0.01" placeholder="Masukkan lebar overlap"
              class="form-control" :class="{ 'is-invalid': form.errors.has('lebar_overlap') }">
            <div class="invalid-feedback">
              Lebar overlap required
            </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">meter</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="number_of_trips">Number of trips </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.compactor.number_of_trips" id="number_of_trips" type="number" step="0.01" placeholder="Masukkan number of trips"
              class="form-control" :class="{ 'is-invalid': form.errors.has('compactor.number_of_trips') }">
          <div class="invalid-feedback">
            Number of trips required
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="kecepatan_kerja"> Kecepatan kerja </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.compactor.kecepatan_kerja" id="kecepatan_kerja" type="number" step="0.01" placeholder="Masukkan kecepatan kerja"
              class="form-control" :class="{ 'is-invalid': form.errors.has('compactor.kecepatan_kerja') }">
          <div class="invalid-feedback">
            Kecepatan kerja required
          </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">m/jam</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="job_efficiency"> Job Efficiency</label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.compactor.job_efficiency" id="job_efficiency" type="number" step="0.01" placeholder="Masukkan job efficiency"
              class="form-control" :class="{ 'is-invalid': form.errors.has('compactor.job_efficiency') }">
          <div class="invalid-feedback">
            Job efficiency required
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="tebal_lapisan_tanah"> Tebal lapisan tanah </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
            <input v-model="form.compactor.tebal_lapisan_tanah" id="tebal_lapisan_tanah" type="number" step="0.01" placeholder="Masukkan tebal lapisan tanah"
              class="form-control" :class="{ 'is-invalid': form.errors.has('compactor.tebal_lapisan_tanah') }">
            <div class="invalid-feedback">
              Tebal tanah required
            </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">meter</small>
        </div>
      </div>
    </div>
  </div>
</div>