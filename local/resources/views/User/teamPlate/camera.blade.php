<div style="display: flex;">
@foreach ($camera as $key => $value)
	<div style="padding:30px;">
		<iframe src="https://live.cae.vn/image?name={{$value['name_camera']}}"
	        width="400" height="300" frameborder="0" allowfullscreen></iframe>
	     <h2>{{$value['name_camera']}}</h2>
	</div>
@endforeach
</div>