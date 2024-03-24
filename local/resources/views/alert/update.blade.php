@extends('Admin')
@section('title','update')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Update</h1></center>
		<form method="post" action="{{URL::to('Admin/alert/postupdate/'.$data->id_alert)}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id_khu_vuc" value="{{$data->id_khu_vuc}}" required class="form-control">
			<label>Name</label>
			<input type="text" name="name_alert" value="{{$data->name_alert}}" required class="form-control">
			<label>Min Min</label>
			<input type="number" name="minmin" value="{{$data->minmin}}" required class="form-control">
			<label>Min</label>
			<input type="number" name="min" value="{{$data->min}}" required class="form-control">
			<label>Max</label>
			<input type="number" name="max" value="{{$data->max}}" required class="form-control">
			<label>Max Max</label>
			<input type="number" name="maxmax" value="{{$data->maxmax}}" required class="form-control">
			<label>Enable</label>
			<select name="enable" class="form-control">
				<option value="NO" <?php if($data->enable=='NO'){ echo 'selected';} ?>>NO</option>
				<option value="YES" <?php if($data->enable=='YES'){ echo 'selected';} ?>>YES</option>
			</select>
			<br>
			<input type="submit" value="update" class="btn btn-primary">
		</form>
		<a href="{{URL::to('Admin/alert/'.$data->id_khu_vuc)}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>


@stop()
