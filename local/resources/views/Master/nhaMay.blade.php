@extends('Master')
@section('title','nhaMay')
@section('action')
<br>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>nhaMay</th>
		<th>khu Vuc</th>
		<th>Action</th>
	</tr>
	<tr>
<form method="post" action="{{URL::to('Master/nhaMay/postinsert')}}" enctype="multipart/form-data">
	@csrf
	<td></td>
	<td><input type="text" name="name_nha_may" placeholder="name_nhaMay" required class="form-control"></td>
	<td></td>
	<td><input type="submit"  value="Insert"class="btn btn-primary"></td>
</form>
	</tr>

<form method="post" action="{{URL::to('Master/nhaMay/postupdate/')}}" enctype="multipart/form-value">
	@csrf
@foreach ($data as $key => $value)
		<tr>
			<input type="hidden" name="id_nha_may[]" value="{{$value->id_nha_may}}" required class="form-control">
			<td>{{$key+1}}</td>
			<td><input type="text" name="name_nha_may[]" value="{{$value->name_nha_may}}" required class="form-control"></td>
			<td><a href="{{URL::to('Master/khuVuc/'.$value->id_nha_may)}}">Show</a></td>
			</td>
			<td>
				<a href="{{URL::to('Master/nhaMay/delete/'.$value->id_nha_may)}}" class="btn btn-danger"
					onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
			</td>
		</tr>
@endforeach
	<input type="submit" value="update"class="btn btn-primary">
</form>
</table>

@stop()


