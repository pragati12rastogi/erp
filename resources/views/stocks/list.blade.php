<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-10">
                <h4 class="card-title">Stock Summary</h4>
            </div>
            @if(Auth::user()->hasPermissionTo('stocks.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
              
            <div class="col-md-2 text-right" >
                <a onclick='return $("#stock_add_modal").modal("show");' class="btn btn-inverse-primary btn-sm">{{__("Add Stock")}}</a>
            </div>
            @endif
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
                @if(Auth::user()->hasPermissionTo('stocks.edit') || Auth::user()->hasPermissionTo('stocks.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                <th>Action</th>
                @endif
                
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
                    
                    @if(Auth::user()->hasPermissionTo('stocks.edit') || Auth::user()->hasPermissionTo('stocks.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                      <td>
                        @if(Auth::user()->hasPermissionTo('stocks.edit') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
              
                        <a onclick="edit_stock_modal('{{$h->id}}')" class="btn btn-success text-white">
                            <i class="mdi mdi-pen"></i>
                        </a>
                        @endif
                        @if(Auth::user()->hasPermissionTo('stocks.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
              
                        <a onclick='return $("#{{$h->id}}_stocks").modal("show");' class="btn btn-danger text-white">
                            <i class=" mdi mdi-delete-forever"></i>
                        </a>
                        @endif

                        <a onclick="return $('#{{$h->id}}_stock_history').modal('show');" class="btn btn-warning text-white">
                            History
                        </a>
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