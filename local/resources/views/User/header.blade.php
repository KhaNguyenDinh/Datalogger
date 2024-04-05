  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn"></i>

      <div class="logo d-flex align-items-center" style="position: absolute; left: 150px;">
        <img src="{{asset('public/assets/img/logo_remove.png')}}" alt="">
        <span> 
          <b style="font-size: 13px;">TRUNG TÂM PHÂN TÍCH VÀ MÔI TRƯỜNG </b><br>
          <b style="font-size: 16px">PHẦN MỀM QUẢN LÝ DỮ LIỆU QUAN TRẮC</b>
        </span>
      </div>
    </div><!-- End Logo -->

    <nav class="header-nav" style="position:absolute ; right: 10px;">
      <ul class="d-flex align-items-center">
<!-- // head -->
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2"><i class="bi bi-person"></i>{{session('name_account')}}</span>
          </a><!-- End Profile Iamge Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{URL::to('User/update')}}">
                <i class="bi bi-gear"></i> <span>Update</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{URL::to('logout')}}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->