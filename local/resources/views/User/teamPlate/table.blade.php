@if(isset($startTime))
<form method="post" action="{{URL::to('User/postKhuVuc/'.$id_khuVuc)}}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="action" value="execel">
	<input type="hidden" name="startTime" value="{{$startTime}}">
	<input type="hidden" name="endTime" value="{{$endTime}}">
	<input type="submit"  value="Export execel" class="btn btn-primary">
</form>
@endif

<?php $th = json_decode($txt[0]->data, true); ?>
<table class="table table-bordered">
	<tr>
		<th>Time</th>
		@foreach($th as $key => $value)
		<th>{{$value['name']}}</th>
		@endforeach
	</tr>
	@foreach($txt as $key => $value)
	<?php $arrayData = json_decode($value->data, true); ?>
	<tr>
		<td>{{$value->time}}</td>
		@foreach($arrayData as $key => $value)
		<td><?=number_format($value['number'],2) ?></td>
		@endforeach
	</tr>
	@endforeach

</table>