@extends('layouts.master')
@section('title', 'Invoice -'.$inv_no)

@push('style')

@endpush

@push('custom-scripts')
    <script>
        
        

    </script>
@endpush

@section('content')
<div class="row">

  <div class="col-lg-12 grid-margin stretch-card">
      
    <div class="card">
    @include('flash-msg')
    
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-11">
                <h4 class="card-title">Invoice - {{$inv_no}}</h4>
            </div>
            <div class="col-md-1" id="hide-div">
                <iframe src="{{route('print.invoice',$dis->id)}}" style="display:none;" name="frame"></iframe>

                <button title="Print Order" onclick="frames['frame'].print()" class="btn btn-dark btn-block">
                <i class="m-0 mdi mdi-printer"></i>
                </button>
            </div>
        </div>
        
        <div class="row" id="printarea">
          <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>
                                <b>Date:</b> {{ date('d-m-Y',strtotime($dis->created_at)) }}
                            </th>
                            
                            <th>
                                <b>Invoice ID:</b> {{$inv_no}}
								
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <th>
								<b>Seller Details</b>
							</th>

							<th></th>

							<th>
								<b>Billing Details</b>
							</th>
                        </tr>
                        <tr>
							<td colspan="2">
								<b>{{ $dis->created_by_user->firm_name }},</b>
								<br><br>
								{{  $dis->created_by_user->address }},
								<br>
                                {{  $dis->created_by_user->district }},{{  $dis->created_by_user->state->name }},
                                <br>
                                {{ $dis->created_by_user->email }}
                                <br>
                                {{ $dis->created_by_user->mobile }}
							</td>
                            <td>
                                <b>{{ $dis->user->firm_name }},</b>
								<br><br>
								{{  $dis->user->address }},
								<br>
                                {{  $dis->user->district }},{{  $dis->user->state->name }},
                                <br>
                                {{ $dis->user->email }}
                                <br>
                                {{ $dis->user->mobile }}
								
							</td>
                        </tr>
                        
                    </tbody>
                </table>
                <table class="table table-bordered">
					<thead>
						<tr>
							<th>Item</th>
							<th>Qty</th>
							<th>Price</th>
							<th>TAX</th>
							<th>Total</th>
                            <th>Action</th>
						</tr>
					</thead>

					<tbody>
                        @foreach($dis->invoices as $in => $inv)
						<tr>
                            <td>
                                <b>{{$inv->item->name}}</b>
                                <br>
                                @php
                                    $tax = ($inv->product_price * $inv->item->gst_percent->percent)/100;
                                    $single_price = $inv->product_price-$tax;
                                @endphp
                                <small class="tax"><b>Price:</b> Rs.
									{{ number_format((float)$single_price, 2, '.', '')}}
								</small>
                                <small class="tax"><b>Tax:</b> Rs.
                                    
                                    {{ number_format((float)$tax , 2, '.', '')}}
                                    
                                </small>
                                <br>
								<small class="help-block">(Displayed for single Qty.)</small>
                            </td>
                            <td valign="middle">
								{{ $inv->distributed_quantity }}
							</td>
                            <td>
                                <p><b>Price:</b> Rs.
                                    
                                    {{ round(($single_price*$inv->distributed_quantity),2) }}</p>
                                
                                <small class="help-block">(Price Multiplied with Qty.)</small>
							</td>
                            <td>

								@if(!empty($inv->igst) )
		                          <p>Rs. {{ sprintf("%.2f",$inv->igst) }} (IGST)</p>
		                        @endif
								@if(!empty($inv->scgst))
									<p>Rs. {{ sprintf("%.2f",$inv->scgst) }} (SGST)</p>
                                    <p>Rs. {{ sprintf("%.2f",$inv->scgst) }} (CGST)</p>
								@endif
								<small class="help-block">(Tax Multiplied with Qty.)</small>
                            </td>
                            <td>
								Rs.
								
									{{ round($inv->product_total_price,2) }}
								<br>
								<small class="help-block">(Incl. of Tax )</small>
							</td>
                            <td>
                                <a title="Print Single Product" target="_blank" href="{{route('print.singleinvoice',$inv->id)}}" class="btn btn-dark ">
                                    <i class="m-0 mdi mdi-printer"></i>
                                </a>
                                @if(Auth::user()->hasPermissionTo('stock-distributions.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                                    @if(empty($inv->is_cancelled))
                                        <a onclick='return $("#{{$inv->id}}_cancel").modal("show");' class="btn btn-danger text-white">
                                        Cancel
                                        </a>
                                    @else
                                        <b>Status:</b> Cancelled / <b>By:</b> {{!empty($inv->updated_by)? $inv->updated_by_user->name:''}} 
                                    @endif
                                @endif

                                
                            </td>
                        </tr>
                        @endforeach
                        <tr>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<b>Grand Total:</b>
							</td>
							<td>
                            Rs.
                            {{ round($dis->total_cost,2) }}
							</td>
						</tr>
                    </tbody>
                </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@foreach($dis->invoices as $did =>$dv)
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
            <form method="post" action="{{url('/stock-distributions/'.$dv->id)}}" class="pull-right">
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