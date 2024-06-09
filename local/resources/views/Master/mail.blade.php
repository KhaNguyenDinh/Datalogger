@extends('Master')
@section('title','mail')
@section('action')
<br>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>nhaMay</th>
		<th>email</th>
		<th>Action</th>
	</tr>
	<tr>
	<form method="post" action="{{URL::to('Master/mail/postinsert')}}" enctype="multipart/form-data">
		@csrf
		<td></td>
		<td>
			<select name="id_nha_may" class="form-control">
				@foreach ($nhaMay as $key => $value)
				<option value="{{$value->id_nha_may}}">{{$value->name_nha_may}}</option>
				@endforeach
			</select>
		</td>
		<td><input type="text" name="email" placeholder="email" required class="form-control"></td>
		<td><input type="submit"  value="Insert" class="btn btn-primary"></td>
	</form>
	</tr>
<form method="post" action="{{URL::to('Master/mail/postupdate/')}}" enctype="multipart/form-data">
	@csrf
@foreach ($data as $key => $value)
	<tr>
		<input type="hidden" name="id[]" value="{{$value->id}}" required class="form-control">
		<td>{{$key}}</td>
		
		<td>
			<select name="id_nha_may[]" class="form-control">
				@foreach ($nhaMay as $key => $value1)
				<option value="{{$value1->id_nha_may}}" <?php if($value->id_nha_may==$value1['id_nha_may'] ){ echo 'selected';} ?> >{{$value1->name_nha_may}}
				</option>
				@endforeach
			</select>
		</td>
		<td><input type="text" name="email[]" value="{{$value->email}}" required class="form-control"></td>
		<td>
			<a href="{{URL::to('Master/mail/delete/'.$value->id)}}" class="btn btn-danger" 
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
<input type="submit" value="update" class="btn btn-primary ">
</form>
</table>

@stop()