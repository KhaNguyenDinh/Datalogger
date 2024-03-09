@extends('User')
@section('title','table')
@section('content')
<?php
	$khuVucGetId = $results['result_khuVuc'][0]['khuVucGetId'];
	$id_khuVuc = $khuVucGetId['id_khuVuc'];
	$alert = $results['result_khuVuc'][0]['alert'];
	$txt = $results['result_khuVuc'][0]['txt'];
 ?>

	@include('User.teamPlate.time')
	@if (!$txt->isEmpty())
	<div class="row">
		<div class="col-sm-12">@include('User.teamPlate.graph')</div>
		<div class="col-sm-12">@include('User.teamPlate.tbl')</div>
	</div>
	@else <h2>No TXT</h2>
	@endif
@stop()
