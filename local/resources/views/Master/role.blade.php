@extends('Master')
@section('title','role')
@section('action')
<br>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>vanPhong</th>
		<th>nhaMay</th>
		<th>Action</th>
	</tr>
	<tr>
<form method="post" action="{{URL::to('Master/role/postinsert/')}}" enctype="multipart/form-data">
	@csrf
	<td></td>
	<td>
		<select name="id_van_phong" required class="form-control">
			@foreach ($vanPhong as $key => $value)
			<option value="{{$value->id_van_phong}}">{{$value->name_van_phong}}</option>
			@endforeach
		</select>
	</td>
	<td>
		<select name="id_nha_may" required class="form-control">
			@foreach ($nhaMay as $key => $value)
			<option value="{{$value->id_nha_may}}">{{$value->name_nha_may}}</option>
			@endforeach
		</select>
	</td>
	<td><input type="submit"  value="Insert" class="btn btn-primary"></td>
</form>
	</tr>
<form method="post" action="{{URL::to('Master/role/postupdate/')}}" enctype="multipart/form-value">
	@csrf
@foreach ($role as $key => $value)
	<tr>
		<input type="hidden" name="id[]" value="{{$value->id}}" required class="form-control">
		<td>{{$key+1}}</td>
		<td>
			<select name="id_van_phong[]" required class="form-control">
				@foreach ($vanPhong as $key => $value1)
				<option value="{{$value1->id_van_phong}}" <?php if($value->id_van_phong==$value1->id_van_phong){ echo 'selected';} ?> >{{$value1->name_van_phong}}</option>
				@endforeach
			</select>
		</td>
		<td>
			<select name="id_nha_may[]" required class="form-control">
				@foreach ($nhaMay as $key => $value1)
				<option value="{{$value1->id_nha_may}}" <?php if($value->id_nha_may==$value1->id_nha_may){ echo 'selected';} ?> >{{$value1->name_nha_may}}</option>
				@endforeach
			</select>
		</td>
		<td>
			<a href="{{URL::to('Master/role/delete/'.$value->id)}}" class="btn btn-danger"
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
	<input type="submit" value="update" class="btn btn-primary">
</form>
</table>
@stop()


			
			
			
			
			
