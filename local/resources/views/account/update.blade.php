@extends('Admin')
@section('title','update')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Update</h1></center>
		<form method="post" action="{{URL::to('Admin/account/postupdate/'.$data->id_account)}}" enctype="multipart/form-data">
			@csrf
			<label>Name</label>
			<input type="text" name="name_account" value="{{$data->name_account}}" required class="form-control">
			<label>password</label>
			<input type="text" name="pass_account" value="{{$data->pass_account}}" required class="form-control">
			<label>Nha May</label>
			<select name="id_nhaMay" class="form-control">
				@foreach ($nhaMay as $key => $value)
				<option value="{{$value->id_nhaMay}}" <?php if($data->id_nhaMay==$value['id_nhaMay'] ){ echo 'selected';} ?> >{{$value->name_nhaMay}}</option>
				@endforeach
			</select>
			<label>level</label>
			<select name="level" class="form-control">
				<option value="User" >User</option>
				<option value="Admin" <?php if($data->level=='Admin' ){ echo 'selected';} ?>>Admin</option>
			</select>
			<br>
			<input type="submit" value="update" class="btn btn-primary">
		</form>
		<a href="{{URL::to('Admin/account/')}}" class="btn btn-primary">back</a>
	</div>
	<div class="col-sm-4"></div>
</div>


@stop()