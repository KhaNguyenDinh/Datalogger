<form method="post" action="{{URL::to('User/postKhuVuc/'.$id_khu_vuc.'/'.$action)}}" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-sm-3 center">
			<label>startTime</label>
			<input type="datetime-local" name="startTime" placeholder="startTime" 
			value="<?php if(isset($startTime)){ echo $startTime; } ?>" 
			required class="form-control">
		</div>
		<div class="col-sm-3 center">
			<label>endTime</label>
			<input type="datetime-local" name="endTime" placeholder="endTime"
			value="<?php if(isset($endTime)){ echo $endTime; } ?>" 
			 required class="form-control">			
		</div>
		@if($action=='Alert')
		<div class="col-sm-3 center">
			<label>Alert</label>
			<select name="Alert">
				<option value="Alert"<?php if ($show_Alert=="Alert"||$show_Alert=='') { echo "selected";} ?> >Vượt tiêu chuẩn Nhà Máy</option>
				<option value="Error"<?php if ($show_Alert=="Error") { echo "selected";} ?> >Vượt tiêu chuẩn QCVN40</option>
			</select>		
		</div>
		@endif
		<div class="col-sm-1 center"> <input type="submit"  value="Tìm kiếm" class="btn btn-primary"></div>
	</div>
</form>
<br>
<style type="text/css">
.center{
	display: flex;
	align-items: center;
}
</style>