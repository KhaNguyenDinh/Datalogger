
@foreach ($camera as $key => $value)
<h2>{{$value['name_camera']}}</h2> <br>
<video style="width: 300px; height: 200px; background: black" >{{$value['link_rtsp']}}</video>
@endforeach