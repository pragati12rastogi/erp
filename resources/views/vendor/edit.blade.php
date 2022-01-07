@if(Auth::user()->hasPermissionTo('vendors.edit') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN) )
<div id="{{$vendor->id}}_vendor_edit_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content bg-inverse-light">
            <div class="modal-header">
                <h4 class="modal-heading">Add Vendor</h4>
                <button type="button" class="close m-0 p-0" data-dismiss="modal">&times;</button> 
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="vendor_form_{{$vendor->id}}" method="post" enctype="multipart/form-data" action="{{url('vendors/'.$vendor->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                            {{csrf_field()}}
                            {{ method_field('PUT') }}
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="first-name">
                                            Vendor Name: <span class="required">*</span>
                                        </label>
                                        <input name="name" type="text" maxlength="255" value="{{$vendor->name}}" class="form-control text-capitalize" placeholder="Jhon Doe" >
                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            Email: <span class="required">*</span>
                                        </label>
                                        <input name="email" type="email" maxlength="255" value="{{$vendor->email}}" class="form-control text-lowercase" placeholder="jhondoe@gmail.com" >
                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            Mobile: <span class="required">*</span>
                                        </label>
                                        <input name="phone" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" value="{{$vendor->phone}}" class="form-control" placeholder="9999888777" >
                                        @error('mobile')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="firm_name">
                                            Firm Name: <span class="required">*</span>
                                        </label>
                                        <input name="firm_name" type="text" maxlength="255" value="{{$vendor->firm_name}}" class="form-control " placeholder="xyz Company" >
                                        @error('firm_name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="gst_no">
                                            GST Number: 
                                        </label>
                                        <input name="gst_no" type="text" maxlength="100" value="{{$vendor->gst_no}}" class="form-control" placeholder="123abcdefghijk" >
                                        @error('gst_no')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="gst_no">
                                            State: <span class="required">*</span>
                                        </label>
                                        <input type="text" name="state" value="{{$vendor->state}}" class="form-control text-capitalize">
                                        
                                        <small class="txt-desc">(Please Enter State)</small>
                                        @error('state')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="district">
                                            District: <span class="required">*</span>
                                        </label>
                                        <input  type="text" name="district" value="{{$vendor->district}}" class="form-control">
                                        <small class="txt-desc">(Please Enter District)</small>
                                        @error('district')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="address">
                                            Address: 
                                        </label>
                                        <textarea rows="5" cols="10"  type="text" name="address" class="form-control">{{$vendor->address}}</textarea>
                                        <small class="txt-desc">(Please Enter Address)</small>
                                        @error('address')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="modal-footer">
                                
                                <button type="submit" class="btn btn-dark">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif