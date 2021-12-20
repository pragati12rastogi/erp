@extends('layouts.master')
@section('title', 'Role Summary')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#role_table").DataTable();
            
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
                <h4 class="card-title">Role Summary</h4>
            </div>
            <div class="col-md-2 text-right" >
              
              <a href="{{route('roles.create')}}" class="btn btn-inverse-primary btn-sm">{{__("Add Role")}}</a>
            </div>
        </div>
        
        <div class="table-responsive">
          <table id="role_table" class="table ">
            <thead>
              <tr>
                <th>Sr.No.</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($roles as $key => $role)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $role->name }}</td>
                <td>
                  @if(Auth::user()->hasPermissionTo('roles.edit') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                    <a class="btn btn-sm btn-success" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                  @endif
                  @if(Auth::user()->hasPermissionTo('users.index') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                    <a onclick='return $("#{{$role->id}}_role").modal("show");'  class="btn  btn-sm btn-danger text-white"> Delete </a>  
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
@foreach($roles as $key => $role)
    <div id="{{$role->id}}_role" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this Role? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{route('roles.destroy',$role->id)}}" class="pull-right">
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