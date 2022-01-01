@extends('layouts.master')
@section('title', 'Distribution Summary')

@push('style')

@endpush

@push('custom-scripts')
    {!! Html::script('/js/admin_distributer.js') !!}
    <script>
        $(function() {
            $("#distribution_table").DataTable();
            
        });
        
    </script>
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
    @include('flash-msg')
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-9">
                <h4 class="card-title">Distribution Summary</h4>
            </div>
            <div class="col-md-3 text-right" >
              @if(Auth::user()->hasPermissionTo('stock-distributions.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                <a href="{{url('stock-distributions/create')}}" class="btn btn-inverse-primary btn-sm">{{__("Create Stock Distribution")}}</a>
              @endif
            </div>
        </div>
        
        <div class="table-responsive">
          <table id="distribution_table" class="table ">
            <thead>
              <tr>
                
                <th>Invoice No.</th>
                <th>User Name</th>
                <th>Total Amount</th>
                <th>Created At</th>
                <th>Created By</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($distribution as $did =>$dv)
                <tr>
                  
                  <td>{{getInvoiceNo($dv->id)}}</td>
                  <td>{{$dv->user->name}}</td>
                  
                  <td> Rs. {{$dv->total_cost}}</td>
                  <td>{{date('d-m-Y',strtotime($dv->created_at))}}</td>
                  <td>{{$dv->created_by_user->name}}</td>
                  <td>
                    @if(Auth::user()->hasPermissionTo('stock-distributions.show') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                    <a href="{{url('stock-distributions/'.$dv->id)}}" class="btn btn-success ">
                      Invoice
                    </a>
                    @endif
                    @if(Auth::user()->hasPermissionTo('stock-distributions.payment') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                    
                    <a onclick='return $("#{{$dv->id}}_pay").modal("show");'  class="btn  btn-warning text-white"> Pay </a>  
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@foreach($distribution as $did =>$dv)
    <div id="{{$dv->id}}_pay" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-heading">Payment</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
            <div class="modal-body text-center">
              <div class="col-md-12">
                @php
                  $total_item_amount =0;
                  $total_cancel_amount = 0;
                  foreach($dv->invoices as $inv => $in){
                    if($in->is_cancelled ){
                      $total_cancel_amount +=  $in->product_total_price;
                    }else{
                      $total_item_amount +=  $in->product_total_price;
                      
                    }
                  }
                  $paid_amt = 0;
                  foreach($dv->payment as $pid => $p){
                    $paid_amt += $p->amount;
                  }

                @endphp
                <form id="payment_form" method="post" action="{{route('distribution.payment')}}">
                  @csrf
                  <div class="row">
                    <div class="col-md-3 text-left text-small">
                      <label><b> Total Order Amount :</b></label>
                      <span> Rs. {{$dv->total_cost}}</span>
                    </div>
                    <div class="col-md-3 text-left text-small">
                      <label><b> Total Item Amount :</b></label>
                      <span> Rs. {{$total_item_amount}}</span>
                    </div>
                    <div class="col-md-3 text-left text-small">
                      <label>
                      <b> Total Cancel Item Amount :</b>
                      </label>
                      <span> Rs. {{$total_cancel_amount}}</span>
                    </div>
                    <div class="col-md-3 text-left text-small">
                      <label>
                      <b> Pending Payment:</b>
                      </label>
                      <span> Rs. {{($total_item_amount-$paid_amt<0)? abs($total_item_amount-$paid_amt)."(Extra amt paid)":$total_item_amount-$paid_amt}}</span>
                    </div>
                  </div>
                  <hr>
                  <div class="row text-left">
                    <input type="hidden" name="admin_order_id" value="{{Crypt::encrypt($dv->id)}}">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="first-name">
                          Amount: <span class="required">*</span>
                        </label>
                        <input type="number" name="amount" id="amount" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="first-name">
                          Transaction Type: <span class="required">*</span>
                        </label>
                        <select name="transaction_type" id="transaction_type" class="form-control select2">
                          <option value="">Select transaction method</option>
                          <option value="cash">Cash</option>
                          <option value="online">Online</option>
                          <option value="cheque">Cheque</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6" id="online_div" style="display:none">
                      <div class="form-group">
                        <label class="control-label" for="first-name">
                          Transaction ID: <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" name="transaction_id">
                      </div>
                    </div>
                    <div class="col-md-12" id="cheque_div" style="display:none">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label" for="first-name">
                              Cheque Number: <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" name="cheque_no">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label" for="first-name">
                              Bank Name: <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" name="bank_name">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label" for="first-name">
                              IFSC: <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" name="ifsc">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label" for="first-name">
                              Account Owner Name: <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" name="account_name">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success translate-y-3" id="modal-submit" >Submit</button>
            </form>
              <button type="reset" class="btn btn-inverse-dark translate-y-3" data-dismiss="modal">cancel</button>
              
            </div>
        </div>
        </div>
    </div>
@endforeach

@endsection