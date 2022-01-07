@extends('layouts.master')
@section('title', 'Local Stock Summary')

@push('style')
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>
@endpush

@push('custom-scripts')
  {!! Html::script('/js/user_distributer.js') !!}
    <script>
        $(function() {
            $("#stock_table").DataTable({
              "order":[[0,'desc']]
            });
            
            @foreach($given_distribution as $did =>$dv)
              jQuery('#payment_form_{{$dv->id}}').validate({ // initialize the plugin
                rules: {
                    transaction_type:{
                      required:true,
                    },
                    amount:{
                      required:true,
                    },
                    transaction_id:{
                      required:true,
                    },
                    cheque_no:{
                      required:true,
                    },
                    bank_name:{
                      required:true
                    },
                    ifsc:{
                      required:true
                    },
                    account_name:{
                      required:true
                    }
                },
                errorPlacement: function(error,element)
                {
                    if($(element).attr('type') == 'radio')
                    {
                        error.insertAfter(element.parent());
                    }
                    else if($(element).is('select'))
                    {
                        error.insertAfter(element.parent());
                    }
                    else{
                        error.insertAfter(element);
                    }
                        
                }
              });
            @endforeach
        });
        
    </script>
@endpush

@section('content')
<div class="row">
  <div class="col-md-2 mb-2">
    <div class="card card-inverse-info">
      <div class="card-header">
        Selling Amount
      </div>
      <div class="card-body p-3">Rs. {{empty($sell['sum_sell'])? 0:$sell['sum_sell']}}</div>
    </div>
  </div>

  <div class="col-md-2 mb-2">
    <div class="card card-inverse-info">
      <div class="card-header">Receive Amount</div>
      <div class="card-body p-3">Rs. {{empty($recieve['sum_recieve'])? 0:$recieve['sum_recieve']}}</div>
    </div>
  </div>
  <div class="col-md-2 mb-2">
    <div class="card card-inverse-info">
      <div class="card-header">Balance Amount</div>
      @php
        $sale = (float) $sell['sum_sell'];
        $recieve = (float) $recieve['sum_recieve'];
      @endphp
      <div class="card-body p-3">Rs. {{$sale-$recieve}}</div>
    </div>
  </div> 
  
  <div class="col-lg-12">
  @include('flash-msg')
  </div>
  @if(Auth::user()->hasPermissionTo('local-stock-distribution.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
    @include('user_stock.local_distribution_creation')
  @endif

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-9">
                <h4 class="card-title">Local Stock Summary</h4>
            </div>
            
        </div>
        
        <div class="table-responsive">
            <table id="stock_table" class="table ">
                <thead>
                    <tr>
                    <th>Invoice No.</th>
                    <th>User Name</th>
                    <th>Phone</th>
                    <th>Total Amount</th>
                    <th>Created At</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($given_distribution as $key => $h)
                    <tr>
                        <td>{{getLocalInvoiceNo($h->id)}}</td>
                        <td>{{$h->user_name}}</td>
                        <td>{{$h->phone}}</td>
                        <td>Rs. {{$h->total_cost}}</td>
                        <td>{{date('d-m-Y',strtotime($h->created_at))}}</td>
                        <td>
                        @if(Auth::user()->hasPermissionTo('local-stock-distribution.show'))
                            <a href="{{url('local-stock-distribution/'.$h->id)}}" class="btn btn-success ">
                            Invoice
                            </a>
                        @endif
                        
                        @if(Auth::user()->hasPermissionTo('local-stock-distribution.destroy') )
                            @if(empty($h->is_cancelled))
                              @if(Auth::user()->hasPermissionTo('local-stock-distribution.payment'))
                              <a onclick='return $("#{{$h->id}}_pay").modal("show");'  class="btn  btn-warning text-white"> Pay </a>  
                              @endif
                              <a onclick='return $("#{{$h->id}}_cancel").modal("show");' class="btn btn-danger text-white">
                              Cancel
                              </a>
                            @else
                                <b>Status:</b> Cancelled / <b>By:</b> {{!empty($h->updated_by)? $h->updated_by_user->name:''}} 
                            @endif
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
@foreach($given_distribution as $did =>$dv)
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
                  
                  $paid_amt = 0;
                  foreach($dv->payment as $pid => $p){
                    $paid_amt += $p->amount;
                  }

                @endphp
                <form id="payment_form_{{$dv->id}}" method="post" action="{{route('local.distribution.payment')}}">
                  @csrf
                  <div class="row">
                    <div class="col-md-3 text-left text-small">
                      <label><b> Total Order Amount :</b></label>
                      <span> Rs. {{$dv->total_cost}}</span>
                    </div>
                    <div class="col-md-3 text-left text-small">
                      <label><b> Total Amount Paid :</b></label>
                      <span> Rs. {{$paid_amt}}</span>
                    </div>
                    <div class="col-md-3 text-left text-small">
                      <label>
                      <b> Pending Payment:</b>
                      </label>
                      <span> Rs. {{($dv->total_cost-$paid_amt<0)? abs($dv->total_cost-$paid_amt)."(Extra amt paid)":$dv->total_cost-$paid_amt}}</span>
                    </div>
                  </div>
                  <hr>
                  <div class="row text-left">
                    <input type="hidden" name="local_order_id" value="{{Crypt::encrypt($dv->id)}}">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="first-name">
                          Amount: <span class="required">*</span>
                        </label>
                        <input type="number" max="{{$dv->total_cost-$paid_amt}}" name="amount" id="amount" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="first-name">
                          Transaction Type: <span class="required">*</span>
                        </label>
                        <select name="transaction_type" data-type="{{$dv->id}}" class="form-control select2 transaction_type">
                          <option value="">Select transaction method</option>
                          <option value="cash">Cash</option>
                          <option value="online">Online</option>
                          <option value="cheque">Cheque</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6" id="online_div_{{$dv->id}}" style="display:none">
                      <div class="form-group">
                        <label class="control-label" for="first-name">
                          Transaction ID: <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" name="transaction_id">
                      </div>
                    </div>
                    <div class="col-md-12" id="cheque_div_{{$dv->id}}" style="display:none">
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

    <div id="{{$dv->id}}_cancel" class="delete-modal modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to Cancel this product from stock distribution? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/local-stock-distribution/'.$dv->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                                
                            
            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
            </form>
            </div>
        </div>
      </div>
    </div>
@endforeach


@endsection