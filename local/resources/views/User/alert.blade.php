<link rel="stylesheet" type="text/css" href="{{asset('public/bootstrap.min.css')}}">
<script src="{{asset('public/bootstrap.min.js')}}"></script>
<script src="{{asset('public/jquery.min.js')}}"></script>

<a href="{{URL::to('/')}}" class="btn btn-primary">Home</a>
<br>
<span>min 1 - max 1 : quy chuẩn nhà máy</span> <br>
<span>min 2 - max 2 : quy chuẩn QCVN</span>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>name</th>
		<th>min 1</th>
		<th>max 1</th>
		<th>min 2</th>
		<th>max 2</th>
		<th>enable</th>
		<th>Action</th>
	</tr>
	<tr>
		<form method="post" action="{{URL::to('User/postinsert/'.$id_khu_vuc)}}" enctype="multipart/form-data">
			@csrf
			<td></td>
			<td><input type="text" name="name_alert" placeholder="name" required class="form-control"></td>
			<td><input type="number" step="0.01" name="min" placeholder="min 1" required class="form-control"></td>
			<td><input type="number" step="0.01" name="max" placeholder="max 1" required class="form-control"></td>
			<td><input type="number" step="0.01" name="minmin" placeholder="min 2" required class="form-control"></td>
			<td><input type="number" step="0.01" name="maxmax" placeholder="max 2" required class="form-control"></td>
			<td>
				<select name="enable" required class="form-control">
					<option value="YES">YES</option>
					<option value="NO">NO</option>
				</select>
			</td>
			<td><input type="submit"  value="Insert" class="btn btn-primary"></td>
		</form>
	</tr>
<form method="post" action="{{URL::to('User/postupdate/'.$id_khu_vuc)}}" enctype="multipart/form-value">
	@csrf
@foreach ($data as $key => $value)
	<tr>
		<input type="hidden" name="id_alert[]" value="{{$value->id_alert}}" required class="form-control">
		<td>{{$key+1}}</td>
		<td><input type="text" name="name_alert[]" value="{{$value->name_alert}}" required class="form-control"></td>
		<td><input type="number" step="0.01" name="min[]" value="{{$value->min}}" required class="form-control"></td>
		<td><input type="number" step="0.01" name="max[]" value="{{$value->max}}" required class="form-control"></td>
		<td><input type="number" step="0.01" name="minmin[]" value="{{$value->minmin}}" required class="form-control"></td>
		<td><input type="number" step="0.01" name="maxmax[]" value="{{$value->maxmax}}" required class="form-control"></td>
		<td>
			<select name="enable[]" class="form-control">
				<option value="NO" <?php if($value->enable=='NO'){ echo 'selected';} ?>>NO</option>
				<option value="YES" <?php if($value->enable=='YES'){ echo 'selected';} ?>>YES</option>
			</select>
		</td>
		<td><a href="{{URL::to('User/deleteAlert/'.$value->id_alert)}}" class="btn btn-danger"
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
	<tr>
		<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
		<td><input type="submit" value="update" class="btn btn-primary"></td>
	</tr>
</form>

</table>
