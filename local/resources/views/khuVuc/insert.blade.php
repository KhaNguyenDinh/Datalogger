@extends('Admin')
@section('title','insert')
@section('action')
<center><h1>Insert</h1></center>
<form method="post" action="{{URL::to('Admin/khuVuc/postinsert/'.$id_nhaMay)}}" enctype="multipart/form-data">
	@csrf
	<label>name Khu Vuc</label>
	<input type="text" name="name_khuVuc" placeholder="name_khuVuc" required class="form-control">
	<label>Foder TXT * bắt đầu bằng một chữ cái, và chỉ chứa các ký tự chữ cái, chữ số và dấu gạch dưới *</label>
	<input type="text" name="folder_TXT" placeholder="folder_TXT" required class="form-control">
	<label>Type</label>
	<select name="type" required class="form-control">
		<option value="ymd">ymd</option>
		<option value="y/m/d">y/m/d</option>
	</select>
	<br>
	<input type="submit"  value="Insert">
</form>
<a href="{{URL::to('Admin/khuVuc/'.$id_nhaMay)}}">back</a>
@stop()
