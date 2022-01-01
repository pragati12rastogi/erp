@extends('layouts.master')
@section('title', 'GST Summary')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#gst_table").DataTable();
            
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
                <h4 class="card-title">GST Summary</h4>
            </div>
            <div class="col-md-2 text-right" >
              @if(Auth::user()->hasPermissionTo('gst.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                      
                <a href="{{url('gst/create')}}" class="btn btn-inverse-primary btn-sm">{{__("Add GST")}}</a>
              @endif
            </div>
        </div>
        
        <div class="table-responsive">
          <table id="gst_table" class="table ">
            <thead>
              <tr>
                <th>Sr.no.</th>
                <th>Percentage</th>
                <th>Created At</th>
                <th>Created By/Updated By</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($gst as $key => $h)
                <tr>
                    <td>{{$key+1}}</td>
                    
                    <td>{{$h->percent}}</td>
                    
                    <td>{{date('d-m-Y',strtotime($h->created_at))}}</td>
                    <td>{{!empty($h->created_by)?$h->created_by_user['name']:""}}  {{!empty($h->updated_by)?'/'.$h->updated_by_user->name :""}}</td>
                    
                    <td>
                      @if(Auth::user()->hasPermissionTo('gst.edit') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                      
                        <a href="{{url('gst/'.$h->id.'/edit')}}" class="btn btn-success ">
                            <i class="mdi mdi-pen"></i>
                        </a>
                      @endif
                      @if(Auth::user()->hasPermissionTo('gst.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                      
                        <a onclick='return $("#{{$h->id}}_gst").modal("show");' class="btn btn-danger text-white">
                            <i class=" mdi mdi-delete-forever"></i>
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
@foreach($gst as $h)
    <div id="{{$h->id}}_gst" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this GST? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/hsn/'.$h->id)}}" class="pull-right">
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