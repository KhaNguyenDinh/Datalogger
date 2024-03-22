@extends('Admin')
@section('title','insert')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Insert</h1></center>
		<form method="post" action="{{URL::to('Admin/alert/postinsert/'.$id_khuVuc)}}" enctype="multipart/form-data">
			@csrf
			<label>Name</label>
			<input type="text" name="name_alert" placeholder="name_alert" required class="form-control">
			<label>Min Min</label>
			<input type="number" step="0.01" name="minmin" placeholder="minmin" required class="form-control">
			<label>Min</label>
			<input type="number" step="0.01" name="min" placeholder="min" required class="form-control">
			<label>Max</label>
			<input type="number" step="0.01" name="max" placeholder="max" required class="form-control">
			<label>Max Max</label>
			<input type="number" step="0.01" name="maxmax" placeholder="maxmax" required class="form-control">
			<label>Enable</label>
			<select name="enable" required class="form-control">
				<option value="NO">NO</option>
				<option value="YES">YES</option>
			</select>
			<br>
			<input type="submit"  value="Insert" class="btn btn-primary">
		</form>
		<a href="{{URL::to('Admin/alert/'.$id_khuVuc)}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>

@stop()
