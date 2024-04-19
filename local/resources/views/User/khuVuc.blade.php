@extends('User')
@section('title','table')
@section('content')

<?php
	$nhaMayGetId = $results['nhaMayGetId'];
	$khuVucGetId = $results['result_khuVuc'][0]['khuVucGetId'];
	$id_khu_vuc = $khuVucGetId['id_khu_vuc'];

	$camera = $results['camera'];
	$alert = $results['result_khuVuc'][0]['alert'];
	$txt = $results['result_khuVuc'][0]['txt'];
 ?>
@if($action === 'Camera')
    <div class="col-sm-12">@include('teamPlate.camera')</div>
@elseif($action=='map')
<?=$khuVucGetId = $results['result_khuVuc'][0]['khuVucGetId']['name_khu_vuc']; ?> <hr>
<?=$khuVucGetId = $results['result_khuVuc'][0]['khuVucGetId']['link_map']; ?> <hr>
@else
	@include('teamPlate.time')
@endif

@if (!$txt->isEmpty())
<div class="row">
	@if($action === 'Charts')
	    <div class="col-sm-12">@include('teamPlate.graph')</div>
	@elseif($action === 'Tables')
		<div class="col-sm-12">@include('teamPlate.table')</div>
	@elseif($action === 'Alert')
		@include('teamPlate.status')
		<div class="col-sm-12">@include('teamPlate.alert')</div>
	@endif
</div>
@endif


@stop()
