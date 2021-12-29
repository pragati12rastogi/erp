<?php

  use App\Models\Role;
  use App\Custom\Constants;
  use App\Models\DistributionOrder;
  use App\Models\UserStockDistributionOrder;
  use App\Models\InvoiceSetting;

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

  function generate_invoice_no(){
    $inv = InvoiceSetting::first();
    $distribution = $inv['invoice_no'];

    if(empty($distribution)){
      $make_inv_no = str_pad(1,$inv['suffix_number_length'],"0",STR_PAD_LEFT);
      
    }else{
      $increment = (int)$distribution+1;
      $make_inv_no = str_pad($increment,$inv['suffix_number_length'],"0",STR_PAD_LEFT);
    }
    $inv->increment('invoice_no',1);
    return $make_inv_no;
  }

  function getInvoiceNo($distribution_id = 0){
    $inv = InvoiceSetting::first();
    $distribution = DistributionOrder::where('id',$distribution_id)->first();

    return $inv['prefix'].$distribution['invoice_no'];
  }


  function getLocalInvoiceNo($distribution_id = 0){
    $inv = InvoiceSetting::first();
    $distribution = UserStockDistributionOrder::where('id',$distribution_id)->first();

    return $inv['prefix'].$distribution['invoice_no'];
  }