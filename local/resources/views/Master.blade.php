<!DOCTYPE html>
<html>
<head>
    <title>Master</title>
	<link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>
<tbody>

<div class="col-sm-12">
	<!-- <nav class="navbar navbar-inverse"> -->
	  <ul class="nav nav-tabs">
	  	@if(session('level')=='Master')
	    <li><a href="{{URL::to('Master/nhaMay')}}">nhaMay</a></li>
	    <li><a href="{{URL::to('Master/account')}}">account</a></li>
	    <li><a href="{{URL::to('Master/vanPhong')}}">vanPhong</a></li>
	    <li><a href="{{URL::to('Master/role')}}">role</a></li>
	    <li><a href="{{URL::to('Master/resetTxt')}}">reset Txt</a></li>
	    @endif
	    <li><a href="{{URL::to('Master/show/0')}}">Show</a></li>
	    <li><a href="{{URL::to('logout')}}">logout</a></li>
	  </ul>
	<!-- </nav> -->
</div>
<br>
<div class="col-sm-12">@yield('action')</div>
</body>
</html>

<style type="text/css">
.link{
	white-space: nowrap; /* ngăn ngừa ngắt dòng */
	overflow: hidden;
	text-overflow: ellipsis; /* thêm dấu ba chấm khi chuỗi quá dài */
	max-width: 100px; /* độ rộng tối đa của ô */
}
</style>