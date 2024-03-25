@extends('Admin')
@section('title','insert')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Insert</h1></center>
		<form method="post" action="{{URL::to('Admin/viTri/postinsert/'.$id_khu_vuc)}}" enctype="multipart/form-data">
			@csrf
			<label>Name</label>
			<input type="text" name="name" required class="form-control">
			<label>vị trí</label>
			<input type="number" step="1" name="vitri" required class="form-control">
			<br>
			<input type="submit"  value="Insert" class="btn btn-primary">
		</form>
		<a href="{{URL::to('Admin/viTri/'.$id_khu_vuc)}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>

@stop()
