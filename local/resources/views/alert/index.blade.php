@extends('Admin')
@section('title','index')
@section('action')

<center><h1><a href="{{URL::to('Admin/khuVuc/'.$id_nha_may)}}">Of : {{$name}}</a></h1></center>

<a href="{{URL::to('Admin/alert/insert/'.$id_khu_vuc)}}" class="btn btn-primary">insert</a>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>name</th>
		<th>minmin</th>
		<th>min</th>
		<th>max</th>
		<th>maxmax</th>
		<th>enable</th>
		<th>Action</th>
	</tr>
@foreach ($data as $key => $value)
	<tr>
		<td>{{$key}}</td>
		<td>{{$value->name_alert}}</td>
		<td>{{$value->minmin}}</td>
		<td>{{$value->min}}</td>
		<td>{{$value->max}}</td>
		<td>{{$value->maxmax}}</td>
		<td>{{$value->enable}}</td>
		<td>
			<a href="{{URL::to('Admin/alert/update/'.$value->id_alert)}}" class="btn btn-primary">update</a>
			<a href="{{URL::to('Admin/alert/delete/'.$value->id_alert)}}" class="btn btn-danger"
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
</table>

@stop()
