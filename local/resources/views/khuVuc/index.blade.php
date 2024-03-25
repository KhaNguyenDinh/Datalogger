@extends('Admin')
@section('title','index')
@section('action')
<?php 
	$nhaMayGetId = $results['nhaMayGetId'];
	$khuVuc = $results['khuVuc'];
	$result_khuVuc = $results['result_khuVuc'];
?>
<center><h1>Of : {{$nhaMayGetId->name_nha_may}}</h1></center>
<a href="{{URL::to('Admin/khuVuc/insert/'.$nhaMayGetId->id_nha_may)}}" class="btn btn-primary">insert</a>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>khuVuc</th>
		<th>folder_TXT</th>
		<th>type</th>
		<th>Loại</th>
		<th>Map</th>
		<th>camera</th>
		<th>alert</th>
		<th>Vị Trí Show</th>
		<th>Action</th>
	</tr>
@foreach ($khuVuc as $key => $value)
	<tr>
		<td>{{$key+1}}</td>
		<td>{{$value->name_khu_vuc}}</td>
		<td>{{$value->folder_txt}}</td>
		<td>{{$value->type}}</td>
		<td>{{$value->loai}}</td>
		<td class="link">{{$value->link_map}}</td>
		<td><a href="{{URL::to('Admin/camera/'.$value->id_khu_vuc)}}">show</a></td>
		<td><a href="{{URL::to('Admin/alert/'.$value->id_khu_vuc)}}">show</a></td>
		<td><a href="{{URL::to('Admin/viTri/'.$value->id_khu_vuc)}}">show</a></td>
		<td>
			<a href="{{URL::to('Admin/khuVuc/update/'.$value->id_khu_vuc)}}" class="btn btn-primary">update</a>
			<a href="{{URL::to('Admin/khuVuc/delete/'.$value->id_khu_vuc)}}" class="btn btn-danger"
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
</table>

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
			<label>{{$key}} ) {{$khuVucGetId['name_khuVuc']}}</label>
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
								if($value['number'] <$value1['minmin'] || $value['number'] > $value1['maxmax']){ $background = 'red'; }
								if(($value['number'] >$value1['minmin'] && $value['number'] < $value1['min'] )
									||($value['number'] >$value1['max'] && $value['number'] < $value1['maxmax'])){ $background = '#ff8400'; }
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
		<h2 style="color: red">{{$nhaMayGetId->name_nha_may}} : NO TXT</h2>
	@endif
	<!-- /////////////// -->
@endforeach
<!-- /// -->
@stop()