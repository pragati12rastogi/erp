<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
    
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-10">
                <h4 class="card-title">Expense Summary</h4>
            </div>
            @if(Auth::user()->hasPermissionTo('expenses.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN) )
            <div class="col-md-2 text-right" >
              <button onclick='return $("#add_expense_modal").modal("show");' class="btn btn-inverse-primary btn-sm">{{__("Add Expense")}}</button>
            </div>
            @endif
        </div>
        
        <div class="table-responsive">
          <table id="expense_table" class="table ">
            <thead>
              <tr>
                <th>Sr.no.</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Date Time</th>
                <th>Created By</th>
                @if(Auth::user()->hasPermissionTo('expenses.edit') || Auth::user()->hasPermissionTo('expenses.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                <th>Action</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach($expenses as $key => $e)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$e->name}}</td>
                    <td>{{$e->amount}}</td>
                    
                    <td>{{date('d-m-Y h:i A',strtotime($e->datetime))}}</td>
                    <td>{{!empty($e->created_by)?$e->created_by_user['name']:""}}</td>
                    
                    @if(Auth::user()->hasPermissionTo('expenses.edit') || Auth::user()->hasPermissionTo('expenses.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                
                    <td>
                      @if(Auth::user()->hasPermissionTo('expenses.edit') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                      
                        <a onclick='edit_expense_modal("{{$e->id}}")' class="btn btn-success text-white">
                            <i class="mdi mdi-pen"></i>
                        </a>
                      @endif
                      @if(Auth::user()->hasPermissionTo('expenses.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                      
                        <a onclick='return $("#{{$e->id}}_expense").modal("show");' class="btn btn-danger text-white">
                            <i class=" mdi mdi-delete-forever"></i>
                        </a>
                      @endif
                    </td>
                    @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
