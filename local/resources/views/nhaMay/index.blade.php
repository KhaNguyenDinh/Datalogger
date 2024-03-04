@extends('Admin')
@section('title','index')
@section('action')

<a href="{{URL::to('Admin/nhaMay/insert')}}">insert</a>
<table class="table">
	<tr>
		<th>STT</th>
		<!-- <th>id_nhaMay</th> -->
		<th>name_nhaMay</th>
		<th>link_map</th>
		<th>khu Vuc</th>
		<th>website</th>
		<th></th>
	</tr>
@foreach ($data as $key => $value)
		<tr>
			<td>{{$key}}</td>
			<!-- <td>{{$value->id_nhaMay}}</td> -->
			<td>{{$value->name_nhaMay}}</td>
			<td>{{$value->link_map}}</td>
			<td><a href="{{URL::to('Admin/khuVuc/'.$value->id_nhaMay)}}">show khu Vuc</a></td>
			<td><a href="{{URL::to('Admin/nhaMay/show/'.$value->id_nhaMay)}}">Show</a></td>
			<td>
				<a href="{{URL::to('Admin/nhaMay/update/'.$value->id_nhaMay)}}">update</a>
				<a href="{{URL::to('Admin/nhaMay/delete/'.$value->id_nhaMay)}}">delete</a>
			</td>
		</tr>
@endforeach
</table>

@stop()