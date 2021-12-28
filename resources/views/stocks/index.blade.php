@extends('layouts.master')
@section('title', 'Stock Summary')

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
                <h4 class="card-title">Stock Summary</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('stocks/create')}}" class="btn btn-inverse-primary btn-sm">{{__("Add Stock")}}</a>
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
                <th>Created By/Updated By</th>
                <th>Created At</th>
                
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($stocks as $key => $h)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$h->item->name}}</td>
                    <td>{{$h->prod_quantity}}</td>
                    <td>{{$h->price_for_user}}</td>
                    
                    
                    <td>{{!empty($h->created_by)?$h->created_by_user['name']:""}}  {{!empty($h->updated_by)?'/'.$h->updated_by_user->name :""}}</td>
                    <td>{{date('d-m-Y',strtotime($h->created_at))}}</td>
                    
                    <td>
                        <a href="{{url('stocks/'.$h->id.'/edit')}}" class="btn btn-success ">
                            <i class="mdi mdi-pen"></i>
                        </a>
                        <a onclick='return $("#{{$h->id}}_stocks").modal("show");' class="btn btn-danger text-white">
                            <i class=" mdi mdi-delete-forever"></i>
                        </a>
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
@foreach($stocks as $h)
    <div id="{{$h->id}}_stocks" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this stock? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/stocks/'.$h->id)}}" class="pull-right">
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