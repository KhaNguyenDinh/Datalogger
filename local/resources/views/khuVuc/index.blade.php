@extends('Admin')
@section('title','index')
@section('action')

 <?php 
$id_nhaMay = $results['nhaMayGetId']->id_nhaMay;
$name = $results['nhaMayGetId']->name_nhaMay;
$khuVuc = $results['khuVuc'];
$txt_khuVuc = $results['txt_khuVuc'];
  ?>
<center><h1>Nha May : {{$name}}</h1></center>
<a href="{{URL::to('Admin/khuVuc/insert/'.$id_nhaMay)}}">insert</a>
<table class="table">
	<tr>
		<th>STT</th>
		<th>name_khuVuc</th>
		<th>folder_TXT</th>
		<th>type</th>
		<th>show alert</th>
		<th></th>
	</tr>
@foreach ($khuVuc as $key => $value)
	<tr>
		<td>{{$key}}</td>
		<td>{{$value->name_khuVuc}}</td>
		<td>{{$value->folder_TXT}}</td>
		<td>{{$value->type}}</td>
		<td><a href="{{URL::to('Admin/alert/'.$value->id_khuVuc)}}">show canh bao</a></td>
		<td>
			<a href="{{URL::to('Admin/khuVuc/update/'.$value->id_khuVuc)}}">update</a>
			<a href="{{URL::to('Admin/khuVuc/delete/'.$value->id_khuVuc)}}">delete</a>
		</td>
	</tr>
@endforeach
</table>

<!-- ////////////////////////// -->
@foreach ($txt_khuVuc as $key => $value)
	<?php
		$khuVucGetId = $value['khuVucGetId'];
		$alert = $value['alert'];
		$time = $value['time'];
		$getTxt = $value['getTxt'];
	?>
	@if ($getTxt!==null)
		<table class="table table-bordered">
			<label>{{$khuVucGetId->name_khuVuc}}</label>
			<tr>
				<th>Time New</th>
				@foreach ($getTxt as $key => $value)
				<th>{{$value->name}} <br> ({{$value->unit}})</th>
				@endforeach
			</tr>
			<tr>
				<td>{{$time}}</td>
				@foreach ($getTxt as $key => $value)
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
				<td style="color: <?=$status?>; background: <?=$background ?> ">{{$value->number}}</td>
				@endforeach
			</tr>
		</table>
	@else
	<h2>{{$khuVucGetId->name_khuVuc}} NOT TXT</h2>
	@endif

@endforeach



@stop()
