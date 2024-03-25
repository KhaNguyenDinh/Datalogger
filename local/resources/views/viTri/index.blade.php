@extends('Admin')
@section('title','index')
@section('action')

<center><h1><a href="{{URL::to('Admin/khuVuc/'.$id_nha_may)}}">Of : {{$name}}</a></h1></center>

<a href="{{URL::to('Admin/viTri/insert/'.$id_khu_vuc)}}" class="btn btn-primary">insert</a>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>name</th>
		<th>vị Trí</th>
		<th>Action</th>
	</tr>
@foreach ($data as $key => $value)
	<tr>
		<td>{{$key+1}}</td>
		<td>{{$value->name}}</td>
		<td>{{$value->vitri}}</td>
		<td>
			<a href="{{URL::to('Admin/viTri/update/'.$value->id)}}" class="btn btn-primary">update</a>
			<a href="{{URL::to('Admin/viTri/delete/'.$value->id)}}" class="btn btn-danger"
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
</table>

@stop()
