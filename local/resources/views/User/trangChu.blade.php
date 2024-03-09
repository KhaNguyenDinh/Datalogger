@extends('User')
@section('title','trangChu')
@section('content')

<?php 
	$nhaMayGetId = $results['nhaMayGetId'];
	$khuVuc = $results['khuVuc'];
	$result_khuVuc = $results['result_khuVuc'];
?>

@foreach ($result_khuVuc as $key => $value)
	<?php
		$khuVucGetId = $value['khuVucGetId'];
		$alert = $value['alert'];
		$newTxt = $value['newTxt'];
		$arrayData=null;
		if ($newTxt!==null) {
			$time = $newTxt->time;
			$data = $newTxt->data;
			$arrayData = json_decode($data, true);
		}
	?>

	@if($arrayData!==null)
		<table class="table table-bordered">
			<label>{{$khuVucGetId['name_khuVuc']}}</label>
			<tr>
				<th>Time</th>
				@foreach ($arrayData as $key => $value)
				<th>{{$value['name']}}<br>{{$value['unit']}} </th>
				@endforeach
			</tr>
			<tr>
				<td>{{$time}}</td>
				@foreach ($arrayData as $key => $value)
				<?php 
					$status = 'green'; $background='white';
					if ($alert!==null) {
						foreach ($alert as $key1 => $value1) {
							if ($value1['name_alert']==$value['name'] && $value1['enable']=="YES") {
								if($value['number']<=$value1['minmin'] || $value['number']>= $value1['maxmax']){ $background = 'red';break; }
								elseif($value['number'] >$value1['min'] && $value['number'] < $value1['max']){ $background = 'white';break; }
								else{ $background = '#ff8400'; break;}
							}
						}
					}
					switch ($value['status']) {
						case 0:$status = 'green';break;
						case 1:$status = '#ff8400';break;
						case 2:$status = 'red';break;
					}
				 ?>
				<th style="color:{{$status}};background: {{$background}}">{{$value['number']}}</th>
				@endforeach
			</tr>
		</table>
	@else
		<h2>{{$nhaMayGetId->name_nhaMay}} NO TXT</h2>
	@endif
	<!-- /////////////// -->
@endforeach


@stop()

