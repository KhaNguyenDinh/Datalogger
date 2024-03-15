@extends('User')
@section('title','trangChu')
@section('content')

<?php
	$nhaMayGetId = $results['nhaMayGetId'];
	$khuVuc = $results['khuVuc'];
	$result_khuVuc = $results['result_khuVuc'];
	$total = $results['total'];
	$total_error = $results['total_error'];
	$total_alert = $results['total_alert'];
	$total_error_connect = $results['total_error_connect'];
	$great = $total - $total_error - $total_alert;
	$color_great='green'; $color_alert='#ff8400';$color_error="red";$color_connect='gray';
	$tab = "__";
?>


<div class="row">
	<div class="col-sm-5">
		<div class="col-sm-6">
			<center>Tổng số trạm<br><h2>{{$total}}</h2> </center>
			<i class="a" style="background: <?=$color_great ?>">---</i><span>{{$great}} Trong ngưỡng</span><br>
			<i class="a" style="background: <?=$color_alert ?>">---</i><span>{{$total_alert}} Vượt ngưỡng NM </span><br>
			<i class="a" style="background: <?=$color_error ?>">---</i><span>{{$total_error}} Vượt ngưỡng QCVN40</span><br>
			<i class="a" style="background: <?=$color_connect ?>">---</i><span>{{$total_error_connect}} Mất tín hiệu</span><br>
		</div>
		<div class="col-sm-6">
			<div id="donut-chart" style="height: 250px;"></div>
			<script type="text/javascript">
			Morris.Donut({
			    element: 'donut-chart',
			    data: [
			        {label: "Great", value: <?=$great?>},
			        {label: "Alert", value: <?=$total_alert ?>},
			        {label: "Error", value: <?=$total_error ?> },
			        {label: "Connect", value: <?=$total_error_connect?>}
			    ],
			    colors: ['<?=$color_great ?>', '<?=$color_alert ?>','<?=$color_error ?>','<?=$color_connect ?>'],
			});
			</script>
		</div>

	</div>
	<div class="col-sm-7">
		<table class="table table-bordered">
			<tr>
				<th>STT</th>
				<th>Trạm</th>
				<th>Nhà Máy</th>
				<th>Loại</th>
				<th>Trạng thái</th>
				<th>connect</th>
			</tr>
			@foreach ($result_khuVuc as $key => $value)
			<tr>
				<td>{{$key+1}}</td>
				<td>{{$value['khuVucGetId']['name_khuVuc']}}</td>
				<td>{{$nhaMayGetId->name_nhaMay}}</td>
				<td>{{$value['khuVucGetId']['nuoc_khi']}}</td>
				<td>
					@if($value['status']=='norm')
					<i class="a" style="background: <?=$color_great ?>">---</i>hoạt động tốt
					@elseif($value['status']=='alert')
					<i class="a" style="background: <?=$color_alert ?>">---</i>vượt tiêu chuẩn nhà máy
					@elseif($value['status']=='error')
					<i class="a" style="background: <?=$color_error ?>">---</i>vượt tiêu chuẩn QCVN40
					@endif
				</td>
				<td>
					@if($value['connect']=='')
						<i class="a" style="background: green">---</i> hoạt động tốt
					@else
						<i class="a" style="background: <?=$color_connect ?>">---</i>{{$value['connect']}}
					@endif
				</td>
			</tr>
			@endforeach

		</table>
	</div>
</div>
<div class="row">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <ul class="nav nav-tabs">
  	@foreach ($result_khuVuc as $key => $value)
  	<li><a data-toggle="tab" <?php if ($key==0) { echo 'class="active"';} ?> href="#{{$value['khuVucGetId']['name_khuVuc']}}">{{$value['khuVucGetId']['name_khuVuc']}}</a></li>
  	@endforeach
  </ul>

  <div class="tab-content">
  	@foreach ($result_khuVuc as $key => $value)
    <div id="{{$value['khuVucGetId']['name_khuVuc']}}" class="tab-pane fade in active row">
    	<?php 
    	$alert = $value['alert'];
    	$txt = $value['txt'];
    	 ?>
    	<div class="col-sm-12">
    		@include('User.teamPlate.graph')
    	</div>
    	<div class="col-sm-12"> <br><br>
    	@include('User.teamPlate.alert')</div>
    </div>
    @endforeach
  </div>


</div>
<style type="text/css">
.a{
	color: rgba(255, 255, 255, 0);
  border-radius: 50%;
  background: red;
}
</style>
<script type="text/javascript">
setTimeout(function(){
   window.location.reload(0);
}, 300000);
</script>
@stop()
