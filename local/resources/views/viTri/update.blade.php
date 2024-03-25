@extends('Admin')
@section('title','update')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Update</h1></center>
		<form method="post" action="{{URL::to('Admin/viTri/postupdate/'.$data->id)}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id_khu_vuc" value="{{$data->id_khu_vuc}}" required class="form-control">
			<label>Name</label>
			<input type="text" name="name" value="{{$data->name}}" required class="form-control">
			<label>Vị trí</label>
			<input type="number" name="vitri" value="{{$data->vitri}}" required class="form-control">
			<br>
			<input type="submit" value="update" class="btn btn-primary">
		</form>
		<a href="{{URL::to('Admin/viTri/'.$data->id_khu_vuc)}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>


@stop()
