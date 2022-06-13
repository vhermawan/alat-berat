<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('template/assets/images/APOTECH1.png')}}">
  <title>@yield('title') | Sistem Informasi Alat Berat</title>
  <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
  <!-- Custom CSS -->
  <link href="{{asset('template/assets/extra-libs/c3/c3.min.css')}}" rel="stylesheet">
  <!-- <link href="{{'template/assets/libs/chartist/dist/chartist.min.css'}}" rel="stylesheet"> -->
  <link href="{{asset('template/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" />
  <!-- Custom CSS -->
  <link href="{{asset('template/dist/css/style.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}"
    rel="stylesheet">

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0-beta.0/leaflet.min.css" integrity="sha512-4DBUVB81hf1k3DdMRM7t3yp+X+ePuKMa2qun/Rt/POUEjgfqEhLYnDgPsfqWGWc4mO4x5jjhi5MSPWPH7hU5IQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.8.0-beta.0/leaflet-src.min.js" integrity="sha512-Cgpu61fENYVBxtwpgSzPxKASKnIaLcMWoYtwF6P/KVO9uLre2yDXpAPX+BzhDKIKn5LU+hoJdpE5JlTSPHFMtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Geocoder -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
    integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
    crossorigin="anonymous" />

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
  <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
  <style>
    .item-scrollable {
      height: auto;
      max-height: 250px;      
      overflow-x: hidden;
    }
    #chartdiv {
      width: 100%;
      height: 500px;
    }
    #chartdiv2 {
      width: 100%;
      height: 500px;
    }
    #chartdiv3 {
      width: 100%;
      height: 500px;
    }
  </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
      data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


      @include('sweetalert::alert')
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      @include('layout.topbar')
      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      @include('layout.sidebar')

      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-7 align-self-center">
              @guest
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Selamat Datang , Admin!
              </h3>
              @endguest
              @auth
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Halo,
                  {{ Auth::user()->email }}!
              </h3>
              @endauth
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid" id="app">
          <!-- ********************* -->
          <!-- Start First Cards -->
          <!-- ********************* -->
          @yield('content')
          <!-- ********************* -->
          <!-- End Top Leader Table -->
          <!-- ********************* -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center text-muted">
         Sistem Informasi Alat Berat ⓒ 2022 
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
    </div>

    <script src="{{asset('template/js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    @stack('script')

    <!-- apps -->
    <script src="{{asset('template/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('template/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('template/dist/js/app-style-switcher.js')}}"></script>
    <script src="{{asset('template/dist/js/feather.min.js')}}"></script>
    <script src="{{asset('template/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('template/assets/extra-libs/sparkline/sparkline.js')}}"></script>
    <script src="{{asset('template/dist/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('template/dist/js/custom.min.js')}}"></script>
    <script src="{{asset('template/dist/js/moment.js')}}"></script>
    
    
    <script src="{{asset('template/assets/libs/chart.js/dist/Chart.min.js')}}"></script>
   
    <script src="{{asset('template/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/dist/js/pages/datatable/datatable-basic.init.js')}}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</body>

</html>
