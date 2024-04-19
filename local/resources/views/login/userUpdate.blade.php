<link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
<script src="{{asset('public/bootstrap.min.js')}}"></script>
<script src="{{asset('public/jquery.min.js')}}"></script>

<img class="image" src="{{asset('public/assets/img/nen2.jpg')}}" alt="">
<div class="row show">
	<div class="col-sm-4"></div>
	<div class="col-sm-4">
		<center>
			<br>
			<img class="show_logo" src="{{asset('public/assets/img/logo_remove.png')}}" alt="">
			<h2 style="color: blue" >PHẦN MỀM QUẢN LÝ DỮ LIỆU QUAN TRẮC TỰ ĐỘNG </h2>
		</center>
		<form method="post" action="{{URL::to('User/user_postUpdate/'.$id_account)}}" enctype="multipart/form-data">
			@csrf<br>
			<input type="text" name="new_name_account" value="{{$name_account}}" required class="form-control"><br>
			<input type="text" name="pass_account"  placeholder="password" required class="form-control"><br>
			<input type="text" name="new_pass_account" placeholder="new password" required class="form-control"><br>
			<input type="submit" value="update" class="btn btn-primary" style="width: 100%"><br>
			<h5 style="font-size: 10px;color: white">TRUNG TÂM PHÂN TÍCH VÀ MÔI TRƯỜNG</h5>
			<a href="/" class="btn btn-primary">Back</a>
		</form>
	</div>
	<div class="col-sm-4"></div>
</div>
<style type="text/css">
	.image{
		position: absolute;
		width: 100%;
		height: 100%;
		z-index: 0;
	}
	.show{
		position: 
		width: 100%;
		height: 100%;
		z-index: 2; 
	}
	.show_logo {
	    opacity: 1;
	}

</style>