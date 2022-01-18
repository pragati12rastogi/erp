<div class="col-lg-12 grid-margin stretch-card">
    
    <div class="card">


        <div class="card-body">
            <div class="border-bottom mb-3 row">
                <div class="col-md-10">
                    <h4 class="card-title">Create Stock Distribution</h4>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <form id="admindistributer_form" method="post" enctype="multipart/form-data" action="{{url('stock-distributions')}}" data-parsley-validate class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    
                    <div class="row">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="first-name">
                                    Select Role: <span class="required">*</span>
                                </label>
                                <select name="role_id" id="role_id" class="form-control select2" >
                                    <option value=""> Select Role </option>
                                    @foreach( $roles as $r_ind => $r)
                                        <option value = "{{$r->id}}">{{$r->name}}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="first-name">
                                    Select User: <span class="required">*</span>
                                </label>
                                <select name="user_id" id="user_id" class="form-control select2" onchange="get_charge_of_item()">
                                    <option value=""> Select User </option>
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label></label><br>
                            <button type="button" class="btn btn-block btn-dark mt-2" onclick="return $('#products_model').modal('show');">Add Product</button>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="prod" id="prod" style="opacity: 0;">
                        </div>

                        <div class="col-md-12" id="prod-append-div">

                        </div>

                    </div>
                    
                    <div class="col-xs-12 ">
                        <hr>
                        <button type="submit" class="btn btn-dark mt-3">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="products_model" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
            <div class="table-responsive">
                <table id="item_table" class="table ">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Charge</th>
                        <th>Quantity</th>
                        <th>Add</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key => $item)
                        <tr>
                            <td><input type="checkbox" id="checkbox_{{$item->id}}" class="multiple_item_select" value="{{$item->id}}"></td>
                            
                            <td>{{$item->category->name}}
                            <input type="hidden" id="modal_prod_cat_{{$item->id}}" value="{{$item->category->name}}">
                            </td>
                            <td>{{$item->name}}
                            <input type="hidden" id="modal_prod_name_{{$item->id}}" value="{{$item->name}}">
                            </td>
                            
                            <td>
                                Rs. {{$item->stock->price_for_user}}
                                <input type="hidden" id="modal_prod_price_{{$item->id}}" value="{{$item->stock->price_for_user}}">
                            </td>
                            <td>
                                Rs. <span id="text_prod_charge_{{$item->id}}">0</span>
                                <input type="hidden" id="modal_prod_charge_{{$item->id}}" value="0">
                            </td>
                            <td>
                                {{$item->stock->prod_quantity}}
                                <input type="hidden" id="modal_prod_qty_{{$item->id}}" value="{{$item->stock->prod_quantity}}">
                            </td>
                            
                            <td>

                                <div class="d-flex">
                                    <button type="button" class="inc_dec_btn btn btn-dark btn-rounded">-</button>
                                    <input type="number" value="0" min="0" max="{{$item->stock->prod_quantity}}" class="form-control col-md-2 ml-2 mr-2" id="item_prod_{{$item->id}}" onchange="qty_change_func(this)">
                                    <button type="button" class="inc_dec_btn btn btn-dark btn-rounded">+</button>
                                    
                                </div>
                                <span class="error d-flex" id="qty_err_{{$item->id}}"></span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row bg-inverse-primary p-1">
                <div class="col-md-6">
                    <label class="m-0">Total Price:</label> <span id="modal_total_price"></span><br>
                    <label class="m-0">Total Charge:</label> <span id="modal_total_charge"></span>
                </div>
                <div class="col-md-6">
                    <label class="m-0">Total Quantity:</label><span id="modal_total_quantity"></span><br>
                    <label class="m-0">Final Price:</label><span id="modal_final_price"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            
            <button type="button" class="btn btn-success translate-y-3" id="modal-submit" >Submit</button>
            <button type="reset" class="btn btn-inverse-dark translate-y-3" data-dismiss="modal">Cancel</button>
        </form>
        </div>
    </div>
    </div>
</div>
