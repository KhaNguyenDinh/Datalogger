@extends('User')
@section('title','khuVuc')
@section('content')

<?php 
$khuVucGetId = $results['khuVucGetId'];
$searchTxt = $results['searchTxt'];
$getTxt = $searchTxt[0]['getTxt'];
$alert = $results['alert'];
 ?>
@include('User.teamPlate.tbl')

@stop()
