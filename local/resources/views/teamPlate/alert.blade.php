
<?php 
$list_alert = [];
if ($alert) {
	foreach ($alert as $key => $value) {
		if ($value['enable']=="YES") {
			$list_alert[$value['name_alert']]=$value;
		}
	}
}
 ?>
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title" style="display: flex;justify-content: space-between;">Tra cứu dữ liệu vượt ngưỡng
			@if(isset($startTime))
			<form method="post" action="{{URL::to('User/postKhuVuc/'.$id_khu_vuc.'/'.$action)}}" enctype="multipart/form-data" class="export">
				@csrf
				<input type="hidden" name="action" value="execel">
				<input type="hidden" name="startTime" value="{{$startTime}}">
				<input type="hidden" name="endTime" value="{{$endTime}}">
				<input type="hidden" name="Alert" value="{{$show_Alert}}">
				<input type="submit"  value="Export execel" class="btn btn-primary">
			</form>
			@endif
		</h5>
          <!-- Table with stripped rows -->
          <table class="table datatable scoll">
            <thead>
              <tr>
<?php $th = json_decode($txt[0]->data, true); ?>
<th>Time</th>
@foreach($th as $key => $value)
<th>{{$value['name']}}</th>
@endforeach
              </tr>
            </thead>
            <tbody>
@foreach($txt as $key => $value)
<?php $arrayData = json_decode($value->data, true); ?>
<tr>
	<td>{{$value->time}}</td>
	@foreach($arrayData as $key1 => $value1)
	<?php 
	$TrangThai= "trongnguong1";$status = "sttnorm";
		if (array_key_exists($value1['name'], $list_alert)) {
			$value2 = $list_alert[$value1['name']];

				if ($value1['number']<$value2['minmin']||$value1['number']>$value2['maxmax']) {
					$TrangThai="vuotnguong";
				}
				if(($value1['number'] >$value2['minmin'] && $value1['number'] < $value2['min'] )
						||($value1['number'] >$value2['max'] && $value1['number'] < $value2['maxmax'])){ 
					$TrangThai="chuanbi";
				}
		}

		switch ($value1['status']) {
			case 1:$status = 'sttcal';break;
			case 2:$status = 'stterror';break;
		}
	 ?>
	<td class="<?=$TrangThai ?> ">
		<div style="display: flex;justify-content: space-between;"><?=number_format($value1['number'],2) ?>  
			<div class="status <?=$status ?> "></div>		
		</div>
	</td>
	@endforeach
</tr>
@endforeach
            </tbody>
          </table>
          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>
  </div>
</section>

<style type="text/css">
.trongnguong1{
	background-image: linear-gradient(white, #def7ea 0%, -225deg 100%);
}
</style>