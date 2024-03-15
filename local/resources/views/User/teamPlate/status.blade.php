<div style="display: flex;justify-content: flex-end;align-items: center;">
  <i class="status" style="background: green"></i>Norm <div class="transparent">{{$tab}}</div> 
  <i class="status" style="background: #ff8400"></i>Calib <div class="transparent">{{$tab}}</div>
  <i class="status" style="background: red"></i>Error <div class="transparent">{{$tab}}</div>
  
  <i class="background" style="background: white"></i>Hoạt động tốt <div class="transparent">{{$tab}}</div>
  <i class="background" style="background: #ff8400"></i>Vượt tiêu chuẩn {{$results['nhaMayGetId']->name_nhaMay}} <div class="transparent">{{$tab}}</div>
  <i class="background" style="background: red"></i>Vượt tiêu chuẩn QCVN40 <div class="transparent">{{$tab}}</div>
  
</div>