@extends('layouts.master')
@section('title', 'Vendor Summary')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#vendor_table").DataTable();
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
                <h4 class="card-title">Vendor Summary</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('vendors/create')}}" class="btn btn-inverse-primary btn-sm">{{__("Add Vendor")}}</a>
            </div>
        </div>
        
        <div class="table-responsive">
          <table id="vendor_table" class="table ">
            <thead>
              <tr>
                <th>Name</th>
                <th>Firm Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Created By/Updated By</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($vendors as $vendor)
              <tr>
                  <td>{{$vendor->name}}</td>
                  <td>{{$vendor->firm_name}}</td>
                  <td>{{$vendor->email}}</td>
                  <td>{{$vendor->phone}}</td>
                  <td>{{date('Y-m-d',strtotime($vendor->created_at))}}</td>
                  <td>
                    
                    {{!empty($vendor->created_by)?$vendor->created_by_user->name:''}}{{!empty($vendor->updated_by)? '/'.$vendor->updated_by_user->name:'' }}</td>
                    
                  <td>
                    <a onclick='return $("#{{$vendor->id}}_vendor").modal("show");' class="btn btn-danger text-white">
                        <i class=" mdi mdi-delete-forever"></i>
                    </a>
                    <a  href="{{url('vendors/'.$vendor->id.'/edit')}}" class="btn btn-success ">
                        <i class="mdi mdi-pen"></i>
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
@foreach($vendors as $vendor)
    <div id="{{$vendor->id}}_vendor" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this vendor? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/vendors/'.$vendor->id)}}" class="pull-right">
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