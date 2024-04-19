@extends('Master')
@section('title','alert')
@section('action')

<center><h1><a href="{{URL::to('Master/khuVuc/'.$id_nha_may)}}">Of : {{$name}}</a></h1></center>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>name</th>
		<th>minmin</th>
		<th>min</th>
		<th>max</th>
		<th>maxmax</th>
		<th>enable</th>
		<th>Action</th>
	</tr>
	<tr>
<form method="post" action="{{URL::to('Master/alert/postinsert/'.$id_khu_vuc)}}" enctype="multipart/form-data">
	@csrf
	<td></td>
	<td><input type="text" name="name_alert" placeholder="name" required class="form-control"></td>
	<td><input type="number" step="0.01" name="minmin" placeholder="minmin" required class="form-control"></td>
	<td><input type="number" step="0.01" name="min" placeholder="min" required class="form-control"></td>
	<td><input type="number" step="0.01" name="max" placeholder="max" required class="form-control"></td>
	<td><input type="number" step="0.01" name="maxmax" placeholder="maxmax" required class="form-control"></td>
	<td>
		<select name="enable" required class="form-control">
			<option value="NO">NO</option>
			<option value="YES">YES</option>
		</select>
	</td>
	<td><input type="submit"  value="Insert" class="btn btn-primary"></td>
</form>		
	</tr>
<form method="post" action="{{URL::to('Master/alert/postupdate/.$id_khu_vuc')}}" enctype="multipart/form-value">
	@csrf
@foreach ($data as $key => $value)
	<tr>
		<input type="hidden" name="id_alert[]" value="{{$value->id_alert}}" required class="form-control">
		<td>{{$key+1}}</td>
		<td><input type="text" name="name_alert[]" value="{{$value->name_alert}}" required class="form-control"></td>
		<td><input type="number" name="minmin[]" value="{{$value->minmin}}" required class="form-control"></td>
		<td><input type="number" name="min[]" value="{{$value->min}}" required class="form-control"></td>
		<td><input type="number" name="max[]" value="{{$value->max}}" required class="form-control"></td>
		<td><input type="number" name="maxmax[]" value="{{$value->maxmax}}" required class="form-control"></td>
		<td>
			<select name="enable[]" class="form-control">
				<option value="NO" <?php if($value->enable=='NO'){ echo 'selected';} ?>>NO</option>
				<option value="YES" <?php if($value->enable=='YES'){ echo 'selected';} ?>>YES</option>
			</select>
		</td>
		<td>
			<a href="{{URL::to('Master/alert/delete/'.$value->id_alert)}}" class="btn btn-danger"
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
	<input type="submit" value="update" class="btn btn-primary">
</form>
</table>
@stop()
