@extends('layouts.master')
@section('title', 'Local Stock Summary')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#stock_table").DataTable();
            
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
                <h4 class="card-title">Local Stock Summary</h4>
            </div>
            <div class="col-md-3 text-right" >
              @if(Auth::user()->hasPermissionTo('local-stock-distribution.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                <a href="{{url('local-stock-distribution/create')}}" class="btn btn-inverse-primary btn-sm">{{__("Create Local Distribution")}}</a>
              @endif
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