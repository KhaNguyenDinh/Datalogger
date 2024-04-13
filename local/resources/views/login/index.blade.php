<link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
<script src="{{asset('public/bootstrap.min.js')}}"></script>
<script src="{{asset('public/jquery.min.js')}}"></script>

<img class="image" src="{{asset('public/assets/img/nen2.jpg')}}" alt="">
<div class="row show">
	<div class="col-sm-4"></div>
	<div class="col-sm-4" style="border-radius: 10px;">
		<center>
			<br>
			<img class="show_logo" src="{{asset('public/assets/img/logo_remove.png')}}" alt="">
			<h2 style="color: blue" >PHẦN MỀM QUẢN LÝ DỮ LIỆU QUAN TRẮC TỰ ĐỘNG </h2>
		</center>

		<!-- <center><h1>login</h1></center> -->
		<form method="post" action="{{URL::to('postLogin')}}" enctype="multipart/form-data">
			@csrf
			<!-- <label>Name</label> -->
			<!-- <br> -->
			<input type="text" name="name_account" placeholder="name" required class="form-control">
			<br>
			<!-- <label>password</label> -->
			<input type="password" name="pass_account" placeholder="password" required class="form-control">
			<br>
			<input type="submit"  value="ĐĂNG NHẬP" style="width: 100%" class="btn btn-primary">
			<br>
			<h5 style="font-size: 10px;color: white">TRUNG TÂM PHÂN TÍCH VÀ MÔI TRƯỜNG</h5>
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