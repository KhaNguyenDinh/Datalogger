@extends('User')
@section('title','table')
@section('content')

@include('User.teamPlate.time')

<?php 
$khuVucGetId = $results['khuVucGetId'];
$searchTxt = $results['searchTxt'];
$getTxt = $searchTxt[0]['getTxt'];
$alert=$results['alert'];
 ?>
@if ($getTxt!==null)
	@include('User.teamPlate.tbl')
@else
<h2> NOT TXT</h2>
@endif

@stop()
