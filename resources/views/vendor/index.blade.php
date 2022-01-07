@extends('layouts.master')
@section('title', 'Vendor Summary')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#vendor_table").DataTable();

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

            @foreach($vendors as $vendor)
            jQuery('#vendor_form_{{$vendor->id}}').validate({ // initialize the plugin
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
            @endforeach
        });
        
    </script>
@endpush

@section('content')

@include('vendor.list')
@include('vendor.create')

@foreach($vendors as $vendor)
    <div id="{{$vendor->id}}_vendor" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this vendor? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/vendors/'.$vendor->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                                
                            
            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
            </form>
            </div>
        </div>
        </div>
    </div>
  @include('vendor.edit')
@endforeach
@endsection