@extends('layouts.master')
@section('title', 'User Creation')

@push('style')

@endpush

@push('custom-scripts')
{!! Html::script('/js/users.js') !!}

<script>
    $(function() {   
        @foreach($users as $user)
            jQuery('#user_form_{{$user->id}}').validate({ // initialize the plugin
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

<div class="row">
    <div class="col-md-12">
      
        @include('flash-msg')
      
    </div>
</div>

@include('user.list')
@include('user.add')

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
    @include('user.edit')
@endforeach

@endsection