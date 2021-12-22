@extends('layouts.master')
@section('title', 'Category Summary')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#category_table").DataTable();
            
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
                <h4 class="card-title">Category Summary</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('category/create')}}" class="btn btn-inverse-primary btn-sm">{{__("Add Category")}}</a>
            </div>
        </div>
        
        <div class="table-responsive">
          <table id="category_table" class="table ">
            <thead>
              <tr>
                <th>Sr.no.</th>
                <th>Name</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($category as $key => $cat)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$cat->name}}</td>
                    
                    <td>
                      @if($cat->image != '' && file_exists(public_path().'/uploads/category/'.$cat->image) )
                          <img class="img-thumbnail"  src="{{url('uploads/category/'.$cat->image)}}" title="{{ $cat->name }}">
                      @endif
                    </td>
                    
                    <td>{{date('d-m-Y',strtotime($cat->created_at))}}</td>
                    
                    <td>
                        <a href="{{url('category/'.$cat->id.'/edit')}}" class="btn btn-success ">
                            <i class="mdi mdi-pen"></i>
                        </a>
                        <a onclick='return $("#{{$cat->id}}_cat").modal("show");' class="btn btn-danger text-white">
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
@foreach($category as $cat)
    <div id="{{$cat->id}}_cat" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this category? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/category/'.$cat->id)}}" class="pull-right">
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