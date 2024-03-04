<!DOCTYPE html>
<html>
<head>
    <title>blog</title>
    <link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
    <script src="{{asset('public/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/jquery.min.js')}}"></script>
</head>
<tbody>

<div class="col-sm-12">
	<div class="col-sm-11">
		@yield('action')
	</div>
</div>
</body>
</html>
<!-- Trong view 'dulieuTXT.index' -->
<!-- <script>
    // Chuyển hướng sau 5 min
    setTimeout(function() {
        window.location.href = "{{URL::to('dulieuTXT')}}";
    }, 300000); // 1000 miligiây = 1 giây
</script> -->