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
	<label>nước thải / khí thải </label>
	<select name="nuoc_khi" required class="form-control">
		<option value="nuocThai" <?php if($data->nuoc_khi=='nuocThai'){ echo 'selected';} ?>>nuocThai</option>
		<option value="khiThai" <?php if($data->nuoc_khi=='khiThai'){ echo 'selected';} ?>>khiThai</option>
	</select>
	<br>
	<input type="submit" value="update">
</form>
<a href="{{URL::to('Admin/khuVuc/'.$data->id_nhaMay)}}">back</a>
@stop()

	<label>nước thải / khí thải </label>
	<select name="nuoc_khi" required class="form-control">
		<option value="nuocThai">nuocThai</option>
		<option value="khiThai">khiThai</option>
	</select>