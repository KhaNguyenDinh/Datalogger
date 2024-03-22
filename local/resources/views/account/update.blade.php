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
			<select name="id_nha_may" class="form-control">
				@foreach ($nhamay as $key => $value)
				<option value="{{$value->id_nha_may}}" <?php if($data->id_nha_may==$value['id_nha_may'] ){ echo 'selected';} ?> >{{$value->name_nha_may}}</option>
				@endforeach
			</select>
			<label>level</label>
			<select name="level" class="form-control">
				<option value="View" >View</option>
				<option value="User" <?php if($data->level=='User' ){ echo 'selected';} ?>>User</option>
				<option value="Admin" <?php if($data->level=='Admin' ){ echo 'selected';} ?>>Admin</option>
			</select>
			<br>
			<input type="submit" value="update" class="btn btn-primary">
		</form>
		<a href="{{URL::to('Admin/account/')}}" >back</a>
	</div>
	<div class="col-sm-4"></div>
</div>


@stop()