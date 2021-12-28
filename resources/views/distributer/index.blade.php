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



@endsection