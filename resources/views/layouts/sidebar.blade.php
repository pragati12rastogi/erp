<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile not-navigation-link">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            @if(!empty(Auth::user()->profile) && file_exists(public_path().'/uploads/user_profile/'.Auth::user()->profile))
              <img src="{{url('/uploads/user_profile/'.Auth::user()->profile)}}" alt="profile image">
            @else
              <img src="{{ url('assets/images/faces/face8.jpg') }}" alt="profile image">
            @endif
          </div>
          <div class="text-wrapper">
            <p class="profile-name">{{Auth::user()->name}}</p>
            <div class="dropdown" data-display="static">
              <a href="#" class="nav-link d-flex user-switch-dropdown-toggler" id="UsersettingsDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <small class="designation text-muted">{{Auth::user()->role->name}}</small>
                <span class="status-indicator online"></span>
              </a>
              
            </div>
          </div>
        </div>
        
      </div>
    </li>

    <li class="nav-item {{ active_class(['/']) }}">
      <a class="nav-link" href="{{ url('/') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    @if(Auth::user()->hasPermissionTo('users.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
    <li class="nav-item {{ active_class(['users','users/*']) }}">
      <a class="nav-link" href="{{ url('/users') }}">
        <i class="menu-icon mdi mdi-human"></i>
        <span class="menu-title">Users</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->hasPermissionTo('roles.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
    <li class="nav-item {{ active_class(['roles','roles/*']) }}">
      <a class="nav-link" href="{{ url('/roles') }}">
        <i class="menu-icon mdi mdi-wall-sconce-flat"></i>
        <span class="menu-title">Roles</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->hasPermissionTo('category.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
    <li class="nav-item {{ active_class(['category','category/*']) }}">
      <a class="nav-link" href="{{ url('/category') }}">
        <i class="menu-icon mdi mdi-widgets"></i>
        <span class="menu-title">Category</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->hasPermissionTo('hsn.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
    <li class="nav-item {{ active_class(['hsn','hsn/*']) }}">
      <a class="nav-link" href="{{ url('/hsn') }}">
        <i class="menu-icon mdi mdi-air-purifier"></i>
        <span class="menu-title">Hsn</span>
      </a>
    </li>
    @endif
    @if(Auth::user()->hasPermissionTo('gst.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
    <li class="nav-item {{ active_class(['gst','gst/*']) }}">
      <a class="nav-link" href="{{ url('/gst') }}">
        <i class="menu-icon mdi mdi-gamepad-circle-left"></i>
        <span class="menu-title">GST</span>
      </a>
    </li>
    @endif
    
    
    @if(Auth::user()->hasPermissionTo('item.index') || Auth::user()->hasPermissionTo('stocks.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
    <li class="nav-item {{ active_class(['item','item/*','stocks','stocks/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#basic-ui" aria-expanded="{{ is_active_route(['item','item/*','stocks','stocks/*']) }}" aria-controls="basic-ui">
        <i class="menu-icon mdi mdi-image-auto-adjust"></i>
        <span class="menu-title">Inventory</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['item','item/*','stocks','stocks/*']) }}" id="basic-ui">
        <ul class="nav flex-column sub-menu">
          @if(Auth::user()->hasPermissionTo('item.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['item','item/*']) }}">
            <a class="nav-link" href="{{ url('/item') }}">
              Item
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('stocks.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['stocks','stocks/*']) }}">
            <a class="nav-link" href="{{ url('/stocks') }}">
              Stocks
            </a>
          </li>
          @endif
          
        </ul>
      </div>
    </li>
    @endif
  </ul>
</nav>