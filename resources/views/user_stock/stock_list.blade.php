@extends('layouts.master')
@section('title', 'User Stock Summary')

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
            <div class="col-md-10">
                <h4 class="card-title">User Stock Summary</h4>
            </div>
            
        </div>
        
        <div class="table-responsive">
          <table id="stock_table" class="table ">
            <thead>
              <tr>
                <th>Sr.no.</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                
              </tr>
            </thead>
            <tbody>
              @foreach($user_stock as $key => $h)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$h->item->name}}</td>
                    <td>{{$h->prod_quantity}}</td>
                    <td>{{$h->price}}</td>
                    
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