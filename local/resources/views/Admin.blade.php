<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
    <script src="{{asset('public/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/jquery.min.js')}}"></script>
</head>
<tbody>

<div class="col-sm-12">
	<nav class="navbar navbar-inverse">
	  <ul class="nav navbar-nav">
	  	@if(session('level')=='Master')
	    <li><a href="{{URL::to('Admin/nhamay')}}">nha May</a></li>
	    <li><a href="{{URL::to('Admin/account')}}">account</a></li>
	    <li><a href="{{URL::to('Admin/resetTxt')}}">reset Txt</a></li>
	    @endif
	    <li><a href="{{URL::to('Admin/show/0')}}">Show</a></li>
	    <li><a href="{{URL::to('logout')}}">logout</a></li>
	  </ul>
	</nav>
</div>
<div class="col-sm-12">@yield('action')</div>
</body>
</html>

