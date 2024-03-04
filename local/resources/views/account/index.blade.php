@extends('Admin')
@section('title','index')
@section('action')

<a href="{{URL::to('Admin/account/insert')}}">insert</a>
<table class="table">
	<tr>
		<th>STT</th>
		<th>name_account</th>
		<th>name_nhaMay</th>
		<th></th>
	</tr>
@foreach ($data as $key => $value)
		<tr>
			<td>{{$key}}</td>
			<td>{{$value->name_account}}</td>
			<td>{{$value->name_nhaMay}}</td>
			<td>
				<a href="{{URL::to('Admin/account/update/'.$value->id_account)}}">update</a>
				<a href="{{URL::to('Admin/account/delete/'.$value->id_account)}}">delete</a>
			</td>
		</tr>
@endforeach
</table>

@stop()