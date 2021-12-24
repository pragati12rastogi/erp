@extends('layouts.master')
@section('title', 'Distribution Summary')

@push('style')

@endpush

@push('custom-scripts')
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
                <a href="{{url('stock-distributions/create')}}" class="btn btn-inverse-primary btn-sm">{{__("Create Stock Distribution")}}</a>
            </div>
        </div>
        
        <div class="table-responsive">
          <table id="distribution_table" class="table ">
            <thead>
              <tr>
                
                <th>Invoice No.</th>
                <th>User Name</th>
                <th>Item</th>
                <th>Product Quantity</th>
                <th>Product Amount</th>
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
                  <td>{{$dv->item->name}}</td>
                  <td>{{$dv->distributed_quantity}}</td>
                  <td> Rs. {{$dv->product_price}}</td>
                  <td> Rs. {{$dv->total_cost}}</td>
                  <td>{{date('d-m-Y',strtotime($dv->created_at))}}</td>
                  <td>{{$dv->created_by_user->name}}</td>
                  <td>
                    <a href="{{url('stock-distributions/'.$dv->id)}}" class="btn btn-success ">
                      Invoice
                    </a>
                    @if(empty($dv->is_cancelled))
                    <a onclick='return $("#{{$dv->id}}_cancel").modal("show");' class="btn btn-danger text-white">
                      Cancel
                    </a>
                    @else
                      <span class="badge-danger badge-pill">Cancelled</span>
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
            <p>Do you really want to Cancel this stock distribution? This process cannot be undone.</p>
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