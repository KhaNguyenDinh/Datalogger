@if(isset($startTime))
<form method="post" action="{{URL::to('User/postKhuVuc/'.$id_khuVuc.'/'.$action)}}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="action" value="execel">
	<input type="hidden" name="startTime" value="{{$startTime}}">
	<input type="hidden" name="endTime" value="{{$endTime}}">
	<input type="hidden" name="Alert" value="{{$show_Alert}}">
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
<?php 
if ($alert) {
	foreach ($alert as $key => $value) {
		if ($value['enable']=="YES") {
			$list_alert[$value['name_alert']]=$value;
		}
	}
}
 ?>
	@foreach($txt as $key => $value)
	<?php $arrayData = json_decode($value->data, true); ?>
	<tr>
		<td>{{$value->time}}</td>
		@foreach($arrayData as $key1 => $value1)
		<?php 
			$status = 'green'; $background='white';
			if (array_key_exists($value1['name'], $list_alert)) {
				$value2 = $list_alert[$value1['name']];
				if ($value2['name_alert']==$value1['name']) {
					if ($value1['number']<$value2['minmin']||$value1['number']>$value2['maxmax']) {
						$background = 'red';
					}
					if(($value1['number'] >$value2['minmin'] && $value1['number'] < $value2['min'] )
							||($value1['number'] >$value2['max'] && $value1['number'] < $value2['maxmax'])){ 
						$background = '#ff8400'; 
					}
				}
			}

			switch ($value1['status']) {
				case 0:$status = 'green';break;
				case 1:$status = '#ff8400';break;
				case 2:$status = 'red';break;
			}
		 ?>
		<td style="background: {{$background}}">
			<div style="display: flex;justify-content: space-between;"><?=number_format($value1['number'],2) ?>  
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