@extends('Admin')
@section('title','update')
@section('action')
<center><h1>Update</h1></center>
<form method="post" action="{{URL::to('Admin/camera/postupdate/'.$data->id_camera)}}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="id_khuVuc" value="{{$data->id_khuVuc}}" required class="form-control">
	<label>name_camera</label>
	<input type="text" name="name_camera" value="{{$data->name_camera}}" required class="form-control">
	<label>link_rtsp</label>
	<input type="text" name="link_rtsp" value="{{$data->link_rtsp}}" required class="form-control">
	<input type="submit" value="update">
</form>
<a href="{{URL::to('Admin/camera/'.$data->id_khuVuc)}}">back</a>
@stop()
