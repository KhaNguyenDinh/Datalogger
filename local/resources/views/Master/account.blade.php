@extends('Master')
@section('title','account')
@section('action')
<br>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>name</th>
		<th>Password</th>
		<th>nhaMay</th>
		<th>level</th>
		<th>Action</th>
	</tr>
	<tr>
	<form method="post" action="{{URL::to('Master/account/postinsert')}}" enctype="multipart/form-data">
		@csrf
		<td></td>
		<td><input type="text" name="name_account" placeholder="name" required class="form-control"></td>
		<td><input type="text" name="pass_account" placeholder="password" required class="form-control"></td>
		<td>
			<select name="id_nha_may" class="form-control">
				@foreach ($nhaMay as $key => $value)
				<option value="{{$value->id_nha_may}}">{{$value->name_nha_may}}</option>
				@endforeach
			</select>
		</td>
		<td>
			<select name="level" class="form-control">
				<option value="View">View</option>
				<option value="User">User</option>
				<option value="Admin">Admin</option>
				<option value="office">office</option>
			</select>
		</td>
		<td><input type="submit"  value="Insert" class="btn btn-primary"></td>
	</form>
	</tr>
<form method="post" action="{{URL::to('Master/account/postupdate/')}}" enctype="multipart/form-data">
	@csrf
@foreach ($data as $key => $value)
	<tr>
		<input type="hidden" name="id_account[]" value="{{$value->id_account}}" required class="form-control">
		<td>{{$key}}</td>
		<td><input type="text" name="name_account[]" value="{{$value->name_account}}" required class="form-control"></td>
		<td><input type="text" name="pass_account[]" value="{{$value->pass_account}}" required class="form-control"></td>
		<td>
			<select name="id_nha_may[]" class="form-control">
				@foreach ($nhaMay as $key => $value1)
				<option value="{{$value1->id_nha_may}}" <?php if($value->id_nha_may==$value1['id_nha_may'] ){ echo 'selected';} ?> >{{$value1->name_nha_may}}
				</option>
				@endforeach
			</select>
		</td>
		<td>
			<select name="level[]" class="form-control">
				<option value="View" >View</option>
				<option value="User" <?php if($value->level=='User' ){ echo 'selected';} ?>>User</option>
				<option value="Admin" <?php if($value->level=='Admin' ){ echo 'selected';} ?>>Admin</option>
				<option value="office" <?php if($value->level=='office' ){ echo 'selected';} ?>>office</option>
			</select>
		</td>
		<td>
			<a href="{{URL::to('Master/account/delete/'.$value->id_account)}}" class="btn btn-danger" 
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
<input type="submit" value="update" class="btn btn-primary ">
</form>
</table>

@stop()