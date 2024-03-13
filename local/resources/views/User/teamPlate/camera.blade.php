
@foreach ($camera as $key => $value)
<h2>{{$value['name_camera']}}</h2> <br>
<iframe src="https://live.cae.vn/image?name={{$value['name_camera']}}"
        width="300" height="300" frameborder="0" allowfullscreen></iframe>
@endforeach