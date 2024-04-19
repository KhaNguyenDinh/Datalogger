@extends('Master')
@section('title','viTri')
@section('action')

<center><h1><a href="{{URL::to('Master/khuVuc/'.$khuVuc->id_nha_may)}}">Of : {{$khuVuc->name_khu_vuc}}</a></h1></center>

<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>name</th>
		<th>vị Trí</th>
		<th>Action</th>
	</tr>
	<tr>
<form method="post" action="{{URL::to('Master/viTri/postinsert/'.$khuVuc->id_khu_vuc)}}" enctype="multipart/form-data">
	@csrf
	<td></td>
	<td><input type="text" name="name" required class="form-control"></td>
	<td><input type="number" step="1" name="vitri" required class="form-control"></td>
	<td><input type="submit"  value="Insert" class="btn btn-primary"></td>
</form>
	</tr>
<form method="post" action="{{URL::to('Master/viTri/postupdate/'.$khuVuc->id_khu_vuc)}}" enctype="multipart/form-value">
	@csrf
@foreach ($data as $key => $value)
	<tr>
		<input type="hidden" name="id[]" value="{{$value->id}}" required class="form-control">
		<td>{{$key+1}}</td>
		<td><input type="text" name="name[]" value="{{$value->name}}" required class="form-control"></td>
		<td><input type="number" name="vitri[]" value="{{$value->vitri}}" required class="form-control"></td>
		<td>
			<a href="{{URL::to('Master/viTri/delete/'.$value->id)}}" class="btn btn-danger"
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
	<input type="submit" value="update" class="btn btn-primary">
</form>
</table>

@stop()

			
			
			
