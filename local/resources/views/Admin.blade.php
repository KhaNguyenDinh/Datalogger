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
  <script src="{{asset('public/bootstrap.min.js')}}"></script>
  <script src="{{asset('public/jquery.min.js')}}"></script>

  <link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

</head>
<body>
<div class="col-sm-12">
  <!-- <nav class="navbar navbar-inverse"> -->
    <ul class="nav nav-tabs">
      <li><a href="{{URL::to('logout')}}">logout</a></li>
    </ul>
  <!-- </nav> -->
</div>
<br>
  @yield('content')
  <style type="text/css">
    table,tr,th{
    font-weight: bold;
    border: 1px solid #ebebeb;
  }
  </style>
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