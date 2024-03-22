@extends('Admin')
@section('title','update')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Update</h1></center>
		<form method="post" action="{{URL::to('Admin/khuvuc/postupdate/'.$data->id_khu_vuc)}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id_nha_may" value="{{$data->id_nha_may}}" required class="form-control">
			<label>Khu Vuc</label>
			<input type="text" name="name_khu_vuc" value="{{$data->name_khu_vuc}}" required class="form-control">
			<label>Foder TXT</label>
			<!-- <div class="form-control">{{$data->folder_TXT}}</div> -->
			<label>Loại </label>
			<select name="loai" required class="form-control">
				<option value="Nước Thải" <?php if($data->nuoc_khi=='Nước Thải'){ echo 'selected';} ?>>Nước Thải</option>
				<option value="Khí Thải" <?php if($data->nuoc_khi=='Khí Thải'){ echo 'selected';} ?>>Khí Thải</option>
			</select>
			<label>Map</label>
			<input type="text" name="link_map" value="{{$data->link_map}}" required class="form-control">
			<br>
			<input type="submit" value="update">
		</form>
		<a href="{{URL::to('Admin/khuvuc/'.$data->id_nha_may)}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>


@stop()
