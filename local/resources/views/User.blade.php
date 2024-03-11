<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <!-- Favicons -->
  <link href="{{asset('public/assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('public/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">

</head>

<body>
<?php 
$nhaMayGetId = $results['nhaMayGetId'];
$khuVuc = $results['khuVuc'];
$tab = "__";
 ?>


<?php if (!isset($action)) {
  $action= 'Dashboard';
} ?>
  <!-- ======= Header ======= -->
@include('User.header')
  <!-- ======= Sidebar_menu ======= -->
@include('User.sidebar')
  <!-- main -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>{{$action}}</h1>
    </div><!-- End Page Title -->
    @if($action=='Tables'|| $action=='Dashboard')
    <div style="display: flex;justify-content: flex-end;align-items: center;">
      <i class="status" style="background: green"></i>Norm <div class="transparent">{{$tab}}</div> 
      <i class="status" style="background: #ff8400"></i>Calib <div class="transparent">{{$tab}}</div>
      <i class="status" style="background: red"></i>Error <div class="transparent">{{$tab}}</div>
      
      <i class="background" style="background: white"></i>Hoạt động tốt <div class="transparent">{{$tab}}</div>
      <i class="background" style="background: #ff8400"></i>Vượt tiêu chuẩn {{$results['nhaMayGetId']->name_nhaMay}} <div class="transparent">{{$tab}}</div>
      <i class="background" style="background: red"></i>Vượt tiêu chuẩn QCVN40 <div class="transparent">{{$tab}}</div>
      
    </div>
    @endif

    <section class="section dashboard">

      <div class="row">@yield('content')</div>
    </section>

  </main><!-- End #main -->
<!-- yield('content') -->

  <!-- Vendor JS Files -->
  <script src="{{asset('public/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('public/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('public/assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('public/assets/js/main.js')}}"></script>

</body>

</html>


<style type="text/css">
.transparent {
            color: rgba(255, 255, 255, 0);
        }
.background{
  width: 20px;
  height: 20px;
} 
.status{
  width: 15px;
  height: 15px;
  border-radius: 50%;
} 
*{
  font-family: Arial, sans-serif;
}
</style>