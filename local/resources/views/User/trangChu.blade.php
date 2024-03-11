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


$currentDateTime = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
$formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$formattedDateTime);
$date2 = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s",strtotime($time)));

$interval = $date1->diff($date2);
// echo $interval->format('%R%a ngày %H giờ %i phút %S giây');
$dulieu = "";
if ($interval->y > 0) {$dulieu = "Mất dữ liệu";
} elseif($interval->m > 0) {$dulieu = "Mất dữ liệu";
} elseif($interval->d > 0) {$dulieu = "Mất dữ liệu";
} elseif($interval->h > 0) {$dulieu = "Mất dữ liệu";
} elseif($interval->i > 30) {$dulieu = "Mất dữ liệu";}

			$data = $newTxt->data;
			$arrayData = json_decode($data, true);
		}
	?>

	@if($arrayData!==null)
		<table class="table table-bordered">
			<div style="display: flex;" ><label>{{$khuVucGetId['name_khuVuc']}}</label> <h3 style="color: red">{{$dulieu}}</h3> </div>
			<tr>
				<th>New Time</th>
				@foreach ($arrayData as $key => $value)
				<th>{{$value['name']}}</th>
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
				<td style="background: {{$background}};">
					<div style="display: flex;">
						{{$value['number']}} <div id="status" style="background: {{$status}}"></div>
					</div>
				</td>
				@endforeach
			</tr>
		</table>
	@else
		<h2>{{$nhaMayGetId->name_nhaMay}} NO TXT</h2>
	@endif
	<!-- /////////////// -->
@endforeach

<!-- <script>
    setTimeout(function() {
        window.location.href = "{{URL::to('User/loadTxtNhaMay/'.$nhaMayGetId->id_nhaMay)}}";
    }, 300000);
</script> -->

<!-- <a href="{{ route('export.number') }}">Export Number to USB</a> -->


<script type="text/javascript">
	setTimeout(function(){
	   window.location.reload(0);
	}, 300000);
</script>


@stop()

<style type="text/css">

#status{
  width: 8px;
  height: 8px;
  border-radius: 50%;
} 
</style>