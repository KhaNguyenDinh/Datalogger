@extends('Admin')
@section('title','insert')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Insert</h1></center>
		<form method="post" action="{{URL::to('Admin/khuVuc/postinsert/'.$id_nhaMay)}}" enctype="multipart/form-data">
			@csrf
			<label>Khu Vuc</label>
			<input type="text" name="name_khuVuc" placeholder="name_khuVuc" required class="form-control">
			<label>Foder TXT * bắt đầu bằng một chữ cái, và chỉ chứa các ký tự chữ cái, chữ số và dấu gạch dưới *</label>
			<input type="text" name="folder_TXT" placeholder="folder_TXT" required class="form-control">
			<label>Type</label>
			<select name="type" required class="form-control">
				<option value="ymd">ymd</option>
				<option value="y/m/d">y/m/d</option>
			</select>
			<label>Loại </label>
			<select name="nuoc_khi" required class="form-control">
				<option value="Nước Thải">Nước Thải</option>
				<option value="Khí Thải">Khí Thải</option>
			</select>
			<br>
			<input type="submit"  value="Insert" class="btn btn-primary">
		</form>
		<a href="{{URL::to('Admin/khuVuc/'.$id_nhaMay)}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>

@stop()
