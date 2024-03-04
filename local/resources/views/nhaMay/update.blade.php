@extends('Admin')
@section('title','update')
@section('action')
<center><h1>Update</h1></center>
<form method="post" action="{{URL::to('Admin/nhaMay/postupdate/'.$data->id_nhaMay)}}" enctype="multipart/form-data">
	@csrf
	<label>Name Nha May</label>
	<input type="text" name="name_nhaMay" value="{{$data->name_nhaMay}}" required class="form-control">
	<label>Link Map</label>
	<input type="text" name="link_map" value="{{$data->link_map}}" required class="form-control">
	<br>
	<input type="submit" value="update">
</form>
<a href="{{URL::to('Admin/nhaMay/')}}">back</a>
@stop()