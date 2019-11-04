<!DOCTYPE html>
<html>
  @include('layouts.head')
  <body>
    <!-- Side Navbar -->
    @include('layouts.sidebar')
    <div class="page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="index.html" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><strong class="text-primary">Management System</strong></div></a></div>
                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">                             
                    <!-- profile/logout dropdown    -->   
                    <li class="nav-item dropdown"><a id="profile" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"> <i class="fa fa-user"></i><span class="d-none d-sm-inline-block">username</span></a>
                    <ul aria-labelledby="languages" class="dropdown-menu">
                        <li><a rel="nofollow" href="#" class="dropdown-item"> <i class="fa fa-address-book-o"></i><span>Profile</span></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item"> <i class="fa fa-sign-out"></i><span>Logout </span></a></li>
                    </ul>
                    </li>
                </ul>
            </div>
          </div>
        </nav>
      </header>
      @yield('content')
      @include('layouts.footer')
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/charts-home.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
  </body>
</html>