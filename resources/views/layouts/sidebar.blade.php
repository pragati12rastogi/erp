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

    @if(Auth::user()->hasPermissionTo('roles.index') || Auth::user()->hasPermissionTo('category.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN) || Auth::user()->hasPermissionTo('hsn.index') || Auth::user()->hasPermissionTo('gst.index') || Auth::user()->hasPermissionTo('vendors.index') || Auth::user()->hasPermissionTo('invoice.master') || Auth::user()->hasPermissionTo('states.index') || Auth::user()->hasPermissionTo('districts.index') || Auth::user()->hasPermissionTo('areas.index') || Auth::user()->hasPermissionTo('email-master.index') || Auth::user()->hasPermissionTo('sms.master') || Auth::user()->hasPermissionTo('general.master'))
    <li class="nav-item {{ active_class(['roles','roles/*','category','category/*','hsn','hsn/*','gst','gst/*','vendors','vendors/*','invoice/setting','states','states/*','districts','districts/*','areas','areas/*','email/setting','sms/setting','general/setting']) }}">
      <a class="nav-link" data-toggle="collapse" href="#basic-ui" aria-expanded="{{ is_active_route(['roles','roles/*','category','category/*','hsn','hsn/*','gst','gst/*','vendors','vendors/*','invoice/setting','states','states/*','districts','districts/*','areas','areas/*','email/setting','sms/setting','general/setting']) }}" aria-controls="basic-ui">
        <i class="menu-icon mdi mdi-widgets"></i>
        <span class="menu-title">Master</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['roles','roles/*','category','category/*','hsn','hsn/*','gst','gst/*','vendors','vendors/*','invoice/setting','states','states/*','districts','districts/*','areas','areas/*','email/setting','sms/setting','general/setting']) }}" id="basic-ui">
        <ul class="nav flex-column sub-menu">
          @if(Auth::user()->hasPermissionTo('roles.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['roles','roles/*']) }}">
            <a class="nav-link" href="{{ url('/roles') }}">
              Roles
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('category.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['category','category/*']) }}">
            <a class="nav-link" href="{{ url('/category') }}">
              Category
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('hsn.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['hsn','hsn/*']) }}">
            <a class="nav-link" href="{{ url('/hsn') }}">
              Hsn
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('gst.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['gst','gst/*']) }}">
            <a class="nav-link" href="{{ url('/gst') }}">
              GST
            </a>
          </li>
          @endif
          
          @if(Auth::user()->hasPermissionTo('states.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['states','states/*']) }}">
            <a class="nav-link" href="{{ url('/states') }}">
              State
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('districts.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['districts','districts/*']) }}">
            <a class="nav-link" href="{{ url('/districts') }}">
              District
            </a>
          </li>
          @endif

          @if(Auth::user()->hasPermissionTo('areas.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['areas','areas/*']) }}">
            <a class="nav-link" href="{{ url('/areas') }}">
              Area
            </a>
          </li>
          @endif

          @if(Auth::user()->hasPermissionTo('vendors.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['vendors','vendors/*']) }}">
            <a class="nav-link" href="{{ url('/vendors') }}">
              Vendors
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('invoice.master') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['invoice/setting']) }}">
            <a class="nav-link" href="{{ url('invoice/setting') }}">
              Invoice Master
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('billing.master') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['billing/setting']) }}">
            <a class="nav-link" href="{{ url('billing/setting') }}">
              Billing Address Master
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('email-master.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['email/setting']) }}">
            <a class="nav-link" href="{{ url('email/setting') }}">
              Email Setting
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('sms.master') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['sms/setting']) }}">
            <a class="nav-link" href="{{ url('sms/setting') }}">
              SMS Setting
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermissionTo('general.master') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['general/setting']) }}">
            <a class="nav-link" href="{{ url('general/setting') }}">
              General Setting
            </a>
          </li>
          @endif
        </ul>
      </div>
    </li>
    @endif

    @if(Auth::user()->hasPermissionTo('item.index') || Auth::user()->hasPermissionTo('stocks.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN)  || Auth::user()->hasPermissionTo('stock-distributions.index') || Auth::user()->hasPermissionTo('users-stock.list') || Auth::user()->hasPermissionTo('expenses.index') || Auth::user()->hasPermissionTo('profit-chart.index') || Auth::user()->hasPermissionTo('product_charge.index'))
    <li class="nav-item {{ active_class(['item','item/*','stocks','stocks/*','stock-distributions','stock-distributions/*','local-stock-distribution','local-stock-distribution/*','users-stock/list','expenses','expenses/*','profit-chart']) }}">
      <a class="nav-link" data-toggle="collapse" href="#basic-ui2" aria-expanded="{{ is_active_route(['item','item/*','stocks','stocks/*','stock-distributions','stock-distributions/*','local-stock-distribution','local-stock-distribution/*','users-stock/list','expenses','expenses/*','profit-chart','product_charge']) }}" aria-controls="basic-ui2">
        <i class="menu-icon mdi mdi-image-auto-adjust"></i>
        <span class="menu-title">Inventory</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['item','item/*','stocks','stocks/*','stock-distributions','stock-distributions/*','local-stock-distribution','local-stock-distribution/*','users-stock/list','expenses','expenses/*','profit-chart','product_charge']) }}" id="basic-ui2">
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
          
          @if(Auth::user()->hasPermissionTo('stock-distributions.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['stock-distributions','stock-distributions/*']) }}">
            <a class="nav-link" href="{{ url('stock-distributions') }}">
              Stock Distribution
            </a>
          </li>
          @endif

          @if(Auth::user()->hasPermissionTo('users-stock.list') )
          <li class="nav-item {{ active_class(['users-stock/list']) }}">
            <a class="nav-link" href="{{ url('users-stock/list') }}">
              User Stock List
            </a>
          </li>
          @endif

          @if(Auth::user()->hasPermissionTo('local-stock-distribution.index') )
          <li class="nav-item {{ active_class(['local-stock-distribution','local-stock-distribution/*']) }}">
            <a class="nav-link" href="{{ url('local-stock-distribution') }}">
              Local Stock Distribution
            </a>
          </li>
          @endif

          @if(Auth::user()->hasPermissionTo('expenses.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['expenses','expenses/*']) }}">
            <a class="nav-link" href="{{ url('/expenses') }}">
              <span class="menu-title">Expenses</span>
            </a>
          </li>
          @endif

          @if(Auth::user()->hasPermissionTo('profit-chart.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['profit-chart']) }}">
            <a class="nav-link" href="{{ url('/profit-chart') }}">
              <span class="menu-title">View Chart</span>
            </a>
          </li>
          @endif

          @if(Auth::user()->hasPermissionTo('product_charge.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
          <li class="nav-item {{ active_class(['product_charge']) }}">
            <a class="nav-link" href="{{ url('/product_charge') }}">
              <span class="menu-title">Product Charge</span>
            </a>
          </li>
          @endif

        </ul>
      </div>
    </li>
    @endif

  </ul>
</nav>