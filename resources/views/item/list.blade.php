<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-10">
                <h4 class="card-title">Item Summary</h4>
            </div>
            <div class="col-md-2 text-right" >
              @if(Auth::user()->hasPermissionTo('item.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                      
                <a onclick='return $("#item_add_modal").modal("show");' class="btn btn-inverse-primary btn-sm">{{__("Add Item")}}</a>
              @endif
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
                <th>Created By/Updated By</th>
                @if(Auth::user()->hasPermissionTo('item.edit') || Auth::user()->hasPermissionTo('item.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                <th>Action</th>
                @endif
                
              </tr>
            </thead>
            <tbody>
              @foreach($items as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->category->name}}</td>
                    <td>
                      @if(count($item->images)>0)
                        @if($item->images[0]['photo'] != '' && file_exists(public_path().'/uploads/items/'.$item->images[0]['photo']) )
                          <img class="img-thumbnail"  src="{{url('uploads/items/'.$item->images[0]['photo'])}}" title="{{ $item->name }}">
                        @endif
                      @endif
                    </td>
                    <td>
                        {{$item->hsn->hsn_no}}
                    </td>
                    <td>
                        {{$item->gst_percent->percent}} %
                    </td>
                    <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                    <td>{{!empty($item->created_by)?$item->created_by_user['name']:""}}{{!empty($item->updated_by)? '/'.$item->updated_by_user->name :'' }}</td>
                    
                    @if(Auth::user()->hasPermissionTo('item.edit') || Auth::user()->hasPermissionTo('item.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                    <td>
                      @if(Auth::user()->hasPermissionTo('item.edit') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                        <a onclick='return $("#{{$item->id}}_item_edit_modal").modal("show");' class="btn btn-success text-white">
                            <i class="mdi mdi-pen"></i>
                        </a>
                      @endif
                      @if(Auth::user()->hasPermissionTo('item.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                        <a onclick='return $("#{{$item->id}}_item").modal("show");' class="btn btn-danger text-white">
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