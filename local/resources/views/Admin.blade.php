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
	<nav class="navbar navbar-inverse">
	  <ul class="nav navbar-nav">
	    <li><a href="{{URL::to('Admin/nhaMay')}}">nhaMay</a></li>
	   <li><a href="{{URL::to('Admin/account')}}">account</a></li>
	    <li><a href="{{URL::to('Admin/resetTxt')}}">reset Txt</a></li>
	    <li><a href="{{URL::to('logout')}}">logout</a></li>
	  </ul>
	</nav>
</div>
<div class="col-sm-12">@yield('action')</div>
</body>
</html>

