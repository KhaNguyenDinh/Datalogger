@extends('Admin')
@section('title','insert')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Insert</h1></center>
		<form method="post" action="{{URL::to('Admin/khuvuc/postinsert/'.$id_nha_may)}}" enctype="multipart/form-data">
			@csrf
			<label>Khu Vuc</label>
			<input type="text" name="name_khu_vuc" placeholder="name" required class="form-control">
			<label>Foder TXT * bắt đầu bằng một chữ cái, và chỉ chứa các ký tự chữ cái, chữ số và dấu gạch dưới *</label>
			<input type="text" name="folder_txt" placeholder="folder" required class="form-control">
			<label>Type</label>
			<select name="type" required class="form-control">
				<option value="ymd">ymd</option>
				<option value="y/m/d">y/m/d</option>
			</select>
			<label>Loại </label>
			<select name="loai" required class="form-control">
				<option value="Nước Thải">Nước Thải</option>
				<option value="Khí Thải">Khí Thải</option>
			</select>
			<label>Map</label>
			<input type="text" name="link_map" placeholder="link_map" required class="form-control">
			<br>
			<input type="submit"  value="Insert" class="btn btn-primary">
		</form>
		<a href="{{URL::to('Admin/khuvuc/'.$id_nha_may)}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>

@stop()
