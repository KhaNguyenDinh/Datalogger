@extends('Admin')
@section('title','update')
@section('action')
<center><h1>Update</h1></center>
<form method="post" action="{{URL::to('Admin/account/postupdate/'.$data->id_account)}}" enctype="multipart/form-data">
	@csrf
	<label>Name Account</label>
	<input type="text" name="name_account" value="{{$data->name_account}}" required class="form-control">
	<label>pass word</label>
	<input type="text" name="pass_account" value="{{$data->pass_account}}" required class="form-control">
	<label>Nha May</label>
	<select name="id_nhaMay" class="form-control">
		@foreach ($nhaMay as $key => $value)
		<option value="{{$value->id_nhaMay}}" <?php if($data->id_nhaMay==$value['id_nhaMay'] ){ echo 'selected';} ?> >{{$value->name_nhaMay}}</option>
		@endforeach
	</select>
	<br>
	<input type="submit" value="update">
</form>
<a href="{{URL::to('Admin/account/')}}">back</a>
@stop()