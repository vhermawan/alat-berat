<div v-show="bulldozerMode">
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Bahan Bakar </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input  type='currency' class="form-control" v-model="form.bulldozer.bahan_bakar.harga_satuan" id="harga_satuan"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.bahan_bakar.harga_satuan') }"
                  placeholder="Masukkan harga satuan bahan bakar">
                  <div class="invalid-feedback"> 
                    Harga satuan required
                  </div>
              </div>
            </div>
          </div>   
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.bahan_bakar.daya_mesin" id="daya_mesin"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.bahan_bakar.daya_mesin') }"    
                  placeholder="Masukan daya mesin bahan bakar">
                  <div class="invalid-feedback">
                    Bahan bakar required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.bahan_bakar.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.bahan_bakar.interval') }"    
                  placeholder="Masukan interval bahan bakar">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Oil Engine </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.oil_engine.harga_satuan" id="harga_satuan_oil_engine"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.oil_engine.harga_satuan') }"
                  placeholder="Masukkan harga satuan oil engine">
                  <div class="invalid-feedback"> 
                    Harga satuan required
                  </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.oil_engine.liter_pemakaian" id="liter_pemakaian"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.oil_engine.liter_pemakaian') }"    
                  placeholder="Masukan liter pemakaian oil engine">
                  <div class="invalid-feedback"> 
                    Liter pemakaian required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.oil_engine.faktor_efisien" id="faktor_efisien"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.oil_engine.faktor_efisien') }"    
                  placeholder="Masukan faktor efisien oil engine">
                  <div class="invalid-feedback"> 
                    Faktor efisien required
                  </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.oil_engine.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.oil_engine.interval') }"    
                  placeholder="Masukan interval oil engine">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Oil Hidrolik </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.oil_hidrolik.harga_satuan" id="harga_satuan"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.oil_hidrolik.harga_satuan') }"
                  placeholder="Masukkan harga satuan oil hidrolik">
                  <div class="invalid-feedback"> 
                    Harga satuan required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.oil_hidrolik.daya_mesin" id="daya_mesin"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.oil_hidrolik.daya_mesin') }"    
                  placeholder="Masukan daya mesin oil hidrolik">
                  <div class="invalid-feedback">
                    Bahan bakar required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.oil_hidrolik.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.oil_hidrolik.interval') }"    
                  placeholder="Masukan interval oil hidrolik">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Engine Oil Filter </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.engine_oil_filter.koefisien" id="koefisien"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.engine_oil_filter.koefisien') }"
                  placeholder="Masukkan koefisien engine oil filter">
                  <div class="invalid-feedback">
                    Koefisien required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.engine_oil_filter.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.engine_oil_filter.interval') }"    
                  placeholder="Masukan interval engine oil filter">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Pre fuel filter </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.pre_fuel_filter.koefisien" id="koefisien"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.pre_fuel_filter.koefisien') }"
                  placeholder="Masukkan koefisien pre fuel filter">
                  <div class="invalid-feedback">
                    Koefisien required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.pre_fuel_filter.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.pre_fuel_filter.interval') }"    
                  placeholder="Masukan interval pre fuel filter">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Fuel Filter </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.fuel_filter.koefisien" id="koefisien"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.fuel_filter.koefisien') }"
                  placeholder="Masukkan harga bulanan fuel filter">
                  <div class="invalid-feedback">
                    Koefisien required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.fuel_filter.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.fuel_filter.interval') }"    
                  placeholder="Masukan interval fuel filter">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Air Cleaner Inner </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.air_cleaner_inner.koefisien" id="koefisien"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.air_cleaner_inner.koefisien') }"
                  placeholder="Masukkan koefisien air cleaner inner">
                  <div class="invalid-feedback">
                    Koefisien required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.air_cleaner_inner.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.air_cleaner_inner.interval') }"    
                  placeholder="Masukan interval air cleaner_inner">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Air Cleaner Outer </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.air_cleaner_outer.koefisien" id="koefisien"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.air_cleaner_outer.koefisien') }"
                  placeholder="Masukkan koefisien air cleaner outer">
                  <div class="invalid-feedback">
                    Koefisien required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.air_cleaner_outer.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.air_cleaner_outer.interval') }"    
                  placeholder="Masukan interval air cleaner outer">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Grase </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.grase.harga_bulanan" id="harga_bulanan"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.grase.harga_bulanan') }"
                  placeholder="Masukkan harga bulanan grase">
                  <div class="invalid-feedback">
                    Harga bulanan required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="number" step="0.01" class="form-control" v-model="form.bulldozer.grase.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.grase.interval') }"    
                  placeholder="Masukan interval grase">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
  <div class="form-row">
    <label class="col-lg-2" for="sct"> Operator </label>
    <div class="form-group col-md-10">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.gaji_operator.harga_bulanan" id="harga_bulanan"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.gaji_operator.harga_bulanan') }"
                  placeholder="Masukkan harga bulanan gaji operator">
                  <div class="invalid-feedback">
                    Harga bulanan required
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                  <input type="text" class="form-control" v-model="form.bulldozer.gaji_operator.interval" id="interval"
                  :class="{ 'is-invalid': form.errors.has('bulldozer.gaji_operator.interval') }"    
                  placeholder="Masukan interval gaji operator">
                  <div class="invalid-feedback">
                    Interval required
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
</div>