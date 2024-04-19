@extends('Admin')
@section('title','vanphong')
@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">
            @if(session('level')=='Admin')
            <a href="{{URL::to('Admin')}}">Admin/</a>
            @endif
            Tổng quan văn phòng {{$vanPhong->name_van_phong}}</h5>
          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
        				<th>Nhà máy</th>
        				<th>Tín hiệu</th>
        				<th>Thiết bị lỗi</th>
        				<th>Hiệu chuẩn</th>
        				<th>Vượt chỉ tiêu</th>
        				<th>Chuẩn bị vượt</th>
        				<th>Chi tiết</th>
              </tr>
            </thead>
            <tbody>
              <?php $name = ['connect','E','C','error','alert']; ?>
        				@foreach($results['list_nhaMay'] as $key => $value)
        				<tr>
        				  <td>{{$value['nhaMay']['name_nha_may']}}</td>
                  @if($value['status_nhamay']['connect']==0)
                    @for ($i=0; $i < count($name) ; $i++)
                      @if($value['status_nhamay'][$name[$i]]==0)
                      <td style="background: #83f783;">Bình thường</td>
                      @else
                      <td style="background: #afabab;color: red">Lỗi</td>
                      @endif
                    @endfor
                  @else
                  <td style="background: #afabab;color: red">Mất kết nối</td><td></td><td></td><td></td><td></td>
                  @endif
        				  <td><a href="{{URL::to('vanPhong/'.$vanPhong->id_van_phong.'/'.$value['nhaMay']['id_nha_may'])}}" class="btn-primary btn">show</a></td>
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
@if($id_nha_may!=0)
<a href="{{URL::to('vanPhong/'.$vanPhong->id_van_phong.'/0')}}" class="back btn btn-danger">X</a>
<iframe src="{{URL::to('User/'.$id_nha_may.'/0')}}" class="iframe"></iframe>
@endif
<style type="text/css">
  .iframe{
    position: absolute;
    top: 0px; right: 5px;left: 5px; 
    z-index: 10;
    width: 100vw;
    height: 100vh;
  }
  .back{
    position: absolute;
    top: 12px;left: 60px;
    z-index: 11;
  }
</style>
@stop()
