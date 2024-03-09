@extends('Admin')
@section('title','insert')
@section('action')
<center><h1>Insert</h1></center>
<form method="post" action="{{URL::to('Admin/camera/postinsert/'.$id_khuVuc)}}" enctype="multipart/form-data">
	@csrf
	<label>name_camera</label>
	<input type="text" name="name_camera" placeholder="name_camera" required class="form-control">
	<label>link_rtsp</label>
	<input type="text" name="link_rtsp" placeholder="link_rtsp" required class="form-control">
	<br>
	<input type="submit"  value="Insert">
</form>
<a href="{{URL::to('Admin/camera/'.$id_khuVuc)}}">back</a>
@stop()
