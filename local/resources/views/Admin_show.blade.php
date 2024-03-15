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
	<div class="col-sm-1">
@foreach ($nhaMay as $key => $value)
<a href="{{URL::to('Admin_show/'.$value->id_nhaMay)}}">{{$value->name_nhaMay}}</a>
<a href="{{URL::to('logout')}}" class=".btn-link">Logout</a>
@endforeach
	<div class="col-sm-11">
		<iframe src="{{URL::to('User/2')}}"></iframe>
	</div>
</div>
</body>
</html>

