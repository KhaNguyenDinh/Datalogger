@extends('Admin')
@section('title','index')
@section('action')

<center><h1><a href="{{URL::to('Admin/khuVuc/'.$id_nhaMay)}}"> Of : {{$name}}</a></h1></center>

<a href="{{URL::to('Admin/camera/insert/'.$id_khuVuc)}}">insert</a>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>name_camera</th>
		<th>link_rtsp</th>
		<th>Action</th>
	</tr>
@foreach ($data as $key => $value)
	<tr>
		<td>{{$key}}</td>
		<td>{{$value->name_camera}}</td>
		<td>{{$value->link_rtsp}}</td>
		<td>
			<a href="{{URL::to('Admin/camera/update/'.$value->id_camera)}}">update</a>
			<a href="{{URL::to('Admin/camera/delete/'.$value->id_camera)}}">delete</a>
		</td>
	</tr>
@endforeach
</table>

@stop()
