<!DOCTYPE html>
<html>
<head>
    <title>blog</title>
    <link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
    <script src="{{asset('public/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/jquery.min.js')}}"></script>
</head>
<tbody>

<div class="col-sm-12">
	<!-- <nav class="navbar navbar-inverse"> -->
	  <ul class="nav nav-tabs">
	  	@if(session('level')=='Master')
	    <li><a href="{{URL::to('Admin/nhaMay')}}">nhaMay</a></li>
	    <li><a href="{{URL::to('Admin/account')}}">account</a></li>
	    <li><a href="{{URL::to('Admin/resetTxt')}}">reset Txt</a></li>
	    @endif
	    <li><a href="{{URL::to('Admin/show/0')}}">Show</a></li>
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