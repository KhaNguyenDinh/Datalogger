@extends('Admin')
@section('title','admin')
@section('content')
<?php 
// dd($results);
// dd($name_status);
// $name = ['connect','E','C','error','alert']; ?>
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title" style="display: flex;justify-content: space-between;">Tổng quan Admin</h5>
          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th>Văn phòng</th>
                <th>Nhà Máy</th>
                <th>Khu Vực</th>
                <th>Mất tín hiệu</th>
                <th>Thiết bị lỗi</th>
                <th>Hiệu chuẩn</th>
                <th>Vượt chỉ tiêu</th>
                <th>Chuẩn bị vượt</th>
              </tr>
            </thead>
            <tbody>
              
        				@foreach($results as $key => $value)
        				<tr>
        				  <td >{{$value['name_van_phong']}}</td>
                  <td >{{$value['name_nha_may']}}</td>
                  <td >{{$value['name_khu_vuc']}}</td>
                  @for ($i=0; $i < count($name_status) ; $i++)
                    @if($value['status_khuVuc'][$name_status[$i]]==0)
                    <td> --- </td>
                    @else
                    <td style="background: red;">ERROR</td>
                    @endif
                  @endfor
        				</tr>
                <!-- //// -->
<tr>
  <?php 
  $time = $value['newTxt']->time;
  $list_alert = $value['list_alert'];
  $arrayData = json_decode($value['newTxt']->data, true);
   ?>
  <td>Time</td>
  @foreach($arrayData as $key => $value)
  <td>{{$value['name']}}</td>
  @endforeach
</tr>
<tr>
  <td>{{$time}}</td>
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
<!-- ////////////// -->
        				@endforeach
            </tbody>
          </table>
          <!-- End Table with stripped rows -->
        </div>
      </div>

    </div>
  </div>
</section>




@stop()
<script type="text/javascript">
setTimeout(function(){
   window.location.reload(0);
}, 300000);
</script>