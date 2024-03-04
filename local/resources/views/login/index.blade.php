<link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
<script src="{{asset('public/bootstrap.min.js')}}"></script>
<script src="{{asset('public/jquery.min.js')}}"></script>
<center><h1>login</h1></center>
<form method="post" action="{{URL::to('postLogin')}}" enctype="multipart/form-data">
	@csrf
	<label>Name Account</label>
	<input type="text" name="name_account" placeholder="name_account" required class="form-control">
	<label>password Account</label>
	<input type="text" name="pass_account" placeholder="pass_account" required class="form-control">
	<br>
	<input type="submit"  value="login">
</form>
