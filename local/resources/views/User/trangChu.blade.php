@extends('User')
@section('title','trangChu')
@section('content')

@foreach ($results['txt_khuVuc'] as $key => $value)
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

