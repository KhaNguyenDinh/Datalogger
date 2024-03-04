@if(isset($startTime))
<form method="post" action="{{URL::to('User/postExportExecel/'.$id_khuVuc)}}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="startTime" value="{{$startTime}}">
	<input type="hidden" name="endTime" value="{{$endTime}}">
	<input type="submit"  value="Export">
</form>
@endif

<table class="table table-bordered">
	<tr>
		<th>Time</th>
		@foreach ($getTxt as $key => $value)
		<th>{{$value->name}} <br> {{$value->unit}}</th>
		@endforeach
	</tr>
	@foreach ($searchTxt as $key => $txt)
	<tr>
		<td>{{$txt['time']}}</td>
		@foreach ($txt['getTxt'] as $key => $value)
<?php 
$status = 'green'; $background='white';
if ($alert!==null) {
	foreach ($alert as $key1 => $value1) {
		if ($value1->name==$value->name && $value1->enable=='YES') {
			if($value->number<=$value1->minmin || $value->number>= $value1->maxmax){ $background = 'red';break; }
			elseif($value->number >$value1->min && $value->number < $value1->max){ $background = 'white';break; }
			else{ $background = '#ff8400'; break;}
		}
	}
}
switch ($value->status) {
	case 0:$status = 'green';break;
	case 1:$status = '#ff8400';break;
	case 2:$status = 'red';break;
}
 ?>
			<td style="color: <?=$status?>; background: <?=$background ?>" >{{$value->number}}</td>
		@endforeach
	</tr>
	@endforeach
</table>
