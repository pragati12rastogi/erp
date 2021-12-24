@extends('layouts.master')
@section('title', 'Add Stocks')

@push('style')

@endpush

@push('custom-scripts')
    {!! Html::script('/js/common.js') !!}
    <script>
        $(function() {
            $.validator.addMethod('decimal', function(value, element) {
            return this.optional(element) || /^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/.test(value);
            }, "Please enter a correct number, format 0.00");

            jQuery('#gst_form').validate({ // initialize the plugin
                rules: {
                    item_id:{
                        required:true,
                    },
                    percent:{
                        required:true,
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
                    else if($(element).attr('type') == 'number'){
                        error.insertAfter(element.parent());
                    }
                    else{
                        error.insertAfter(element);
                    }
                        
                }
            });
        });
        
        $("#prod_quantity, #prod_price, #total_price").keyup(function(){
            calculate_product();
        })
        function calculate_product(){
            var prod_quantity = $("#prod_quantity").val();
            var prod_price = $("#prod_price").val();

            var calc_total = parseInt(prod_quantity)*parseFloat(prod_price);
            
            var total_price = $("#total_price").val(calc_total);

        }

        $("#per_freight_price").change(function(){
            calculate_final_price();

            // var = '<div id="myModal" class="modal fade" role="dialog">'+
            //         '<div class="modal-dialog">'+
            //             '<div class="modal-content">'+
            //                 '<div class="modal-header">'+
            //                     '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
            //                     '<h4 class="modal-title">Modal Header</h4>'+
            //                 '</div>'+
            //                 '<div class="modal-body">'+
            //                     '<table class="table">'+
            //                         '<tr>'+
            //                             '<th></th>'
            //                         '</tr>'+
            //                         '<tr></tr>'+
            //                     '</table>'+
            //                 '</div>'+
            //                 '<div class="modal-footer">'+
            //                     '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
            //                 '</div>'+
            //             '</div>'+

            //         '</div>'+
            //     '</div>';
        })
        function calculate_final_price (){
            var per_freight_price = $("#per_freight_price").val();
            var prod_quantity = $("#prod_quantity").val();
            var total_price = $("#total_price").val();
            var total_price = $("#total_price").val();

            var calc_total = (parseInt(per_freight_price)*parseInt(prod_quantity))+parseInt(total_price);
            
            var final_price = $("#final_price").val(calc_total);
        }

        $("#user_percent").change(function(){
            var prod_price = $("#prod_price").val();
            var get_percent = parseFloat(prod_price)*(5/100);

            var user_price = (parseFloat(prod_price)+parseFloat(get_percent)).toFixed(2);
            $("#price_for_user").val(user_price);
        })
        
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
                <h4 class="card-title">Add Stocks</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('stocks')}}" class="btn btn-inverse-primary btn-sm"><i class="mdi mdi-redo-variant"></i>{{__("Back")}}</a>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <form id="gst_form" method="post" enctype="multipart/form-data" action="{{url('stocks')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Category: <span class="required">*</span>
                            </label>
                            <select name="category_id" class="form-control select2" id="category_id">
                                <option>Select Category</option>
                                @foreach($category as $cat_i => $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Items: <span class="required">*</span>
                            </label>
                            <select name="item_id" class="form-control select2" id="item_id">
                                <option>Select Items</option>
                                
                            </select>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12" id="item_details" >
                        <div class="row">
                            <div class="col-md-2" id="img_div">
                                <center>
                                    <img src="{{asset('images/no-image.jpg')}}" id="item_img" class="img-lg img-thumbnail" >
                                </center>
                                
                            </div>
                            <div class="col-md-4" id="img_div">
                                <label>GST :</label>
                                <select name="gst_id" id="gst_id" disabled class="form-control select2">
                                    <option value="">Select GST</option>
                                    @foreach($gsts as $gst_i => $gst)
                                    <option value="{{$gst->id}}">{{$gst->name}}({{$gst->percent}}%)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6" id="img_div">
                                <label>HSN :</label>
                                <select name="hsn_id" id="hsn_id" disabled class="form-control select2">
                                    <option value="">Select HSN</option>
                                    @foreach($hsn as $hid => $h)
                                    <option value="{{$h->id}}">{{$h->hsn_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Product Quantity: <span class="required">*</span>
                            </label>
                            <input type="number" value="0" min="0" name="prod_quantity" id="prod_quantity" class="form-control">
                            @error('prod_quantity')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Per Product Price: <span class="required">*</span>
                            </label>
                            <input type="number" value="0" min="0" name="prod_price" id="prod_price" class="form-control">
                            @error('prod_price')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Total Price: <span class="required">*</span>
                            </label>
                            <input type="number" readonly value="0" min="0" name="total_price" id="total_price" class="form-control">
                            @error('total_price')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Per Freight Charge: <span class="required">*</span>
                            </label>
                            <input type="number" value="0" min="0" name="per_freight_price" id="per_freight_price" class="form-control">
                            @error('per_freight_price')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                User Percent: <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" value="0" min="0" max="100" name="user_percent" id="user_percent" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text p-2">
                                    <i class="mdi mdi-percent"></i>
                                    </span>
                                </div>
                            </div> 
                            @error('user_percent')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Final Price: <span class="required">*</span>
                            </label>
                            <input type="number" value="0" min="0"  name="final_price" id="final_price" class="form-control">
                            @error('final_price')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Price For User: <span class="required">*</span>
                            </label>
                            <input type="number" value="0" min="0"  name="price_for_user" id="price_for_user" class="form-control">
                            @error('price_for_user')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Date Of Purchase: <span class="required">*</span>
                            </label>
                            <input type="date" name="date_of_purchase" id="date_of_purchase" class="form-control">
                            @error('date_of_purchase')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Select Vendor: <span class="required">*</span>
                            </label>
                            <select name="vendor_id" class="form-control select2" id="vendor_id">
                                <option>Select Vendor</option>
                                @foreach($vendor as $v_id => $v)
                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                @endforeach
                            </select>
                            @error('vendor_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Description: 
                            </label>
                            <textarea name="description" class="form-control" id="description"></textarea>
                            @error('description')
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