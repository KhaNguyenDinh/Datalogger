@extends('User')
@section('title','trangChu')
@section('content')
<?php
	$nhaMayGetId = $results['nhaMayGetId'];
	$khuVuc = $results['khuVuc'];
	$result_khuVuc = $results['result_khuVuc'];
	$list_total = $results['list_total'];
	$tab = "__";
	if ($list_total['connect']==0) {
		$hdt = $list_total['total']-$list_total['E']-$list_total['C']-$list_total['error'];
	}else{ $hdt = 0;}
	$color = ['N'=>'green','C'=>'#ff8400','E'=>'red','bt'=>'green','alert'=>'#f8fb7a','error'=>'#fb7a7a','hdt'=>'#37db00','connect'=>'gray','tong'=>'#0d20ff63'];

?>
@if ($result_khuVuc[0]['newTxt']!==null)
<div class="row">
	<div class="col-sm-5" >
		<center>
			<h2>Công ty : {{$nhaMayGetId->name_nha_may}} </h2>
			<div id="donut-chart" style="height: 250px;"></div>	
		</center>
		<b class="tt" style="background: <?=$color['connect']?> "> Mất kết nối <br> {{$list_total['connect']}} </b>
		<b class="tt" style="background: <?=$color['hdt']?> "> Hoạt động tốt<br>{{$hdt}}</b>
		<b class="tt" style="background: <?=$color['C']?> "> Hiệu chuẩn<br>{{$list_total['C']}}</b><br>
		<b class="tt" style="background: <?=$color['error']?> "> Vuợt chuẩn<br>{{$list_total['error']}}</b>
		<b class="tt" style="background: <?=$color['E']?> "> Lỗi thiết bị<br>{{$list_total['E']}}</b>
		<b class="tt" style="background: <?=$color['tong']?> "> Tổng<br>{{$list_total['total']}}</b>
	</div>
	<style type="text/css">
	.tt{
		float: left;
		width: 130px;
		margin: 1px;
		color: white;
		text-align: center;
		border-style: ridge;
	}
	.circle {
	    width: 60px;
	    height: 60px;
	    line-height: 60px;
	    text-align: center;
	    border-radius: 50%;
	    background-color: #ffdf7e;
	}
	</style>

	<script type="text/javascript">
		var color =["<?=$color['connect'] ?>","<?=$color['hdt'] ?>","<?=$color['C'] ?>","<?=$color['error'] ?>","<?=$color['E'] ?>"];
		Morris.Donut({
			element: 'donut-chart',
			data: [
				{label: "Mất kết nối ", value: <?=$list_total['connect']?>},
				{label: "Hoạt động tốt", value: <?=$hdt ?>},
				{label: "Hiệu chuẩn", value: <?=$list_total['C'] ?> },
				{label: "Vượt chuẩn", value: <?=$list_total['error'] ?> },
				{label: "Lỗi thiết bị", value: <?=$list_total['E']?>},
				],
			colors: color,
		});
	</script>
	<!-- /////////// -->
	<div class="col-sm-7">
		<h2>Danh sách trạm theo trạng thái</h2>
		<table class="table table-bordered tbl" style=" font-weight: bold;text-align: center;">
			<tr>
				<th>STT</th>
				<th>Trạm</th>
				<th>Tín hiệu</th>
				<th>Loại</th>
				<th>Trạng thái</th>
				<th>Tình trạng</th>
			</tr>
			<?php 
			foreach ($result_khuVuc as $key => $value) {
				$list_check =$value['list_check'];
			echo "<tr>";
				echo "<td>".$key."</td>";
				echo "<td>".$value['khuVucGetId']['name_khu_vuc']."</td>";
				if ($list_check['connect']==0) {
					$connect = 'Đang kết nối';
					$background = $color['hdt'];
				}else{ 
					$connect = 'Lỗi kết nối';
					$background = $color['connect'];
				}
				echo "<td style='background:".$background."'>".$connect."</td>";
				echo "<td >".$value['khuVucGetId']['loai']."</td>";
				if ($list_check['E']==0) {
					if ($list_check['C']==0) {
						$status = 'Bình thường';
						$background = $color['hdt'];
					}else{ 
						$status = 'Hiêu chuẩn';
						$background = $color['C'];
					}
				}else{ 
					$status = 'Lỗi thiết bị';
					$background = $color['E'];
				}
				echo "<td style='background:".$background."'>".$status."</td>";
				if ($list_check['error']==0) {
					if ($list_check['alert']==0) {
						$tt = 'Trong ngưỡng';
						$background = $color['hdt'];
					}else{ 
						$tt = 'Chuẩn bị vượt';
						$background = $color['alert'];
					}
				}else{ 
					$tt = 'Vượt ngưỡng';
					$background = $color['error'];
				}
				echo "<td style='background:".$background."'>".$tt."</td>";
			echo "</tr>";
			}
			 ?>
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
			@if ($value['list_check']['connect']==1)
				<span style="color: red">Lỗi kết nối  </span>
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
@endif
<style type="text/css">
.export{
	display: none;
}
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
  height: 333px;
}
th{
  position: -webkit-sticky;
  position: sticky;
  top: 0px;
 }
</style>

<script>
$(document).ready(function() {
	var i=0; var reload = <?=$list_total['reload']?>;
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
