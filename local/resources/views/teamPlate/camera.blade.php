<div style="display: flex;">
@foreach ($camera as $key => $value)
	<div style="padding:30px;">
		<center>{{$value['name_camera']}}</center>
		<iframe src="https://live.cae.vn/image?name={{$value['name_camera']}}"
	        width="400" height="300" frameborder="0" allowfullscreen></iframe>
	</div>
@endforeach
</div>