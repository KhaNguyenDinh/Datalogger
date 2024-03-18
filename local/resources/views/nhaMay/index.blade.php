@extends('Admin')
@section('title','index')
@section('action')

<a href="{{URL::to('Admin/nhaMay/insert')}}" class="btn btn-primary">insert</a>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>nhaMay</th>
		<th>link map</th>
		<th>khu Vuc</th>
		<th>Action</th>
	</tr>
@foreach ($data as $key => $value)
		<tr>
			<td>{{$key}}</td>
			<td>{{$value->name_nhaMay}}</td>
			<td style="max-width: 20px; overflow: hidden; text-overflow: ellipsis;">{{$value->link_map}}</td>
			<td><a href="{{URL::to('Admin/khuVuc/'.$value->id_nhaMay)}}">Show</a></td>
			</td>
			<td>
				<a href="{{URL::to('Admin/nhaMay/update/'.$value->id_nhaMay)}}" class="btn btn-primary">update</a>
				<a href="{{URL::to('Admin/nhaMay/delete/'.$value->id_nhaMay)}}" class="btn btn-danger"
					onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
			</td>
		</tr>
@endforeach
</table>

@stop()