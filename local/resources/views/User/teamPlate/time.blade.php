<form method="post" action="{{URL::to('User/postTable/'.$id_khuVuc)}}" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-sm-4 center">
			<label>startTime</label>
			<input type="datetime-local" name="startTime" placeholder="startTime" 
			value="<?php if(isset($startTime)){ echo $startTime; } ?>" 
			required class="form-control">
		</div>
		<div class="col-sm-4 center">
			<label>endTime</label>
			<input type="datetime-local" name="endTime" placeholder="endTime"
			value="<?php if(isset($endTime)){ echo $endTime; } ?>" 
			 required class="form-control">			
		</div>
		<div class="col-sm-4 center"> <input type="submit"  value="Search Time"></div>
	</div>
</form>
<br>
<style type="text/css">
.center{
	display: flex;
	align-items: center;
}
</style>