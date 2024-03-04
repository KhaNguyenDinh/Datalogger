<link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
<script src="{{asset('public/bootstrap.min.js')}}"></script>
<script src="{{asset('public/jquery.min.js')}}"></script>

<center><h1>Update</h1></center>
<form method="post" action="{{URL::to('User/postUpdate/'.$id_account)}}" enctype="multipart/form-data">
	@csrf
	<label>Name Account</label>
	<input type="text" name="new_name_account" required class="form-control">
	<label>pass word</label>
	<input type="text" name="pass_account" required class="form-control">
	<label>new pass word</label>
	<input type="text" name="new_pass_account" required class="form-control">
	<br>
	<input type="submit" value="update">
</form>
