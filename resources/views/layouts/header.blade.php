<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
    <a class="navbar-brand brand-logo" href="{{ url('/') }}">
      <img src="{{ url('assets/images/logo.svg') }}" alt="logo" /> </a>
    <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
      <img src="{{ url('assets/images/logo-mini.svg') }}" alt="logo" /> </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <ul class="navbar-nav navbar-nav-left header-links">
      <li class="nav-item d-none d-xl-flex">
        <a href="{{url('/')}}" class="nav-link">Dashboard 
        </a>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      
      <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <span class="profile-text d-none d-md-inline-flex">{{Auth::user()->name}} !</span>
            @if(!empty(Auth::user()->profile) && file_exists(public_path().'/uploads/user_profile/'.Auth::user()->profile))
              <img class="img-xs rounded-circle" src="{{url('/uploads/user_profile/'.Auth::user()->profile)}}" alt="profile image">
            @else
              <img class="img-xs rounded-circle" src="{{ url('assets/images/faces/face8.jpg') }}" alt="profile image">
            @endif
          </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
            <a class="dropdown-item mt-2" href="{{url('user-profile/update')}}"> Manage Accounts </a>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu icon-menu"></span>
    </button>
  </div>
</nav>