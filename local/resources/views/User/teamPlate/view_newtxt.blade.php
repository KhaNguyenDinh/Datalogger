<div class="col-sm-12 view_home">
<?php 
$newTxt = $result_khuVuc[0]['newTxt'];
$alert = $result_khuVuc[0]['alert'];
$viTri = $result_khuVuc[0]['viTri'];
$arrayData = json_decode($newTxt->data, true);
$list_alert = [];
if ($alert) {
	foreach ($alert as $key => $value_alert) {
		if ($value_alert['enable']=="YES") {
			$list_alert[$value_alert['name_alert']]=$value_alert;
		}
	}
}
$list_key=[];
foreach ($viTri as $key => $value) {
	foreach ($arrayData as $key1 => $value1) {
		if ($value1['name']==$value['name']) {
			array_push($list_key,$key1);
		}
	}
}

foreach ($arrayData as $key1 => $value1) {
	$push="NO";
	foreach ($list_key as $key => $value) {
		if ($value==$key1) {
			$push="YES";
		}
	}
	if ($push=="NO") {
		array_push($list_key,$key1);
	}
}
foreach ($list_key as $key => $value) {
	$value1=$arrayData[$value];
	$TrangThai= "trongnguong";$status = "sttnorm";
	if (array_key_exists($value1['name'], $list_alert)) {
		$value2 = $list_alert[$value1['name']];
		$view_tt="Giới hạn: <".$value2['min']." , > ".$value2['max'];
		if ($value1['number']<$value2['minmin']||$value1['number']>$value2['maxmax']) {
			$TrangThai="vuotnguong";
		}elseif ($value1['number']<$value2['min']||$value1['number']>$value2['max']) {
			$TrangThai="chuanbi";
		}
	}else{
		$view_tt="Giới hạn: Không giới hạn";
	}
	switch ($value1['status']) {
		case 1:$status = 'sttcal';break;
		case 2:$status = 'stterror';break;
	} 	?>

	<div class="view col-sm-3 <?=$TrangThai ?>">
		<div class="row1 top">
			<div class="name">{{$value1['name']}}</div>
			<div class="stt <?=$status ?>"></div>
		</div>
		<div class="row1">
			<div class="number">{{number_format($value1['number'],2)}}</div>
			<div class="unit">{{$value1['unit']}}</div>
		</div>
		<div class="row1" style="font-weight: 100; font-size: 10px">{{$view_tt}}</div>
		
	</div>
<?php }	?>
</div>


<style type="text/css">
.view_home{
	display: flex;
	flex-wrap: wrap;
}
.row1{
	display: flex;
	justify-content: space-between;
}
.top{
	padding-top: 5px;
}

.view{
	border-radius:10px;
	border: 5px solid white;

}
.name{
	color: blue;
	text-align: left;
	font-weight: bold;
	font-size: 20px;
	margin: 0px 0px 0px 0px; 
}
.stt{
	text-align: center;
	z-index: 99;
	width: 25px;
	height: 25px;
	border-radius: 50%;
}
.number{
	font-size: 35px;
	text-align: left;
	font-weight: initial;
	color: #0a7d19;
}
.unit{
	font-weight: 100;
	font-size: 15px
}
</style>