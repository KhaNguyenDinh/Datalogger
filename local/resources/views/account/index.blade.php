@extends('Admin')
@section('title','index')
@section('action')

<a href="{{URL::to('Admin/account/insert')}}" class="btn btn-primary">insert</a>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>name</th>
		<th>name nhaMay</th>
		<th>level</th>
		<th>Action</th>
	</tr>
@foreach ($data as $key => $value)
	<tr>
		<td>{{$key}}</td>
		<td>{{$value->name_account}}</td>
		<td>{{$value->name_nhaMay}}</td>
		<td>{{$value->level}}</td>
		<td>
			<a href="{{URL::to('Admin/account/update/'.$value->id_account)}}" class="btn btn-primary">update</a>
			<a href="{{URL::to('Admin/account/delete/'.$value->id_account)}}" class="btn btn-danger" 
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
</table>

@stop()