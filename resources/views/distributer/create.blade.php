@extends('layouts.master')
@section('title', 'Create Stock Distribution')

@push('style')

@endpush

@push('custom-scripts')
    
    <script>
        $(function() {
            
            jQuery('#hsn_form').validate({ // initialize the plugin
                rules: {

                    
                    hsn:{
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
                    else{
                        error.insertAfter(element);
                    }
                        
                }
            });
        });

        $("#role_id").on('change',function(){
            var value= this.value;

            if(value != ''){
                $.ajax({
                    type:'GET',
                    dataType: 'json',
                    url: '{{url("/get/users/by/role")}}',
                    data: {'role_id':value},
                    success: function(result){
                        $("#user_id").empty();
                        var str = '<option value="">Select User</option>';

                        $.each(result.data,function(ind,value){
                            str += '<option value="'+value.id+'">'+value.name+'</option>';
                        })

                        $("#user_id").append(str);
                    },
                    error: function(error){
                        alert(error.responseText);
                    }
                })
            }
        })
        
        $("#item_id").on('change',function(){
            var value= this.value;

            if(value != ''){
                $.ajax({
                    type:'GET',
                    dataType: 'json',
                    url: '{{url("get/stock/item/details")}}',
                    data: {'item_id':value},
                    success: function(result){
                        $("#item_user_price").val(result.data.price_for_user);
                        $("#stock_price").text('Rs.'+result.data.price_for_user);
                    },
                    error: function(error){
                        alert(error.responseText);
                    }
                })
            }
        })

        $("#distributed_quantity,#item_id").on('change',function(){
            calculate_total();
        })

        function calculate_total(){
            var prod_quantity = $("#distributed_quantity").val();
            var prod_price = $("#item_user_price").val();

            var calc_total = (parseInt(prod_quantity)*parseFloat(prod_price)).toFixed(2);
            
            var total_price = $("#total_cost").val(calc_total);
        }

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
                <h4 class="card-title">Create Stock Distribution</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('stock-distributions')}}" class="btn btn-inverse-primary btn-sm"><i class="mdi mdi-redo-variant"></i>{{__("Back")}}</a>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <form id="hsn_form" method="post" enctype="multipart/form-data" action="{{url('stock-distributions')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                
                <div class="row">
                    
                    <div class="col-md-6">
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
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Select User: <span class="required">*</span>
                            </label>
                            <select name="user_id" id="user_id" class="form-control select2" >
                                <option value=""> Select User </option>
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <input type="hidden" id="item_user_price">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Select Item: <span class="required">*</span>
                            </label>
                            <select name="item_id" id="item_id" class="form-control select2" >
                                <option value=""> Select Item </option>
                                @foreach( $items as $i_ind => $i)
                                    <option value = "{{$i->id}}">{{$i->name}}</option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <p><b>Price: </b> <span id="stock_price"></span> </p>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Product Quantity: <span class="required">*</span>
                            </label>
                            <input type="text" name="distributed_quantity" id="distributed_quantity" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" >
                            @error('item_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Total Cost: <span class="required">*</span>
                            </label>
                            <input type="number" name="total_cost" id="total_cost" class="form-control" readonly >
                            @error('item_id')
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