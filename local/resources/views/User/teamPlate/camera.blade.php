
@foreach ($camera as $key => $value)
<h2>{{$value['name_camera']}}</h2> <br>
<iframe src="https://wss.cordyfoodnt.vn/image?name={{$value['name_camera']}}"
        width="720" height="480" frameborder="0" allowfullscreen></iframe>
@endforeach