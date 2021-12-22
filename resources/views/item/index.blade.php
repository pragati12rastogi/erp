@extends('layouts.master')
@section('title', 'Item Summary')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#item_table").DataTable();
            
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
                <h4 class="card-title">Item Summary</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('item/create')}}" class="btn btn-inverse-primary btn-sm">{{__("Add Item")}}</a>
            </div>
        </div>
        
        <div class="table-responsive">
          <table id="item_table" class="table ">
            <thead>
              <tr>
                <th>Sr.no.</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Image</th>
                <th>HSN</th>
                <th>GST</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->category->name}}</td>
                    <td>
                        @if($item->image != '' && file_exists(public_path().'/uploads/items/'.$item->image) )
                          <img class="img-thumbnail"  src="{{url('uploads/items/'.$item->image)}}" title="{{ $item->name }}">
                        @endif
                    </td>
                    <td>
                        {{$item->hsn->hsn_no}}
                    </td>
                    <td>
                        {{$item->gst_percent->name}}({{$item->gst_percent->percent}} %)
                    </td>
                    <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                    
                    <td>
                        <a href="{{url('item/'.$item->id.'/edit')}}" class="btn btn-success ">
                            <i class="mdi mdi-pen"></i>
                        </a>
                        <a onclick='return $("#{{$item->id}}_item").modal("show");' class="btn btn-danger text-white">
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
@foreach($items as $item)
    <div id="{{$item->id}}_item" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this item? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/item/'.$item->id)}}" class="pull-right">
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