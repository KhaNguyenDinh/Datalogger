@extends('Admin')
@section('title','insert')
@section('action')

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>Insert</h1></center>
		<form method="post" action="{{URL::to('Admin/nhaMay/postinsert')}}" enctype="multipart/form-data">
			@csrf
			<label>Name Nha May</label>
			<input type="text" name="name_nhaMay" placeholder="name_nhaMay" required class="form-control">
			<label>Link Map</label>
			<input type="text" name="link_map" placeholder="link_map" required class="form-control">
			<br>
			<input type="submit"  value="Insert"class="btn btn-primary">
		</form>
		<a href="{{URL::to('Admin/nhaMay/')}}" class="btn btn-primary">back</a>
	</div>
	<div class="col-sm-4"></div>
</div>


@stop()