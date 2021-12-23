@extends('layouts.master')
@section('title', 'User Summary')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#user_table").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                    extend:'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2,3,4 ] 
                    }
                    }
                ]
            });
            
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
                <h4 class="card-title">User Summary</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('users/create')}}" class="btn btn-inverse-primary btn-sm">{{__("Add User")}}</a>
            </div>
        </div>
        
        <div class="table-responsive">
          <table id="user_table" class="table ">
            <thead>
              <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Firm Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Created By/Updated By</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr>
                  <td>{{$user->name}}</td>
                  <td>{{$user->role->name}}</td>
                  <td>{{$user->firm_name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->mobile}}</td>
                  <td>{{date('Y-m-d',strtotime($user->created_at))}}</td>

                  <td>
                    
                    {{!empty($user->created_by)?$user->created_by_user->name:''}}{{!empty($user->updated_by)? '/'.$user->updated_by_user->name:'' }}</td>
                    
                  <td>
                    <form action="{{ route('user.status.update',$user->id) }}" method="POST">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-xs {{$user->status?'btn-success':'btn-danger'}}">
                        {{$user->status?'Active':'Deactive'}}
                        </button>
                    </form>
                  </td>
                  <td>
                    <a onclick='return $("#{{$user->id}}_user").modal("show");' class="btn btn-danger text-white">
                        <i class=" mdi mdi-delete-forever"></i>
                    </a>
                    <a  href="{{url('users/'.$user->id.'/edit')}}" class="btn btn-success ">
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
@foreach($users as $user)
    <div id="{{$user->id}}_user" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this User? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/users/'.$user->id)}}" class="pull-right">
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