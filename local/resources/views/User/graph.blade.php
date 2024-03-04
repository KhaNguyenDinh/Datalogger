@extends('User')
@section('title','graph')
@section('content')

@include('User.teamPlate.time')

<?php 
$khuVucGetId = $results['khuVucGetId'];
$searchTxt = $results['searchTxt'];
$getTxt = $searchTxt[0]['getTxt'];

 ?>
@if ($getTxt!==null)

<?php 
$data=[];$ykeys=[];$name=[];

foreach ($getTxt as $key => $value) {
  $name=array_merge($name,array($value->name));
}
foreach ($searchTxt as $key => $value) {
  $time = $value['time'];
  foreach ($value['getTxt'] as $key => $value) {
    $ykeys = array_merge($ykeys,array('year' => $time, $value->name=>number_format($value->number,4)) );
  }
  array_push($data, $ykeys);
}
 ?>
 
	@include('User.teamPlate.graph')

@else
<h2> NOT TXT</h2>
@endif


@stop()
