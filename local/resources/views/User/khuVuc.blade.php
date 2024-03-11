@extends('User')
@section('title','table')
@section('content')
<?php
	$khuVucGetId = $results['result_khuVuc'][0]['khuVucGetId'];
	$id_khuVuc = $khuVucGetId['id_khuVuc'];

	$camera = $results['camera'];
	$alert = $results['result_khuVuc'][0]['alert'];
	$txt = $results['result_khuVuc'][0]['txt'];

 ?>
	
	@if (!$txt->isEmpty())
	<div class="row">
		@if($action === 'Charts')
			@include('User.teamPlate.time')
		    <div class="col-sm-12">@include('User.teamPlate.graph')</div>
		@elseif($action === 'Tables')
			@include('User.teamPlate.time')
			<div class="col-sm-12">@include('User.teamPlate.tbl')</div>
		@elseif($action === 'Camera')
		    <div class="col-sm-12">@include('User.teamPlate.camera')</div>
		@endif
	</div>
	@else <h2>No TXT</h2>
	@endif
@stop()
