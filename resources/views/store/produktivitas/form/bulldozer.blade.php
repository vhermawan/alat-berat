<div v-show="bulldozerMode">
  <div class="form-row">
    <label class="col-md-2" for="kapasitas_blade"> Kapasitas Blade </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.bulldozer.kapasitas_blade" id="kapasitas_blade" type="number" step="0.01" placeholder="Masukkan kapasitas blade"
              class="form-control" :class="{ 'is-invalid': form.errors.has('bulldozer.kapasitas_blade') }">
         <div class="invalid-feedback">
          Kapsitas blade required
         </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">m<sup> 3</sup></small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="blade_factor">Blade Factor</label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.bulldozer.blade_factor" id="blade_factor" type="number" step="0.01" placeholder="Masukkan bucket fill factor"
              class="form-control" :class="{ 'is-invalid': form.errors.has('bulldozer.blade_factor') }">
            <div class="invalid-feedback">
                Blade factor required
             </div>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="jarak_dorong"> Jarak dorong </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.bulldozer.jarak_dorong" id="jarak_dorong" type="number" step="0.01" placeholder="Masukkan jarak dorong"
              class="form-control" :class="{ 'is-invalid': form.errors.has('bulldozer.jarak_dorong') }">
           <div class="invalid-feedback">
              Jarak dorong required
           </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">meter</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="fordward_speed">Fordward Speed </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
            <input v-model="form.bulldozer.fordward_speed" id="bulldozer.fordward_speed" type="number" step="0.01" placeholder="Masukkan fordward speed"
              class="form-control" :class="{ 'is-invalid': form.errors.has('fordward_speed') }">
            <div class="invalid-feedback">
             Fordward speed required
            </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">m/menit</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="reverse_speed"> Reverse Speed </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
            <input v-model="form.bulldozer.reverse_speed" id="reverse_speed" type="number" step="0.01" placeholder="Masukkan reverse speed"
              class="form-control" :class="{ 'is-invalid': form.errors.has('bulldozer.reverse_speed') }">
            <div class="invalid-feedback">
              Reverse speed required
            </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">m/menit</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="gear_shifting"> Gear shifting time </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
            <input v-model="form.bulldozer.gear_shifting" id="gear_shifting" type="number" step="0.01" placeholder="Masukkan gear shifting time"
              class="form-control" :class="{ 'is-invalid': form.errors.has('bulldozer.gear_shifting') }">
            <div class="invalid-feedback">
              Gear shifting required
            </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">menit</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="grade_factor"> Grade factor </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.bulldozer.grade_factor" id="grade_factor" type="number" step="0.01" placeholder="Masukkan grade factor"
              class="form-control" :class="{ 'is-invalid': form.errors.has('bulldozer.grade_factor') }">
          <div class="invalid-feedback">
            Grade factor required
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="job_efficiency"> Job Efficiency</label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.bulldozer.job_efficiency" id="job_efficiency" type="number" step="0.01" placeholder="Masukkan job efficiency"
              class="form-control" :class="{ 'is-invalid': form.errors.has('bulldozer.job_efficiency') }">
          <div class="invalid-feedback">
            Job efficiency required
          </div>
        </div>
      </div>
    </div>
  </div>
</div>