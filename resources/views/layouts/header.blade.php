<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
    <a class="navbar-brand brand-logo" href="{{ url('/') }}">
      @if(!empty($general_settings) && !empty($general_settings['logo']) && file_exists(public_path().'/images/general/'.$general_settings['logo']) )
      <img src="{{ url('/images/general/'.$general_settings['logo']) }}" alt="logo" /> 
      @else
      <img src="{{ url('assets/images/logo.svg') }}" alt="logo" /> 
      @endif
    </a>
    <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
      @if(!empty($general_settings) && !empty($general_settings['favicon']) && file_exists(public_path().'/images/general/'.$general_settings['favicon']) )
      <img src="{{ url('/images/general/'.$general_settings['favicon']) }}" alt="logo" /> 
      @else
      <img src="{{ url('assets/images/logo-mini.svg') }}" alt="logo" />
      @endif 
    </a>
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
    <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          @if(auth()->user()->unreadnotifications->where('n_type','=','product_request')->count())
          <span id="countNoti" class="count bg-success">{{ auth()->user()->unreadnotifications->where('n_type','=','product_request')->count() }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
          <a class="dropdown-item py-3 border-bottom">
            @if(auth()->user()->unreadnotifications->where('n_type','=','product_request')->count())
            <p  class="mb-0 font-weight-medium float-left">
              {{ auth()->user()->unreadnotifications->where('n_type','=','product_request')->count() }} new notifications
            </p>
            <span class="badge badge-pill badge-primary float-right">View all</span>
            @else
            <p class="mb-0 font-weight-medium float-left">
              No Notifications
            </p>
            @endif
          </a>
          @if(auth()->user()->unreadnotifications->where('n_type','=','product_request')->count()>0)
            @foreach(auth()->user()->unreadnotifications->where('n_type','=','product_request') as $notification)
            <a onclick="markread('{{ $notification->id }}')"  href="{{ url($notification->url) }}" class="dropdown-item preview-item py-3">
              <div class="preview-thumbnail">
              <i class="mdi mdi-airballoon m-auto text-primary"></i>
              </div>
              <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal text-dark mb-1">{{ $notification->data['data'] }}</h6>
                <p class="font-weight-light small-text mb-0"> {{ date('jS M y',strtotime($notification->created_at)) }} </p>
              </div>
            </a>
            @endforeach
          @endif
        </div>
      </li>
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