@extends('layouts.master')
@section('title', 'Add Role')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            jQuery('#role_form').validate({ // initialize the plugin
                rules: {

                    name: {
                        required: true,
                    },
                    'permission[]':{
                        required: true
                    }
                }
            });

        });

        $(".all_select_permission").click(function(){
            var check_status = this.checked;
            var data_id = $(this).attr('id');
            $("."+data_id).prop('checked', this.checked);
        })

        $(".sub_permission").click(function(){
            var check_status = this.checked;
            var get_class = $(this).attr('class');
            var split_get_class = get_class.split(' ');
            var sub_per_name = split_get_class[1];

            var count_length = $('.'+sub_per_name).length;
            var count_checked_length = $('.'+sub_per_name+':checked').length;

            if(count_length == count_checked_length ){
                $('#'+sub_per_name).prop('checked', true);
            }else{
                $('#'+sub_per_name).prop('checked', false);
            }
        })

    </script>
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-10">
                <h4 class="card-title">Add Role</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a class="btn btn-inverse-primary btn-sm" href="{{ route('roles.index') }}"><i class="mdi mdi-redo-variant"></i> Back</a>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
          <form id="role_form" method="post" enctype="multipart/form-data" action="{{url('roles')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permission:</strong>
                            <br/>
                            <div class="row">
                            @foreach($permission as $value)
                                @php 
                                    $permission_ids = explode(',',$value->sub_permission_id);
                                    $permission_name = explode(',',$value->sub_permission_name);
                                    $sub_permissions = array_combine($permission_ids,$permission_name);
                                @endphp
                                <ul class="col-md-6 list-unstyled">
                                    <li>
                                        <label> <input type="checkbox" class="all_select_permission" id="all_{{ $value->master_name }}"> {{ $value->master_name }}</label>
                                        <ul style="list-style: none;">
                                            @foreach($sub_permissions as $p_id => $p_name)
                                                <li><label >{{ Form::checkbox('permission[]', $p_id, false, array('class' => 'sub_permission all_'.$value->master_name )) }}
                                                {{ $p_name }}</label></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                                
                            @endforeach
                            
                            </div>
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