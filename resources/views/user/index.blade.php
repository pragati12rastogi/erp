@extends('layouts.master')
@section('title', 'User Creation')

@push('style')

@endpush

@push('custom-scripts')
{!! Html::script('/js/users.js') !!}
{!! Html::script('/js/area_district.js') !!}
<script>
    $(function() {   
        jQuery('#user_form_upd').validate({ // initialize the plugin
                rules: {
        
                    role: {
                        required: true,
                    },
                    name:{
                        required:true,
                    },
                    email:{
                        required:true,
                    },
                    mobile:{
                        required:true,
                    },
                    firm_name:{
                        required:true
                    },
                    gst_no:{
                        required:true
                    },
                    state_id:{
                        required:true
                    },
                    district:{
                        required:true
                    },
                    area_id:{
                        required:true
                    },
                    address:{
                        required:false
                    },
                    bank_name:{
                        required:true
                    },
                    name_on_passbook:{
                        required:true
                    },
                    ifsc:{
                        required:true
                    },
                    account_no:{
                        required:true
                    },
                    pan_no:{
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
                    else{
                        error.insertAfter(element);
                    }
                        
                }
            });
        });

    function edit_users_modal(edit_id){
        var submit_edit_url = '{{url("users")}}/'+edit_id;
        var get_edit_url = submit_edit_url +'/edit';
        
        $.ajax({
            type:"GET",
            dataType:"JSON",
            url:get_edit_url,
            success:function(result){

                if(result != ''){
                    var inputs = result.user;
                    $('#user_form_upd').attr('action',inputs.edit_url);

                    $('#role_upd').val(inputs.role_name).trigger('change');
                    $('#name_upd').val(inputs.name);
                    $('#email_upd').val(inputs.email);
                    $('#mobile_upd').val(inputs.mobile);
                    $('#firm_name_upd').val(inputs.firm_name);
                    $('#gst_no_upd').val(inputs.gst_no);
                    $('#address_upd').val(inputs.address);
                    $('#bank_name_upd').val(inputs.bank_name);
                    $('#name_on_passbook_upd').val(inputs.name_on_passbook);
                    $('#ifsc_upd').val(inputs.ifsc);
                    $('#account_no_upd').val(inputs.account_no);
                    $('#pan_no_upd').val(inputs.pan_no);
                    $('#state_id_upd').val(inputs.state_id).trigger('change');
                    
                    if(inputs.p_image != ''){
                        $('#image_upd').attr('src',inputs.p_image);
                    }

                    
                    $("#user_edit_modal").modal('show');
                    
                    setTimeout(() => {
                        $('#district_id_upd').val(inputs.district).trigger('change')
                    }, 500);

                    setTimeout(() => {
                        $('#area_id_upd').val(inputs.area_id).trigger('change')
                    }, 1000);

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
    <div class="col-md-12">
      
        @include('flash-msg')
      
    </div>
</div>

@include('user.list')
@include('user.add')
@include('user.edit')
@foreach($users as $user)
    <div id="{{$user->id}}_user" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this User? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/users/'.$user->id)}}" class="pull-right">
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