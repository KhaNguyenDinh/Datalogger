
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{URL::to('User/'.$nhaMayGetId->id_nhaMay.'/0')}}">
          <i class="bi bi-grid"></i>
          <span>Trang chủ</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#Tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Tra cứu dữ liệu gốc</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="Tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          @foreach ($khuVuc as $key => $value)
      <li><a href="{{URL::to('User/khuVuc/'.$value->id_khuVuc.'/Tables')}}"><i class="bi bi-bar-chart"></i><span>{{$value->name_khuVuc}}</span></a></li>
      @endforeach
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#Alert-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Tra cứu dữ liệu vượt ngưỡng</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="Alert-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          @foreach ($khuVuc as $key => $value)
      <li><a href="{{URL::to('User/khuVuc/'.$value->id_khuVuc.'/Alert')}}"><i class="bi bi-bar-chart"></i><span>{{$value->name_khuVuc}}</span></a></li>
      @endforeach
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#Charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Biểu đồ</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="Charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        	@foreach ($khuVuc as $key => $value)
			<li><a href="{{URL::to('User/khuVuc/'.$value->id_khuVuc.'/Charts')}}"><i class="bi bi-bar-chart"></i><span>{{$value->name_khuVuc}}</span></a></li>
			@endforeach
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#Camera-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-collection-play"></i><span>Camera</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="Camera-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          @foreach ($khuVuc as $key => $value)
      <li><a href="{{URL::to('User/khuVuc/'.$value->id_khuVuc.'/Camera')}}"><i class="bi bi-bar-chart"></i><span>{{$value->name_khuVuc}}</span></a></li>
      @endforeach
        </ul>
      </li><!-- End Tables Nav -->

    </ul>

  </aside><!-- End Sidebar-->