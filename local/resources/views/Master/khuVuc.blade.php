@extends('Master')
@section('title','khuVuc')
@section('action')

<center><h1>Of : {{$nhaMayGetId->name_nha_may}}</h1></center>
<table class="table table-bordered">
	<tr>
		<th>STT</th>
		<th>khuVuc</th>
		<th>folder_TXT</th>
		<th>type</th>
		<th>Loại</th>
		<th>Map</th>
		<th>camera</th>
		<th>alert</th>
		<th>Vị Trí Show</th>
		<th>Action</th>
	</tr>
	<tr>
<form method="post" action="{{URL::to('Master/khuVuc/postinsert/'.$nhaMayGetId->id_nha_may)}}" enctype="multipart/form-data">
	@csrf
	<td></td>
	<td><input type="text" name="name_khu_vuc" placeholder="name" required class="form-control"></td>
	<td><input type="text" name="folder_txt" placeholder="folder TXT" required class="form-control"></td>
	<td>
		<select name="type" required class="form-control">
			<option value="y/m/d">y/m/d</option>
			<option value="ymd">ymd</option>
		</select>
	</td>
	<td>
		<select name="loai" required class="form-control">
			<option value="Nước Thải">Nước Thải</option>
			<option value="Khí Thải">Khí Thải</option>
		</select>
	</td>
	<td><input type="text" name="link_map" placeholder="link_map" required class="form-control"></td>
	<td></td><td></td><td></td>
	<td><input type="submit"  value="Insert" class="btn btn-primary"></td>
</form>
	</tr>
<form method="post" action="{{URL::to('Master/khuVuc/postupdate/'.$nhaMayGetId->id_nha_may)}}" enctype="multipart/form-value">
	@csrf
@foreach ($khuVuc as $key => $value)
	<tr>
		<input type="hidden" name="id_khu_vuc[]" value="{{$value->id_khu_vuc}}" required class="form-control">
		<td>{{$key+1}}</td>
		<td><input type="text" name="name_khu_vuc[]" value="{{$value->name_khu_vuc}}" required class="form-control"></td>
		<td><div class="form-control">{{$value->folder_txt}}</div></td>
		<td>
			<select name="type[]" required class="form-control">
				<option value="ymd" <?php if($value->type=='ymd'){ echo 'selected';} ?>>ymd</option>
				<option value="y/m/d" <?php if($value->type=='y/m/d'){ echo 'selected';} ?>>y/m/d</option>
			</select>
		</td>
		<td>
			<select name="loai[]" required class="form-control">
				<option value="Nước Thải" <?php if($value->nuoc_khi=='Nước Thải'){ echo 'selected';} ?>>Nước Thải</option>
				<option value="Khí Thải" <?php if($value->nuoc_khi=='Khí Thải'){ echo 'selected';} ?>>Khí Thải</option>
			</select>
		</td>
		<td><input type="text" name="link_map[]" value="{{$value->link_map}}" required class="form-control"></td>
		<td><a href="{{URL::to('Master/camera/'.$value->id_khu_vuc)}}">show</a></td>
		<td><a href="{{URL::to('Master/alert/'.$value->id_khu_vuc)}}">show</a></td>
		<td><a href="{{URL::to('Master/viTri/'.$value->id_khu_vuc)}}">show</a></td>
		<td>
			<a href="{{URL::to('Master/khuVuc/delete/'.$value->id_khu_vuc)}}" class="btn btn-danger"
				onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">delete</a>
		</td>
	</tr>
@endforeach
	<input type="submit" value="update" class="btn btn-primary">
</form>
</table>
@stop()


			
			
			
			
			
