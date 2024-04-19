@extends('Master')
@section('title','vanPhong')
@section('action')
<br>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>van Phong</th>
		<th>account</th>
		<th>Action</th>
	</tr>
	<tr>
<form method="post" action="{{URL::to('Master/vanPhong/postinsert')}}" enctype="multipart/form-data">
	@csrf
	<td></td>
	<td><input type="text" name="name_van_phong" placeholder="name" required class="form-control"></td>
	<td>
		<select name="id_account"  class="form-control">
			@foreach ($account as $key => $value)
			<option value="{{$value->id_account}}">{{$value->name_account}}</option>
			@endforeach
		</select>
	</td>
	<td><input type="submit"  value="Insert"class="btn btn-primary"></td>
</form>
	</tr>

<form method="post" action="{{URL::to('Master/vanPhong/postupdate/')}}" enctype="multipart/form-value">
	@csrf
@foreach ($data as $key => $value)
		<tr>
			<input type="hidden" name="id_van_phong[]" value="{{$value->id_van_phong}}" required class="form-control">
			<td>{{$key+1}}</td>
			<td><input type="text" name="name_van_phong[]" value="{{$value->name_van_phong}}" required class="form-control"></td>
			<td>
				<select name="id_account[]"  class="form-control">
					@foreach ($account as $key => $value1)
					<option value="{{$value1->id_account}}" <?php if($value->id_account==$value1->id_account){ echo 'selected';} ?> >{{$value1->name_account}}</option>
					@endforeach
				</select>
			</td>
			<td>
				<a href="{{URL::to('Master/vanPhong/delete/'.$value->id_van_phong)}}" class="btn btn-danger"
					onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
			</td>
		</tr>
@endforeach
	<input type="submit" value="update"class="btn btn-primary">
</form>
</table>

@stop()


