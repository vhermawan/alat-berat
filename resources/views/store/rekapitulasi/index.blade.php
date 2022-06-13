@extends('layout.master')
@section('title')
Rekapitulasi
@endsection
@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
    <div class="card-body">
        <h4 class="card-title">Tabel Rekapitulasi Biaya Operasional</h4>
        <div class="table-responsive">
          <table id="table_rekap" class="table table-striped table-bordered no-wrap">
            <thead>
                <tr>
                  <th>No</th>
                  <th>Proyek</th>
                  <th>Modal</th>
                  <th>Total Biaya Operasional</th>
                  <th>Hasil</th>
                </tr>
            </thead>
            <tbody>
              <tr v-for="item, index in mainData" :key="index">
                <td>@{{ index+1 }}</td>
                <td>@{{ item.nama_proyek}}</td>
                <td v-html="item.budget "></td>
                <td v-html="item.total"></td>
                <td v-html="item.untung"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Rekapitulasi Produktivitas</h4>
            <div>
                <div id="chartdiv"></div>
            </div>
        </div>
    </div>
  </div>
  <div class="col-lg-12">
      <div class="card">
          <div class="card-body">
              <h4 class="card-title">Rekapitulasi Kebutuhan Alat</h4>
              <div>
                  <div id="chartdiv2"></div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-lg-12">
      <div class="card">
          <div class="card-body">
              <h4 class="card-title">Grafik Rekapitulasi Biaya Operasional</h4>
              <div>
                  <div id="chartdiv3"></div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Tabel Rekapitulasi Biaya Operasional</h4>
        <div class="table-responsive">
          <table id="table" class="table table-striped table-bordered no-wrap">
            <thead>
                <tr>
                  <th>No</th>
                  <th>Tipe Alat</th>
                  <th>Koefisien (Rp)</th>
                  <th>Jumlah Alat</th>
                </tr>
            </thead>
            <tbody>
              <tr v-for="item, index in mainData" :key="index">
                <td>@{{ index+1 }}</td>
                <td>@{{ item.nama_tipe_alat}}</td>
                <td v-html="item.hasil"></td>
                <td v-html="item.jumlahAlat"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<!-- Chart code -->
<!-- Chart code -->
<script>
    am5.ready(function() {
    
    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("chartdiv");
    
    
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
      am5themes_Animated.new(root)
    ]);
    
    
    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
      panX: false,
      panY: false,
      wheelX: "panX",
      wheelY: "zoomX",
      layout: root.verticalLayout
    }));
    
    
    // Add legend
    // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
    var legend = chart.children.push(
      am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50
      })
    );

    var dataProduktivitas = {!!json_encode($allProduktivitas)!!}

    var data = [];
    for (let produktivitas of dataProduktivitas){
        data.push({
            "nama_tipe_alat" : produktivitas.nama_tipe_alat,
            "hasil" :  produktivitas.hasil,
        })
    }
    
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
      categoryField: "nama_tipe_alat",
      renderer: am5xy.AxisRendererX.new(root, {
        cellStartLocation: 0.1,
        cellEndLocation: 0.9
      }),
      tooltip: am5.Tooltip.new(root, {})
    }));
    
    xAxis.data.setAll(data);
    
    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
      renderer: am5xy.AxisRendererY.new(root, {})
    }));
    
    
    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    function makeSeries(name, fieldName) {
      var series = chart.series.push(am5xy.ColumnSeries.new(root, {
        name: name,
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: fieldName,
        categoryXField: "nama_tipe_alat"
      }));
    
      series.columns.template.setAll({
        tooltipText: "{name}, {categoryX}:{valueY}",
        width: am5.percent(90),
        tooltipY: 0
      });
    
      series.data.setAll(data);
    
      // Make stuff animate on load
      // https://www.amcharts.com/docs/v5/concepts/animations/
      series.appear();
    
      series.bullets.push(function () {
        return am5.Bullet.new(root, {
          locationY: 0,
          sprite: am5.Label.new(root, {
            text: "{valueY}",
            fill: root.interfaceColors.get("alternativeText"),
            centerY: 0,
            centerX: am5.p50,
            populateText: true
          })
        });
      });
    
      legend.data.push(series);
    }


    makeSeries("Tipe Alat", "hasil");
    
    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    chart.appear(1000, 100);
    
    }); // end am5.ready()
</script>
<script>
    am5.ready(function() {
    
    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root2 = am5.Root.new("chartdiv2");
    
    
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root2.setThemes([
      am5themes_Animated.new(root2)
    ]);
    
    
    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root2.container.children.push(am5xy.XYChart.new(root2, {
      panX: false,
      panY: false,
      wheelX: "panX",
      wheelY: "zoomX",
      layout: root2.verticalLayout
    }));
    
    
    // Add legend
    // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
    var legend = chart.children.push(
      am5.Legend.new(root2, {
        centerX: am5.p50,
        x: am5.p50
      })
    );

    var dataKebutuhanAlat = {!!json_encode($allKebutuhanAlat)!!}

    var data = [];
    for (let kebutuhanAlat of dataKebutuhanAlat){
        let detailData = JSON.parse(kebutuhanAlat.parameter) 
        data.push({
            "nama_tipe_alat" : kebutuhanAlat.nama_tipe_alat,
            "hasil" :  detailData.jumlah_alat,
        })
    }
    
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root2, {
      categoryField: "nama_tipe_alat",
      renderer: am5xy.AxisRendererX.new(root2, {
        cellStartLocation: 0.1,
        cellEndLocation: 0.9
      }),
      tooltip: am5.Tooltip.new(root2, {})
    }));
    
    xAxis.data.setAll(data);
    
    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root2, {
      renderer: am5xy.AxisRendererY.new(root2, {})
    }));
    
    
    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    function makeSeries(name, fieldName) {
      var series = chart.series.push(am5xy.ColumnSeries.new(root2, {
        name: name,
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: fieldName,
        categoryXField: "nama_tipe_alat"
      }));
    
      series.columns.template.setAll({
        tooltipText: "{name}, {categoryX}:{valueY}",
        width: am5.percent(90),
        tooltipY: 0
      });
    
      series.data.setAll(data);
      // Make stuff animate on load
      // https://www.amcharts.com/docs/v5/concepts/animations/
      series.appear();
    
      series.bullets.push(function () {
        return am5.Bullet.new(root2, {
          locationY: 0,
          sprite: am5.Label.new(root2, {
            text: "{valueY}",
            fill: root2.interfaceColors.get("alternativeText"),
            centerY: 0,
            centerX: am5.p50,
            populateText: true
          })
        });
      });
    
      legend.data.push(series);
    }


    makeSeries("Tipe Alat", "hasil");
    
    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    chart.appear(1000, 100);
    
    }); // end am5.ready()
</script>
<script>
    am5.ready(function() {
    
    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root3 = am5.Root.new("chartdiv3");
    
    
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root3.setThemes([
      am5themes_Animated.new(root3)
    ]);
    
    
    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root3.container.children.push(am5xy.XYChart.new(root3, {
      panX: false,
      panY: false,
      wheelX: "panX",
      wheelY: "zoomX",
      layout: root3.verticalLayout
    }));
    
    
    // Add legend
    // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
    var legend = chart.children.push(
      am5.Legend.new(root3, {
        centerX: am5.p50,
        x: am5.p50
      })
    );

    var dataBiayaOperasional = {!!json_encode($allBiayaOperasional)!!}

    var data = [];
    for (let biayaOperasional of dataBiayaOperasional){
        data.push({
            "nama_tipe_alat" : biayaOperasional.nama_tipe_alat,
            "hasil" : biayaOperasional.hasil,
        })
    }
    
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root3, {
      categoryField: "nama_tipe_alat",
      renderer: am5xy.AxisRendererX.new(root3, {
        cellStartLocation: 0.1,
        cellEndLocation: 0.9
      }),
      tooltip: am5.Tooltip.new(root3, {})
    }));
    
    xAxis.data.setAll(data);
    
    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root3, {
      renderer: am5xy.AxisRendererY.new(root3, {})
    }));
    
    
    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    function makeSeries(name, fieldName) {
      var series = chart.series.push(am5xy.ColumnSeries.new(root3, {
        name: name,
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: fieldName,
        categoryXField: "nama_tipe_alat"
      }));
    
      series.columns.template.setAll({
        tooltipText: "{name}, {categoryX}:{valueY}",
        width: am5.percent(90),
        tooltipY: 0
      });
    
      series.data.setAll(data);
      // Make stuff animate on load
      // https://www.amcharts.com/docs/v5/concepts/animations/
      series.appear();
    
      series.bullets.push(function () {
        return am5.Bullet.new(root3, {
          locationY: 0,
          sprite: am5.Label.new(root3, {
            text: "{valueY}",
            fill: root3.interfaceColors.get("alternativeText"),
            centerY: 0,
            centerX: am5.p50,
            populateText: true
          })
        });
      });
    
      legend.data.push(series);
    }


    makeSeries("Tipe Alat", "hasil");
    
    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    chart.appear(1000, 100);
    
    }); // end am5.ready()
</script>
<script>
  var app = new Vue({
    el: '#app',
    data: {
      mainData: [],
    },
    mounted() {
      this.refreshData()
      this.getRekapitulasiKeuntungan()
    },
    methods: {
      refreshData() {
        axios.get("{{ route('rekapitulasi.list') }}")
        .then(response => {
          $('#table').DataTable().destroy()
          if (response.data.length !== 0){
            let array = []
            for(let data of response.data){
              let paramsKebutuhanAlat = JSON.parse(data.parameter_kebutuhan_alat)
              let totalBiaya = data.hasil * 8 * 58 * paramsKebutuhanAlat.jumlah_alat
              const format = totalBiaya.toString().split('').reverse().join('');
              const convert = format.match(/\d{1,3}/g);
              const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')
              data.hasil = rupiah
              data.jumlahAlat = paramsKebutuhanAlat.jumlah_alat
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
      getRekapitulasiKeuntungan() {
        axios.get("{{ route('rekapKeuntungan.list') }}")
        .then(response => {
          $('#table_rekap').DataTable().destroy()
          if (response.data.data.proyek.length !== 0){
          let array = []
           for($i=0; $i < response.data.data.proyek.length; $i++){
            let data = response.data.data.proyek[$i].budget
            const format = data.toString().split('').reverse().join('');
            const convert = format.match(/\d{1,3}/g);
            const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

            response.data.data.proyek[$i].modal = rupiah
            for($j=0; $j < response.data.data.total.length; $j++){
              console.log($i,$j)
              const formatBiaya = response.data.data.total[$j].toString().split('').reverse().join('');
              const convertBiaya = formatBiaya.match(/\d{1,3}/g);
              const rupiahBiaya = 'Rp ' + convertBiaya.join('.').split('').reverse().join('')

              let untung = ''
              if(response.data.data.proyek[$i].budget < response.data.data.total[$j]){
                untung = '<span class="text-danger">Rugi</span>'
              }else{
                untung = '<span class="text-success">Untung</span>'
              }

              if ($i == $j){
                array.push({
                  'nama_proyek': response.data.data.proyek[$i].nama,
                  'budget': response.data.data.proyek[$i].modal,
                  'total': rupiahBiaya,
                  'untung': untung
                })
              }
            }
           }
            this.mainData = array
          }else{
            this.mainData = [];
          }
          this.$nextTick(function () {
              $('#table_rekap').DataTable();
          })
        })
        .catch(e => {
          console.log('err',e)
          e.response.status != 422 ? console.log(e) : '';
        })
      },
    },
  })
</script>
@endpush