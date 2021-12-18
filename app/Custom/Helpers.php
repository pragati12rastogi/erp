<?php

  use App\Models\Role;
  use App\Custom\Constants;

  // For add'active' class for activated route nav-item
  function active_class($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
  }

  // For checking activated route
  function is_active_route($path) {
    return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
  }

  // For add 'show' class for activated route collapse
  function show_class($path) {
    return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
  }

  function is_admin($role_id){
    $role = Role::where('id',$role_id)->where('name',Constants::ROLE_ADMIN)->first();
    if(empty($role)){
      return false;
    }else{
      return true;
    }
  }

