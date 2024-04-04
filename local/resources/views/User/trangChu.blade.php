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
	$reload = $results['reload'];
?>
<div class="row" style="width: 120%">
	<center class="col-sm-6" style="font-weight: bold;" >
		<h2>Công ty : {{$nhaMayGetId->name_nha_may}} </h2>
		<div id="donut-chart" style="height: 250px;"></div>
		<h2>Tổng số trạm :{{$total}}</h2>

		<i class="status sttnorm">---</i> Hoat
		<i class="status sttcal">---</i> Hiệu chuẩn  
		<i class="status stterror">---</i> Lỗi thiết bị <br>
		<i class="trongnguong">{{$great}} : Trong ngưỡng</i>
		<i class="chuanbi">{{$total_alert}} : Chuẩn bị vượt</i>
		<i class="vuotnguong">{{$total_error}} : Vượt ngưỡng</i>
		<i class="err_connect">{{$total_error_connect}} : Mất tín hiệu</i>
	</center>
	<style type="text/css">
	.circle {
	    width: 60px;
	    height: 60px;
	    line-height: 60px;
	    text-align: center;
	    border-radius: 50%;
	    background-color: #ffdf7e;
	}
	.err_connect{
		background-image: linear-gradient(-225deg, #def7ea 0%, gray 100%);
	}
	</style>
	<script type="text/javascript">
		Morris.Donut({
			element: 'donut-chart',
			data: [
				{label: "Great", value: <?=$great?>},
				{label: "Alert", value: <?=$total_alert ?>},
				{label: "Error", value: <?=$total_error ?> },
				{label: "Diconnect", value: <?=$total_error_connect?>}
				],
			colors: ['<?=$color_great ?>', '<?=$color_alert ?>','<?=$color_error ?>','<?=$color_connect ?>'],
		});
	</script>
	<!-- /////////// -->
	<div class="col-sm-6">
		<h2>Danh sách trạm theo trạng thái</h2>
		<table class="table table-bordered tbl" style=" font-weight: bold;text-align: center;">
			<tr>
				<th>STT</th>
				<th>Trạm</th>
				<!-- <th>Nhà Máy</th> -->
				<th>Loại</th>
				<th>Trạng thái</th>
				<th>Tình trạng</th>
				<th>Tín hiệu </th>
			</tr>
			@foreach ($result_khuVuc as $key => $value)
			<tr>
				<td>{{$key+1}}</td>
				<td>{{$value['khuVucGetId']['name_khu_vuc']}}</td>
<!-- 				<td>{{$nhaMayGetId->name_nha_may}}</td> -->
				<td>{{$value['khuVucGetId']['loai']}}</td>
				<td>
					@if($value['status']=='norm')
					<i class="status sttnorm">---</i> Bình thường
					@elseif($value['status']=='alert')
					<i class="status sttcal">---</i> Hiệu chuẩn
					@elseif($value['status']=='error')
					<i class="status stterror">---</i> Lỗi thiết bị
					@endif
				</td>
				<td>
					@if($value['TrangThai']=='norm')
					<i class="trongnguong">Trong ngưỡng</i>
					@elseif($value['TrangThai']=='alert')
					<i class="chuanbi">Chuẩn bị vượt</i>
					@elseif($value['TrangThai']=='error')
					<i class="vuotnguong">Vượt ngưỡng</i>
					@endif
				</td>
				<td>
					@if($value['connect']=='')
						<i class="trongnguong">Đang kết nối</i>
					@else
						<i class="err_connect" >{{$value['connect']}}</i> 
					@endif
				</td>
			</tr>
			@endforeach

		</table>
	</div>
</div>  <!-- end row1 -->
<hr>
<h2>TRẠM THEO THÀNH PHẦN MÔI TRƯỜNG</h2>
<div class="row">
	<ul class="nav nav-tabs" id="myTab" role="tablist" >
		@foreach ($result_khuVuc as $key => $value)
		<a  href="{{URL::to('User/'.$nhaMayGetId->id_nha_may.'/'.$key)}}">
			<li class="nav-item" role="presentation">
			  <button class="nav-link <?php if($key==$key_view){echo'active';} ?> " href="{{URL::to('User/'.$nhaMayGetId->id_nha_may.'/'.$key)}}" id="home-tab" data-bs-toggle="tab" type="button" role="tab" aria-controls="home" aria-selected="true">
			  	{{$value['khuVucGetId']['name_khu_vuc']}}
			  </button>
			</li>
		</a>
		@endforeach
	</ul>
	<div class="tab-content pt-2">
<!-- /////////// -->
@if ($value = Arr::first($result_khuVuc))
	<div class="col-sm-12">
		<div style="font-size:30px ">
			@include('User.teamPlate.status')
			<span>Dữ liệu mới nhất : </span>
			<span>{{$value['newTxt']->time}}</span>
			@if ($value['connect']=='Mất tín hiệu')
				<span style="color: red">{{$value['connect']}}</span>
			@endif
			@include('User.teamPlate.view_newtxt')
		</div>
<!-- /////////////////////////		 -->
	  	@foreach ($result_khuVuc as $key => $value)
	  		@if($key==$key_view)
		    	<?php 
		    	$alert = $value['alert'];
		    	$txt = $value['txt'];
		    	 ?>
		    	<div class="row">
		    		<hr><h2>Biểu đồ số liệu 1 giờ</h2>
		    		@include('User.teamPlate.graph')</div>
		    	<div class="row">
		    		<hr><h2> Dữ liệu chi tiết 1 giờ</h2>
		    		@include('User.teamPlate.status')</div>
		    	<div class="row">@include('User.teamPlate.alert')</div>
		    @endif
	    @endforeach
	</div><!-- End Default Tabs -->
@endif
</div>

<style type="text/css">
.export{
	display: none;
}
.a{
	color: rgba(255, 255, 255, 0);
  border-radius: 50%;
  background: red;
}
th{
  position: -webkit-sticky;
  position: sticky;
  top: 0px;
 }
</style>

<script>
$(document).ready(function() {
	var i=0; var reload = <?=$reload ?>;
    setInterval(function() {
		$.ajax({
		    url: "{{ route('checkData', ['id' => $nhaMayGetId->id_nha_may]) }}",  // id_nha_may
		    success: function(data) {
		    	if (data==1) {
		    		window.location.reload(0);
		    	}else{
		    		if (i%10==0 && i!=0 && reload==1) { window.location.reload(0); }
		    		i = i+1;
		    	}
		    },
		});
    }, 60000); // Thời gian kiểm tra sự thay đổi 60s
});
</script>

@stop()
