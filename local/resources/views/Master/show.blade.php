@extends('Master')
@section('title','Show')
@section('action')

<div class="row">
	<div class="col-sm-1">
	@foreach ($nhaMay as $key => $value)
		<a href="{{URL::to('Master/show/'.$value->id_nha_may)}}" class="btn btn-default">{{$value->name_nha_may}}</a><br>
	@endforeach
	</div>
	<div class="col-sm-11">
		@if($id_nha_may!=0)
		<iframe src="{{URL::to('User/'.$id_nha_may.'/0')}}"></iframe>
		@endif
	</div>
</div>

@stop()
<style>
    iframe {
        width: 100%;
        height: 90vh;
        border: none;  /*Xóa đường viền của iframe */
    }
</style>