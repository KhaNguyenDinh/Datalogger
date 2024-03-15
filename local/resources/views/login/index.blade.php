<link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
<script src="{{asset('public/bootstrap.min.js')}}"></script>
<script src="{{asset('public/jquery.min.js')}}"></script>
<br><br><br>
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="background: #eff7d9">
		<center><h1>login</h1></center>
		<form method="post" action="{{URL::to('postLogin')}}" enctype="multipart/form-data">
			@csrf
			<label>Name</label>
			<input type="text" name="name_account" placeholder="name" required class="form-control">
			<label>password</label>
			<input type="text" name="pass_account" placeholder="password" required class="form-control">
			<br>
			<input type="submit"  value="login" class="btn btn-primary">
		</form>
	</div>
	<div class="col-sm-4"></div>
</div>
