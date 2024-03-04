@extends('Admin')
@section('title','update')
@section('action')
<center><h1>Update</h1></center>
<form method="post" action="{{URL::to('Admin/khuVuc/postupdate/'.$data->id_khuVuc)}}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="id_nhaMay" value="{{$data->id_nhaMay}}" required class="form-control">
	<label>Name Khu Vuc</label>
	<input type="text" name="name_khuVuc" value="{{$data->name_khuVuc}}" required class="form-control">
	<label>Foder TXT</label>
	<div class="form-control">{{$data->folder_TXT}}</div>
	<label>Type</label>
	<select name="type" required class="form-control">
		<option value="ymd" <?php if($data->type=='ymd'){ echo 'selected';} ?> >ymd</option>
		<option value="y/m/d" <?php if($data->type=='y/m/d'){ echo 'selected';} ?> >y/m/d</option>
	</select>
	<br>
	<input type="submit" value="update">
</form>
<a href="{{URL::to('Admin/khuVuc/'.$data->id_nhaMay)}}">back</a>
@stop()