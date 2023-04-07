<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
      @auth
          AdminLTE  |
      @endauth 
      @yield('title')
  </title>

  <!-- Bootstrap Cdn -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
  <!-- Datatable -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <!-- Video Cdn -->
  <link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet" />
  <link  href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet" />
  <!--DaterangePicker -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <!-- Custom Css -->
  <link rel="stylesheet" href="{{ asset('/backend/css/app.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
    @auth
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      </div>
    @endauth
  <!-- Navbar -->
    @auth
    @include('backend.layouts.navbar')
    @endauth
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @auth
    @include('backend.layouts.aside')
    @endauth
  <!-- /.Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
    @auth
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('backend.layouts.content-header')
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">   
            @yield('content')
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
    @endauth
    @guest
        @yield('content')
    @endguest
  <!-- /.content-wrapper -->

  <!--  footer -->
    @auth
    @include('backend.layouts.footer')
    @endauth
</div>
<!-- ./wrapper -->

<script src="{{ mix('/js/app.js') }}"></script>
<!-- Video -->
<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('/dist/js/pages/dashboard.js') }}"></script> --}}
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<!-- DaterangePicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- Extra Scripts -->
@yield('scripts')
</body>
</html>
