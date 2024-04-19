
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title" style="display: flex;justify-content: space-between;">Tra cứu dữ liệu gốc
            @if(isset($startTime))
            <form method="post" action="{{URL::to('User/postKhuVuc/'.$id_khu_vuc.'/'.$action)}}" enctype="multipart/form-data" class="export">
              @csrf
              <input type="hidden" name="action" value="execel">
              <input type="hidden" name="startTime" value="{{$startTime}}">
              <input type="hidden" name="endTime" value="{{$endTime}}">
              <input type="hidden" name="Alert" value="">
              <input type="submit"  value="Export execel" class="btn btn-primary">
            </form>
            @endif
          </h5>
          <!-- Table with stripped rows -->
          <table class="table datatable">
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
  @foreach($arrayData as $key => $value1)
  <td><?=number_format($value1['number'],2) ?></td>
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




