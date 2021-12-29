@extends('layouts.master')
@section('title', 'Create Local Distribution')

@push('style')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
@endpush

@push('custom-scripts')
    
    <script>
        $(function() {
            $("#item_table").DataTable({
                "lengthChange": false
            });

            jQuery('#hsn_form').validate({ // initialize the plugin
                rules: {
                    user_name:{
                        required:true,
                    },
                    phone:{
                        required:true,
                    },
                    'address':{
                        required:true,
                    },
                    'prod':{
                        required:true,
                    }

                },
                messages:{
                    prod: "Add products for distribution"
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

        
        
        $(".inc_dec_btn").on('click',function(){
            var $button = $(this);
            var oldValue = $button.parent().find("input").val();

            var maxValue = $button.parent().find("input").attr('max');
            if ($button.text() == "+") {
                if(oldValue < maxValue){
                    var newVal = parseFloat(oldValue) + 1;
                }else{
                    newVal = maxValue;
                }
                
            } else {
                // Don't allow decrementing below zero
                if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
                } else {
                newVal = 0;
                }
            }

            $button.parent().find("input").val(newVal);
            calculate_all_select();
        })


        $(".multiple_item_select").on('click',function(){
            calculate_all_select();
        })

       

        function calculate_all_select(){
            var prod_price = 0;
            var prod_qty = 0;
            $(".multiple_item_select:checkbox:checked").each(function () {
                
                var checkbox_id = $(this).val();

                var price = $('#modal_prod_price_'+checkbox_id).val();
                var max_qty = $('#modal_prod_qty_'+checkbox_id).val();
                var qty = $('#item_prod_'+checkbox_id).val();
                
                if(parseInt(max_qty) < parseInt(qty)){
                    $("#qty_err_"+checkbox_id).text('Maximum qty is :'+max_qty);
                }else{
                    $("#qty_err_"+checkbox_id).text('');
                }
                prod_price += (parseFloat(price) * parseInt(qty));

                prod_qty += parseInt(qty);

            });

            $("#modal_total_price").text(prod_price.toFixed(2));
            $("#modal_total_quantity").text(prod_qty);
        }

        function modal_submit(){

            $("#prod-append-div").empty();

            var grand_total =0;
            var tr ='';
            $(".multiple_item_select:checkbox:checked").each(function () {
                
                
                var checkbox_id = $(this).val();

                var price = $('#modal_prod_price_'+checkbox_id).val();
                var max_qty = $('#modal_prod_qty_'+checkbox_id).val();
                var qty = $('#item_prod_'+checkbox_id).val();

                if(parseInt(max_qty) < parseInt(qty)){
                    $("#qty_err_"+checkbox_id).text('Maximum qty is :'+max_qty);
                    
                }else{
                    $("#qty_err_"+checkbox_id).text('');
                    var total_price = (parseFloat(price) * parseInt(qty));

                    grand_total += parseFloat(total_price);
                    tr += '<tr><td> <input type="hidden" value="'+qty+'" name="item['+checkbox_id+']">'+
                        $('#modal_prod_cat_'+checkbox_id).val()+'</td>'+
                        '<td>'+$('#modal_prod_name_'+checkbox_id).val()+'</td>'+
                        '<td> Rs. '+price+'</td>'+
                        '<td> '+qty+'</td>'+
                        '<td> Rs. '+total_price.toFixed(2)+'</td>'+
                    '</tr>' ;
                }
                
            });

            tr += '<tr><td colspan="4"><b>Grand Total:</b></td><td> Rs. '+grand_total.toFixed(2)+'</td></tr>';

            var table = '<table class="table">'+
                '<thead>'+
                    '<tr>'+
                        '<th>Category</th>'+
                        '<th>Item</th>'+
                        '<th>Price</th>'+
                        '<th>Quantity</th>'+
                        '<th>Total</th>'+
                    '</tr>'+
                '</thead>'+
                '<tbody>'+
                    tr
                '</tbody>'+
            '</table>';
            
            $("#prod-append-div").append(table);
            $("#products_model").modal('hide');
            $("#prod").val(1);
        }

        $("#modal-submit").on("click",function(){
            modal_submit();
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
                <h4 class="card-title">Create Local Distribution</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('local-stock-distribution')}}" class="btn btn-inverse-primary btn-sm"><i class="mdi mdi-redo-variant"></i>{{__("Back")}}</a>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <form id="hsn_form" method="post" enctype="multipart/form-data" action="{{url('local-stock-distribution')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                User Name: <span class="required">*</span>
                            </label>
                            <input type="text" name="user_name" class="form-control text-capitalize" >
                            @error('user_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Mobile: <span class="required">*</span>
                            </label>
                            <input type="text" name="phone" class="form-control " oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" >
                            @error('phone')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Address: <span class="required">*</span>
                            </label>
                            <textarea  name="address" id="address" class="form-control" ></textarea>
                            @error('address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            
                            <button type="button" class="btn  btn-dark mt-2" onclick="return $('#products_model').modal('show');">Add Product</button>
                            <div class="row">
                                <input type="text" name="prod" id="prod" style="opacity: 0;position: absolute;">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            
                        </div>
                        
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
                        <th>Quantity</th>
                        <th>Add</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key => $item)
                        <tr>
                            <td><input type="checkbox" class="multiple_item_select" value="{{$item->id}}"></td>
                            
                            <td>{{$item->item->category->name}}
                            <input type="hidden" id="modal_prod_cat_{{$item->id}}" value="{{$item->item->category->name}}">
                            </td>
                            <td>{{$item->item->name}}
                            <input type="hidden" id="modal_prod_name_{{$item->id}}" value="{{$item->item->name}}">
                            </td>
                            
                            <td>
                                {{$item->price}}
                                <input type="hidden" id="modal_prod_price_{{$item->id}}" value="{{$item->price}}">
                            </td>
                            <td>
                                {{$item->prod_quantity}}
                                <input type="hidden" id="modal_prod_qty_{{$item->id}}" value="{{$item->prod_quantity}}">
                            </td>
                            
                            <td>

                                <div class="d-flex">
                                    <button type="button" class="inc_dec_btn btn btn-dark btn-rounded">-</button>
                                    <input type="number" value="0" min="0" max="{{$item->prod_quantity}}" class="form-control col-md-2 ml-2 mr-2" id="item_prod_{{$item->id}}" onchange="calculate_all_select()">
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
                    <label class="m-0">Total Price:</label> <span id="modal_total_price"></span>
                </div>
                <div class="col-md-6">
                    <label class="m-0">Total Quantity:</label><span id="modal_total_quantity"></span>
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
@endsection