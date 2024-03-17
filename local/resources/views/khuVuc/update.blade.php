@extends('Admin')
@section('title','update')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Update</h1></center>
		<form method="post" action="{{URL::to('Admin/khuVuc/postupdate/'.$data->id_khuVuc)}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id_nhaMay" value="{{$data->id_nhaMay}}" required class="form-control">
			<label>Name Khu Vuc</label>
			<input type="text" name="name_khuVuc" value="{{$data->name_khuVuc}}" required class="form-control">
			<label>Foder TXT</label>
			<!-- <div class="form-control">{{$data->folder_TXT}}</div> -->
			<label>nước thải / khí thải </label>
			<select name="nuoc_khi" required class="form-control">
				<option value="Nước Thải" <?php if($data->nuoc_khi=='Nước Thải'){ echo 'selected';} ?>>Nước Thải</option>
				<option value="Khí Thải" <?php if($data->nuoc_khi=='Khí Thải'){ echo 'selected';} ?>>Khí Thải</option>
			</select>
			<br>
			<input type="submit" value="update">
		</form>
		<a href="{{URL::to('Admin/khuVuc/'.$data->id_nhaMay)}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>


@stop()
