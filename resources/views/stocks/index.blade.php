@extends('layouts.master')
@section('title', 'Stock Summary')

@push('style')
<style>
    @media screen and (min-device-width : 1024px)  {
        .stock-res{
            width: fit-content;
        }
    }
    
</style>
    
@endpush

@push('custom-scripts')
    <script>
        var gst_percent = 0;
        var gst_percent_upd = 0;
    </script>
    {!! Html::script('/js/common.js') !!}
    <script>
        $(function() {
            $("#stock_table").DataTable();
            
            jQuery('#stock_form').validate({ // initialize the plugin
                rules: {
                    category_id:{
                        required:true
                    },
                    item_id:{
                        required:true
                    },
                    prod_quantity:{
                        required:true,
                    },
                    prod_price:{
                        required:true,
                    },
                    total_price:{
                        required:true,
                    },
                    per_freight_price:{
                        required:true,
                    },
                    user_percent:{
                        required:true
                    },
                    final_price:{
                        required:true
                    },

                    date_of_purchase:{
                        required:true
                    },
                    price_for_user:{
                        required:true
                    },
                    vendor_id:{
                        required:true
                    },
                    
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
            
            jQuery('#stock_form_upd').validate({ // initialize the plugin
                rules: {
                    category_id:{
                        required:true
                    },
                    item_id:{
                        required:true
                    },
                    prod_quantity:{
                        required:true,
                    },
                    prod_price:{
                        required:true,
                    },
                    total_price:{
                        required:true,
                    },
                    per_freight_price:{
                        required:true,
                    },
                    user_percent:{
                        required:true
                    },
                    final_price:{
                        required:true
                    },

                    date_of_purchase:{
                        required:true
                    },
                    price_for_user:{
                        required:true
                    },
                    vendor_id:{
                        required:true
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
        
        function edit_stock_modal(m_id){
            var submit_edit_url = '{{url("stocks")}}/'+m_id;
            var get_edit_url = submit_edit_url +'/edit';
            
            $.ajax({
                type:"GET",
                dataType:"JSON",
                url:get_edit_url,
                success:function(result){

                    if(result != ''){
                        var inputs = result.stock;
                        $('#stock_form_upd').attr('action',submit_edit_url);
                        $('#category_id_upd').val(inputs.item.category_id).trigger('change');
                        $('#item_id_upd').val(inputs.item_id).trigger('change');
                        if(result.image != ''){
                            $('#item_img_upd').attr('src',result.image);
                        }
                        $("#gst_id_upd").val(inputs.item.gst_percent_id).trigger('change');
                        $("#hsn_id_upd").val(inputs.item.hsn_id).trigger('change');
                        $("#prod_quantity_upd").val(inputs.prod_quantity);
                        $("#prod_price_upd").val(inputs.prod_price);
                        $("#total_price_upd").val(inputs.total_price);
                        $("#note_perc_upd").text(inputs.item.gst_percent.percent);
                        $("#per_freight_price_upd").val(inputs.per_freight_price);
                        $("#user_percent_upd").val(inputs.user_percent);
                        $("#final_price_upd").val(inputs.final_price);
                        $("#price_for_user_upd").val(inputs.price_for_user);
                        $("#date_of_purchase_upd").val(inputs.date_of_purchase);
                        $("#vendor_id_upd").val(inputs.vendor_id).trigger('change');
                        $("#description_upd").val(inputs.description);
                        $("#stock_edit_modal").modal('show');
                        gst_percent_upd = inputs.item.gst_percent.percent;
                    }else{
                        alert('some error occured, please refresh page and try again');
                    }

                },
                error:function(error){
                    console.log(error.responseText);
                }
            })
        }
    </script>
    {!! Html::script('/js/stock.js') !!}
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12" >
    @include('flash-msg')
  </div>
</div>

@include('stocks.list')
@include('stocks.create')
@include('stocks.edit')
@foreach($stocks as $h)
    <div id="{{$h->id}}_stocks" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this stock? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/stocks/'.$h->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                                
                            
            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    <div id="{{$h->id}}_stock_history" class=" modal fade" role="dialog">
        <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content " style="    ">
            <div class="modal-header">
                <h4 class="modal-heading">Stock History</h4>
                <button type="button" class="close m-0 p-0" data-dismiss="modal">&times;</button> 
            
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive table-bordered table-warning">
                            <thead>
                                <tr>
                                    <th>Price</th>
                                    <th>User Price</th>
                                    <th>Added</th>
                                    <th>Total Quantity</th>
                                    <th>Remaining</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($h->history as $h_id => $h_data)
                                <tr>
                                    <td>
                                        <small>
                                            <p>Rs. {{$h_data->final_price}}</p>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <b>Product Price :</b>
                                                    <span>Rs. {{$h_data->prod_price}}</span>
                                                </div>
                                                <div class="col-md-12">
                                                    <b>GST :</b>
                                                    <span>{{$h_data->gst}}%</span>
                                                </div>
                                                <div class="col-md-12">
                                                    <b>Fright :</b>
                                                    <span>Rs. {{$h_data->per_freight_price}}</span>
                                                </div>
                                            </div>
                                        </small>
                                    </td>
                                    <td>
                                        Rs. {{$h_data->price_for_user}}
                                    </td>
                                    <td>
                                        {{$h_data->prod_quantity}}
                                    </td>
                                    <td>
                                        {{$h_data->total_qty}}
                                    </td>
                                    <td>
                                        {{ array_key_exists($h_id-1,$h->history->toArray()) ? $h->history[$h_id-1]['total_qty'] - $h->history[$h_id-1]['prod_quantity'] : '-'}}
                                    </td>
                                    <td>
                                        {{date('d-m-Y h:i A',strtotime($h_data->created_at))}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">Close</button>
                
            </div>
        </div>
        </div>
    </div>
@endforeach
@endsection