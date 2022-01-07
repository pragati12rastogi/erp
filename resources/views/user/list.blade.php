<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-10">
                <h4 class="card-title">User Summary</h4>
            </div>
            
            @if(Auth::user()->hasPermissionTo('users.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
            <div class="col-md-2 text-right">  
              <button onclick='return $("#add_user_modal").modal("show");' class="btn btn-inverse-primary btn-sm">{{__("Add User")}}</button>
            </div>
              @endif
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
                    @if(Auth::user()->hasPermissionTo('users.edit') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                    <a onclick='return $("#{{$user->id}}_user_edit_modal").modal("show");' class="btn btn-success text-white">
                        <i class="mdi mdi-pen"></i>
                    </a>
                    @endif

                    @if(Auth::user()->hasPermissionTo('users.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                    
                    <a onclick='return $("#{{$user->id}}_user").modal("show");' class="btn btn-danger text-white">
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
