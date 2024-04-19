@extends('Admin')
@section('title','admin')
@section('content')

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
        				@foreach($results['list_vanphong'] as $key => $value)
        				<tr>
        				  <td>{{$value['vanPhong']['name_van_phong']}}</td>
                  @if($value['status_vanPhong']['connect']==0)
                    @for ($i=0; $i < count($name) ; $i++)
                      @if($value['status_vanPhong'][$name[$i]]==0)
                      <td style="background: #83f783;">Bình thường</td>
                      @else
                      <td style="background: #afabab;color: red">Lỗi</td>
                      @endif
                    @endfor
                  @else
                  <td style="background: #afabab;color: red">Mất kết nối</td><td></td><td></td><td></td><td></td>
                  @endif
        				  <td><a href="{{URL::to('vanPhong/'.$value['vanPhong']['id_van_phong'].'/0')}}" class="btn btn-primary">show</a></td>
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
@stop()
