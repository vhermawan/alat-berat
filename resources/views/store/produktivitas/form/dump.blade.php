<div v-show="dumpMode">
  <div class="form-row">
    <label class="col-md-2" for="kapasitas_dump"> Kapasitas Dump </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.dump.kapasitas_dump" id="kapasitas_dump" type="number" step="0.01" placeholder="Masukkan kapasitas dump"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.kapasitas_dump') }">
          <div class="invalid-feedback">
            Kapasitas dump required
          </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">m<sup> 3</sup></small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-md-2" for="kapasitas_bucket"> Kapasitas Bucket </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.dump.kapasitas_bucket" id="kapasitas_bucket" type="number" step="0.01" placeholder="Masukkan kapasitas bucket"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.kapasitas_bucket') }">
          <div class="invalid-feedback">
            Kapasitas bucket required
          </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">m<sup> 3</sup></small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="bucket_fill_factor"> Bucket fill factor </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
            <input v-model="form.dump.bucket_fill_factor" id="bucket_fill_factor" type="number" step="0.01" placeholder="Masukkan bucket fill factor"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.bucket_fill_factor') }">
            <div class="invalid-feedback">
              Bucket fill factor required
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="cycle_time_excavator"> Cycle Time Excavator </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
            <input v-model="form.dump.cycle_time_excavator" id="cycle_time_excavator" type="number" step="0.0001" placeholder="Masukkan cycle time excavator"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.cycle_time_excavator') }">
            <div class="invalid-feedback">
              Cycle time excavator required
            </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">menit</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="jarak_angkut"> Jarak Angkut </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.dump.jarak_angkut" id="jarak_angkut" type="number" step="0.01" placeholder="Masukkan jarak angkut"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.jarak_angkut') }">
          <div class="invalid-feedback">
            Jarak angkut required
          </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">meter</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="loaded_speed"> Loaded Speed </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.dump.loaded_speed" id="loaded_speed" type="number" step="0.01" placeholder="Masukkan loaded speed"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.loaded_speed') }">
          <div class="invalid-feedback">
            Loaded speed required
          </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">m/menit</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="empty_speed"> Empty Speed </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.dump.empty_speed" id="empty_speed" type="number" step="0.01" placeholder="Masukkan empty speed"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.empty_speed') }">
          <div class="invalid-feedback">
            Empty speed required
          </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">m/menit</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="standby_dumping_time"> Standby and dumping time </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.dump.standby_dumping_time" id="standby_dumping_time" type="number" step="0.01" placeholder="Masukkan standby dumping time"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.standby_dumping_time') }">
          <div class="invalid-feedback">
            Stanby dumping time required
          </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">menit</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="spot_delay_time"> Spot and delay time</label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.dump.spot_delay_time" id="spot_delay_time" type="number" step="0.01" placeholder="Masukkan spot delay time"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.spot_delay_time') }">
          <div class="invalid-feedback">
            Spot delay time required
          </div>
        </div>
        <div class="col-md-2 block-tag">
            <small class="badge badge-default badge-success text-white">menit</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="job_efficiency"> Job Efficiency</label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-10">
          <input v-model="form.dump.job_efficiency" id="job_efficiency" type="number" step="0.01" placeholder="Masukkan job efficiency"
              class="form-control" :class="{ 'is-invalid': form.errors.has('dump.job_efficiency') }">
          <div class="invalid-feedback">
            Job efficiency required
          </div>
        </div>
      </div>
    </div>
  </div>
</div>