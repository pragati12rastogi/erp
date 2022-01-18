@extends('layouts.master')
@section('title', 'Product Charge Creation')

@push('style')

@endpush

@push('custom-scripts')
    {!! Html::script('/js/area_district.js') !!}
    <script>
        $(function() {
            $("#product_charge_table").DataTable({
                dom: 'Blfrtip',
                buttons: [
                    {
                    extend:'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2,3,4,5,6 ] 
                    }
                    },
                    {
                    extend:'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2,3,4,5,6 ] //Your Column value those you want
                        }
                    }
                ]
            });
            jQuery('#product_charge_form').validate({ // initialize the plugin
                rules: {

                    state_id:{
                        required:true
                    },
                    district_id:{
                        required:true
                    },
                    area_id:{
                        required:true
                    },
                    product_id:{
                        required:true,
                    },
                    charges:{
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

            jQuery('#product_charge_form_upd').validate({ // initialize the plugin
                rules: {

                    state_id:{
                        required:true
                    },
                    district_id:{
                        required:true
                    },
                    area_id:{
                        required:true
                    },
                    product_id:{
                        required:true,
                    },
                    charges:{
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
        
        function edit_product_charge_modal(edit_id){
            var submit_edit_url = '{{url("product_charge")}}/'+edit_id;
            var get_edit_url = submit_edit_url +'/edit';
            
            $.ajax({
                type:"GET",
                dataType:"JSON",
                url:get_edit_url,
                success:function(result){

                    if(result != ''){
                        var inputs = result.product_charge;
                        $('#product_charge_form_upd').attr('action',submit_edit_url);
                        $('#state_id_upd').val(inputs.state_id).trigger('change');
                        $('#product_id_upd').val(inputs.product_id).trigger('change');
                        
                        $('#charges_upd').val(inputs.charges);
                        $("#product_charge_edit_modal").modal('show');
                        
                        setTimeout(() => {
                            $('#district_id_upd').val(inputs.district_id).trigger('change')
                        }, 500);

                        setTimeout(() => {
                            $('#area_id_upd').val(inputs.area_id).trigger('change')
                        }, 900);

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
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 ">
        @include('flash-msg')
    </div>
</div>
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
    
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-10">
                <h4 class="card-title">Product Charge Summary</h4>
            </div>
            @if(Auth::user()->hasPermissionTo('product_charge.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN) )
            <div class="col-md-2 text-right" >
              <button onclick='return $("#add_product_charge_modal").modal("show");' class="btn btn-inverse-primary btn-sm">{{__("Add Product Charge")}}</button>
            </div>
            @endif
        </div>
        
        <div class="table-responsive">
          <table id="product_charge_table" class="table ">
            <thead>
              <tr>
                <th>Sr.no.</th>
                <th>State Name</th>
                <th>District Name</th>
                <th>Area Name</th>
                <th>Product</th>
                <th>Product Charge</th>
                <th>Created At</th>
                
                @if(Auth::user()->hasPermissionTo('product_charge.edit') || Auth::user()->hasPermissionTo('product_charge.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                <th>Action</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach($product_charge as $key => $d)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$d->state->name}}</td>
                    <td>{{$d->district->name}}</td>
                    <td>{{$d->area->name}}</td>
                    <td>{{$d->product->name}}</td>
                    <td>{{$d->charges}}</td>
                    
                    <td>{{date('d-m-Y',strtotime($d->created_at))}}</td>
                    
                    @if(Auth::user()->hasPermissionTo('product_charge.edit') || Auth::user()->hasPermissionTo('product_charge.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                
                    <td>
                      @if(Auth::user()->hasPermissionTo('product_charge.edit') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                      
                        <a onclick='edit_product_charge_modal("{{$d->id}}")' class="btn btn-success text-white">
                            <i class="mdi mdi-pen"></i>
                        </a>
                      @endif
                      @if(Auth::user()->hasPermissionTo('product_charge.destroy') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN))
                      
                        <a onclick='return $("#{{$d->id}}_product_charge").modal("show");' class="btn btn-danger text-white">
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



@include('product_charge.add')
@include('product_charge.edit')
@foreach($product_charge as $d)
    <div id="{{$d->id}}_product_charge" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this product charge? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/product_charge/'.$d->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                                
                            
            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    
@endforeach

@endsection