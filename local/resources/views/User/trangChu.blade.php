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
	<div class="col-sm-6">
		<div class="col-sm-4" style="font-size:15px ">
			<center>
				<h3>Tổng số trạm</h3>
				<div class="circle" style="font-size: 40px"><?=$total?></div>
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
			<i class="status sttnorm">---</i> Bình thường <br>
			<i class="status sttcal">---</i> Hiệu chuẩn  <br>
			<i class="status stterror">---</i> Lỗi thiết bị  <br>
			<i class="trongnguong">{{$great}} : Trong ngưỡng</i><br>
			<i class="chuanbi">{{$total_alert}} : Chuẩn bị vượt</i><br>
			<i class="vuotnguong">{{$total_error}} : Vượt ngưỡng</i><br>
			<i class="err_connect">{{$total_error_connect}} : Mất tín hiệu</i><br>

		  
		</div>
		<div class="col-sm-8">
			<div id="donut-chart" style="height: 250px;"></div>
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
		</div>
	</div>

	<div class="col-sm-6">
		<table class="table table-bordered tbl" style=" font-weight: bold;">
			<tr>
				<th>STT</th>
				<th>Trạm</th>
				<!-- <th>Nhà Máy</th> -->
				<th>Loại</th>
				<th>Trạng thái</th>
				<th>Tình trạng</th>
				<th>connect</th>
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
						<i class="trongnguong">Hoạt động tốt</i>
					@else
						<i class="err_connect" >{{$value['connect']}}</i> 
					@endif
				</td>
			</tr>
			@endforeach

		</table>
	</div>
</div>  <!-- end row1 -->


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
			<span>TXT mới nhất : </span>
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
		    	<div class="row">@include('User.teamPlate.graph')</div>
		    	<div class="row">@include('User.teamPlate.status')</div>
		    	<div class="row">@include('User.teamPlate.alert')</div>
		    @endif
	    @endforeach
	</div><!-- End Default Tabs -->
@endif
</div>

<style type="text/css">
.a{
	color: rgba(255, 255, 255, 0);
  border-radius: 50%;
  background: red;
}
.tbl {
  position: relative;
  overflow-y:scroll;
  overflow-x:scroll;
  display:block;
  height: 300px;
}
th{
  position: -webkit-sticky;
  position: sticky;
  top: 0px;
 }
</style>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
$(document).ready(function() {
    setInterval(function() {
		$.ajax({
		    url: "{{ route('checkData', ['id' => $nhaMayGetId->id_nha_may]) }}",  // id_nha_may
		    success: function(data) {
		    	if (data==1) {
		    		window.location.reload(0);
		    	}
		    },
		});

    }, 60000); // Thời gian kiểm tra sự thay đổi
});
</script>
 <script type="text/javascript">
    setTimeout(function() {
        location.reload();
    }, 600000);
</script>

@stop()
