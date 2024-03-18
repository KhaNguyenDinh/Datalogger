@extends('Admin')
@section('title','insert')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Insert</h1></center>
		<form method="post" action="{{URL::to('Admin/camera/postinsert/'.$id_khuVuc)}}" enctype="multipart/form-data">
			@csrf
			<label>camera</label>
			<input type="text" name="name_camera" placeholder="name_camera" required class="form-control">
			<label>rtsp</label>
			<input type="text" name="link_rtsp" placeholder="link_rtsp" required class="form-control">
			<br>
			<input type="submit"  value="Insert"class="btn btn-primary" >
		</form>
		<a href="{{URL::to('Admin/camera/'.$id_khuVuc)}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>


@stop()
