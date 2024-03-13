@if(isset($startTime))
<form method="post" action="{{URL::to('User/postKhuVuc/'.$id_khuVuc)}}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="action" value="execel">
	<input type="hidden" name="startTime" value="{{$startTime}}">
	<input type="hidden" name="endTime" value="{{$endTime}}">
	<input type="submit"  value="Export">
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
		<?php 
			$status = 'green'; $background='white';
			if ($alert!==null) {
				foreach ($alert as $key1 => $value1) {
					if ($value1['name_alert']==$value['name'] && $value1['enable']=="YES") {
						if($value['number'] <$value1['minmin'] || $value['number'] > $value1['maxmax']){ $background = 'red'; }
						if(($value['number'] >$value1['minmin'] && $value['number'] < $value1['min'] )
							||($value['number'] >$value1['max'] && $value['number'] < $value1['maxmax'])){ $background = '#ff8400'; }
					}
				}
			}
			switch ($value['status']) {
				case 0:$status = 'green';break;
				case 1:$status = '#ff8400';break;
				case 2:$status = 'red';break;
			}
		 ?>
		<td style="background: {{$background}}">
			<div style="display: flex;"><?=number_format($value['number'],2) ?>
				<div id="status" style="background: {{$status}}"></div>		
			</div>
		</td>
		@endforeach
	</tr>
	@endforeach

</table>
<style type="text/css">

#status{
  width: 8px;
  height: 8px;
  border-radius: 50%;
} 
</style>