<!DOCTYPE html>
<html>
<head>
    <title>User</title>
    <link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
    <script src="{{asset('public/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/jquery.min.js')}}"></script>
</head>
<tbody>
<?php 
$nhaMayGetId = $results['nhaMayGetId'];
$khuVuc = $results['khuVuc'];
 ?>
<div class="col-sm-12">
    <div class="row">
        Nha May {{$nhaMayGetId->name_nhaMay}}
        <li>
            {{session('name_account')}}
            <a href="{{URL::to('User/update')}}">Update</a>
            <a href="{{URL::to('logout')}}">Logout</a>
        </li>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-2">
            <a href="{{URL::to('/')}}">Logo.icon</a> <br>
            <a href="{{URL::to('User/'.$nhaMayGetId->id_nhaMay)}}">Trang Chu</a>
            <li>Khu Vuc <br>
                @foreach ($khuVuc as $key => $value)
                <a href="{{URL::to('User/khuVuc/'.$value->id_khuVuc)}}">{{$value->name_khuVuc}}</a><br>
                @endforeach
            </li>

        </div>
        <div class="col-sm-10">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>


<script>
    // Chuyển hướng sau ? min
    setTimeout(function() {
        window.location.href = "{{URL::to('User/loadTxtNhaMay/'.$nhaMayGetId->id_nhaMay)}}";
    }, 300000); // 1000 miligiây = 1 giây
</script>

<style>
    table, tr,th,td{
        text-align: center;
    }
</style>