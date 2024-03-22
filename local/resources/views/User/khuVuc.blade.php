@extends('User')
@section('title',$action)
@section('content')

<?php
	$nhamayGetId = $results['nhamayGetId'];
	$khuvucGetId = $results['result_khuvuc'][0]['khuvucGetId'];
	$id_khu_vuc = $khuvucGetId['id_khu_vuc'];
	$camera = $results['camera'];
	$alert = $results['result_khuvuc'][0]['alert'];
	$txt = $results['result_khuvuc'][0]['txt'];
 ?>
@if($action === 'Camera')
    <div class="col-sm-12">@include('User.teamPlate.camera')</div>
@elseif($action=='map')
<?=$khuvucGetId = $results['result_khuvuc'][0]['khuvucGetId']['name_khu_vuc']; ?> <hr>
<?=$khuvucGetId = $results['result_khuvuc'][0]['khuvucGetId']['link_map']; ?> <hr>
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
