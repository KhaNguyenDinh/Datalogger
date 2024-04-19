@extends('Master')
@section('title','camera')
@section('action')

<center><h1><a href="{{URL::to('Master/khuVuc/'.$id_nha_may)}}"> Of : {{$name}}</a></h1></center>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>name</th>
		<th>rtsp</th>
		<th>Action</th>
	</tr>
	<tr>
<form method="post" action="{{URL::to('Master/camera/postinsert/'.$id_khu_vuc)}}" enctype="multipart/form-data">
	@csrf
	<td></td>
	<td><input type="text" name="name_camera" placeholder="name_camera" required class="form-control"></td>
	<td><input type="text" name="link_rtsp" placeholder="link_rtsp" required class="form-control"></td>
	<td><input type="submit"  value="Insert"class="btn btn-primary"></td>
</form>
	</tr>
<form method="post" action="{{URL::to('Master/camera/postupdate/'.$id_khu_vuc)}}" enctype="multipart/form-value">
	@csrf
@foreach ($data as $key => $value)
	<tr>
		<input type="hidden" name="id_camera[]" value="{{$value->id_camera}}" required class="form-control">
		<td>{{$key+1}}</td>
		<td><input type="text" name="name_camera[]" value="{{$value->name_camera}}" required class="form-control"></td>
		<td><input type="text" name="link_rtsp[]" value="{{$value->link_rtsp}}" required class="form-control"></td>
		<td>
			<a href="{{URL::to('Master/camera/delete/'.$value->id_camera)}}" class="btn btn-danger" 
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Delete</a>
		</td>
	</tr>
@endforeach
	<input type="submit" value="update" class="btn btn-primary">
</form>
</table>

@stop()

	
	
	

