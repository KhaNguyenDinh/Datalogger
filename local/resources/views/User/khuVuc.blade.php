@extends('User')
@section('title',$action)
@section('content')

<?php
	$nhaMayGetId = $results['nhaMayGetId'];
	$khuVucGetId = $results['result_khuVuc'][0]['khuVucGetId'];
	$id_khuVuc = $khuVucGetId['id_khuVuc'];

	$camera = $results['camera'];
	$alert = $results['result_khuVuc'][0]['alert'];
	$txt = $results['result_khuVuc'][0]['txt'];
 ?>
@if($action === 'Camera')
    <div class="col-sm-12">@include('User.teamPlate.camera')</div>
@elseif($action=='map')
<?=$khuVucGetId = $results['result_khuVuc'][0]['khuVucGetId']['name_khuVuc']; ?> <hr>
<?=$khuVucGetId = $results['result_khuVuc'][0]['khuVucGetId']['link_map']; ?> <hr>
@else
	@include('User.teamPlate.time')
@endif

@if (!$txt->isEmpty())
<div class="row">
	@if($action === 'Charts')
	    <div class="col-sm-12">@include('User.teamPlate.graph')</div>
	@elseif($action === 'Tables')
		<div class="col-sm-12">@include('User.teamPlate.table')</div>
	@elseif($action === 'Alert')
		<div class="col-sm-12">@include('User.teamPlate.alert')</div>
	@endif
</div>
@endif

@stop()
