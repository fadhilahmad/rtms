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
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a>
<!--                  <div class="brand-text d-none d-md-inline-block">
                      <strong class="text-primary">{{ config('app.name', 'Rezeal Textile') }}</strong>
                  </div>-->
              </div>
                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">                             
                    <!-- profile/logout dropdown    -->                     
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item dropdown"><a id="user" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            class="nav-link user dropdown-toggle"> <i class="fa fa-user"></i><span class="d-none d-sm-inline-block">{{ Auth::user()->username }}</span></a>
                            <ul aria-labelledby="languages" class="dropdown-menu">
                              @can('isAdmin')
                                <li><a rel="nofollow" href="{{ route('admin.profile') }}" class="dropdown-item"> <i class="fa fa-address-book-o"></i><span>Profile</span></a></li>
                                <li><a rel="nofollow" href="{{ route('admin.changePassword') }}" class="dropdown-item"> <i class="fa fa-lock"></i><span>Change Password</span></a></li>
                              @endcan
                              @can('isDepartment')
                                <li><a rel="nofollow" href="{{ route('staff.profile') }}" class="dropdown-item"> <i class="fa fa-address-book-o"></i><span>Profile</span></a></li>
                                <li><a rel="nofollow" href="{{ route('staff.changePassword') }}" class="dropdown-item"> <i class="fa fa-lock"></i><span>Change Password</span></a></li>
                              @endcan
                              @can('isCustomer')
                                <li><a rel="nofollow" href="{{ route('customer.profile') }}" class="dropdown-item"> <i class="fa fa-address-book-o"></i><span>Profile</span></a></li>
                                <li><a rel="nofollow" href="{{ route('customer.changePassword') }}" class="dropdown-item"> <i class="fa fa-lock"></i><span>Change Password</span></a></li>
                              @endcan
                                <li><a rel="nofollow" href="{{ route('logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();"> 
                                                      <i class="fa fa-sign-out"></i><span> Logout </span></a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>                      
                                </li>
                            </ul>
                        </li>
                        @endguest
                </ul>
            </div>
          </div>
        </nav>
      </header>
      @yield('content')
    </div>
    <!-- JavaScript files-->
    <!-- <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script> -->
    <script src="{{ asset('vendor/popper.js/umd/popper.min.js') }}"> </script>
    <!-- <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script> -->
    <script src="{{ asset('js/grasp_mobile_progress_circle-1.0.0.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('js/charts-home.js') }}"></script>
    <!-- Main File-->
    <script src="{{ asset('js/front.js') }}"></script>
  </body>
</html>