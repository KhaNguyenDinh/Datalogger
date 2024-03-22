@extends('Admin')
@section('title','index')
@section('action')

<div class="row">
	<div class="col-sm-1">
	@foreach ($nhaMay as $key => $value)
		<a href="{{URL::to('Admin/show/'.$value->id_nhaMay)}}" class="btn btn-default">{{$value->name_nhaMay}}</a><br>
	@endforeach
	</div>
	<div class="col-sm-11">
		@if($id_nhaMay!=0)
		<iframe src="{{URL::to('User/'.$id_nhaMay.'/0')}}"></iframe>
		@endif
	</div>
</div>

@stop()
<style>
    iframe {
        width: 100%;
        height: 90vh;
        /*border: none;  Xóa đường viền của iframe */
    }
</style>