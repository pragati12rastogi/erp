@extends('layouts.master')
@section('title', 'Add Vendor')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            
            jQuery('#vendor_form').validate({ // initialize the plugin
                rules: {

                    
                    name:{
                        required:true,
                    },
                    email:{
                        required:true,
                    },
                    phone:{
                        required:true,
                    },
                    firm_name:{
                        required:true
                    },
                    
                    state_id:{
                        required:true
                    },
                    district:{
                        required:true
                    },
                    address:{
                        required:false
                    }
                },
                errorPlacement: function(error,element)
                {
                    if($(element).attr('type') == 'radio')
                    {
                        error.insertAfter(element.parent());
                    }
                    else if($(element).is('select'))
                    {
                        error.insertAfter(element.parent());
                    }
                    else{
                        error.insertAfter(element);
                    }
                        
                }
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
                <h4 class="card-title">Add Vendor</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('vendors')}}" class="btn btn-inverse-primary btn-sm"><i class="mdi mdi-redo-variant"></i>{{__("Back")}}</a>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <form id="vendor_form" method="post" enctype="multipart/form-data" action="{{url('vendors')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Vendor Name: <span class="required">*</span>
                            </label>
                            <input name="name" type="text" maxlength="255" value="{{old('name')}}" class="form-control text-capitalize" placeholder="Jhon Doe" >
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
                            <input name="email" type="email" maxlength="255" value="{{old('email')}}" class="form-control text-lowercase" placeholder="jhondoe@gmail.com" >
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
                            <input name="phone" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" value="{{old('phone')}}" class="form-control" placeholder="9999888777" >
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
                            <input name="firm_name" type="text" maxlength="255" value="{{old('firm_name')}}" class="form-control " placeholder="xyz Company" >
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
                            <input name="gst_no" type="text" maxlength="100" value="{{old('gst_no')}}" class="form-control" placeholder="123abcdefghijk" >
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
                            <input type="text" name="state" placeholder="Delhi" class="form-control text-capitalize">
                             
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
                            <input  type="text" name="district" value="{{old('district')}}" class="form-control">
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
                            <textarea rows="5" cols="10"  type="text" name="address" value="{{old('address')}}" class="form-control"></textarea>
                            <small class="txt-desc">(Please Enter Address)</small>
                            @error('address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
</div>
@endsection